<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Status;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class OrderController extends Controller
{
    private $conversionRate = 15654.20;

    private function convertIDRToUSD($amountInIDR)
    {
        return $amountInIDR / $this->conversionRate;
    }
    public function createPayPalPayment(Order $order)
    {
        $amountInUSD = $this->convertIDRToUSD($order->total);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $provider->setAccessToken($paypalToken);

        try
        {
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($amountInUSD, 2, '.', ''),  // Format to 2 decimal places
                        ],
                        "description" => "Order #{$order->id} - Payment for products",
                    ]
                ],
                "application_context" => [
                    "cancel_url" => route('payment.cancel', ['order' => $order->id]),
                    "return_url" => route('payment.success', ['order' => $order->id]),
                ]
            ]);

            if (isset($response['id']))
            {
                foreach ($response['links'] as $link)
                {
                    if ($link['rel'] === 'approve')
                    {
                        return redirect()->away($link['href']);
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            return redirect()->route('orders.index')->with('error', 'Something went wrong while processing PayPal payment: ' . $e->getMessage());
        }

        return redirect()->route('orders.index')->with('error', 'Something went wrong while processing PayPal payment.');
    }

    public function paymentCancel()
    {
        return redirect()->route('orders.index')->with('error', 'Payment was canceled.');
    }


    public function paymentSuccess(Request $request, Order $order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $provider->setAccessToken($paypalToken);

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED')
        {
            $order->status_id = 2;
            $order->save();

            return redirect()->route('orders.invoice', ['order' => $order])
                ->with('success', 'Payment successful');
        }

        return redirect()->route('orders.index')->with('error', 'Payment failed.');
    }

    public function confirmation(Request $request)
    {
        $user = Auth::user();

        if (empty($user->phone) || empty($user->address))
        {
            return redirect()->route('profile.show')->with('error', 'Please update your phone number and address before checking out.');
        }
        $validate = $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:cart_items,id'
        ]);
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems = $cart->cartItems()->whereIn('id', $validate['selected_items'])->get();
        return view('orders.confirmation', ['cart_items' => $cartItems]);
    }

    public function checkout(Request $request)
    {
        $validate = $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:cart_items,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems = $cart->cartItems()->whereIn('id', $validate['selected_items'])->get();

        foreach ($cartItems as $cartItem)
        {
            if ($cartItem->product->stock < $cartItem->quantity)
            {
                return redirect()->route('user.cart')->with('error', 'Insufficient stock for ' . $cartItem->product->name);
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $cartItems->sum(function ($item)
            {
                return $item->product->price * $item->quantity;
            }),
            'payment_method_id' => $validate['payment_method_id'],
            'status_id' => 1,
            'address' => Auth::user()->address
        ]);

        foreach ($cartItems as $cartItem)
        {
            $product = Product::find($cartItem->product_id);
            $product->decrement('stock', $cartItem->quantity);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->quantity * $product->price
            ]);
            $cartItem->delete();
        }

        $paymentMethod = PaymentMethod::find($validate['payment_method_id']);
        if ($paymentMethod->name == 'paypal')
        {
            return $this->createPayPalPayment($order);
        }

        return redirect()->route('orders.show', ['order' => $order])
            ->with('success', 'Checkout successful');
    }

    public function buyNow(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::create($validate);

        return view('orders.confirmation', ['cart_items' => [$cartItem]]);
    }

    public function payment(Request $request)
    {
        // Validate the request to ensure an order ID exists
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::find($validate['order_id']);

        if ($order->paymentMethod->name == 'cod')
        {
            $order->status_id = 2;
            $order->save();

            return redirect()->route('orders.invoice', ['order' => $order])
                ->with('success', 'Payment successful and invoice generated for COD.');
        }
        $order->status_id = 2;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Payment successful');
    }

    public function invoice(Order $order)
    {
        if (Auth::id() !== $order->user_id && Auth::user()->role->name !== 'admin')
        {
            return redirect()->route('orders.index')->with('error', 'You do not have permission to view this invoice.');
        }

        return view('orders.invoice', ['order' => $order]);
    }

    public function downloadInvoice(Order $order)
    {
        if (Auth::id() !== $order->user_id && Auth::user()->role->name !== 'admin')
        {
            return redirect()->route('orders.index')->with('error', 'You do not have permission to download this invoice.');
        }
        $pdf = Pdf::loadView('partials.invoice', ['order' => $order]);

        return $pdf->download('invoice_' . $order->id . '.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role->name === 'admin')
        {
            $statuses = Status::all();
            $orders = Order::with(['user', 'status'])->get();
            return view('admin.orders.index', ['orders' => $orders, 'statuses' => $statuses]);
        }
        return view('orders.index', ['orders' => $user->orders]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
