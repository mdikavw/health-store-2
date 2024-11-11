<div style="padding: 20px; background-color: #ffffff; border-radius: 10px; font-family: Arial, sans-serif; color: #333;">
    <div style="text-align: center;">
        <h1 style="font-size: 24px; font-weight: bold;">Invoice</h1>
        <p style="color: #888;">Order ID: {{ $order->id }}</p>
    </div>
    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <div style="width: 45%;">
            <h3 style="font-size: 16px; font-weight: bold;">Billing Information</h3>
            <p><strong>{{ $order->user->name }}</strong></p>
            <p>{{ $order->user->email }}</p>
            <p>{{ $order->user->phone }}</p>
            <p>{{ $order->address }}</p>
        </div>
        <div style="width: 45%;">
            <h3 style="font-size: 16px; font-weight: bold;">Order Date</h3>
            <p>{{ $order->created_at->format('d M, Y') }}</p>
            <h3 style="font-size: 16px; font-weight: bold; margin-top: 20px;">Payment Method</h3>
            <p>{{ $order->paymentMethod->payment_name }}</p>
        </div>
    </div>
    <div style="margin-top: 40px;">
        <h3 style="font-size: 16px; font-weight: bold;">Order Details</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="border-bottom: 1px solid #ddd;">
                <tr>
                    <th style="text-align: left; padding: 8px;">Product</th>
                    <th style="text-align: left; padding: 8px;">Price</th>
                    <th style="text-align: left; padding: 8px;">Quantity</th>
                    <th style="text-align: left; padding: 8px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 8px;">{{ $orderItem->product->name }}</td>
                        <td style="padding: 8px;">IDR
                            {{ number_format($orderItem->price / $orderItem->quantity, 0, ',', '.') }}</td>
                        <td style="padding: 8px;">{{ $orderItem->quantity }}</td>
                        <td style="padding: 8px;">IDR {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 40px;">
        <h3 style="font-size: 16px; font-weight: bold;">Summary</h3>
        <div style="display: flex; justify-content: space-between;">
            <div style="font-size: 16px; font-weight: bold;">Total Amount</div>
            <div style="font-size: 16px; font-weight: bold;">IDR {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
    </div>
    <div style="margin-top: 40px; text-align: center;">
        <p style="color: #888;">Thank you for shopping with us!</p>
        <p style="color: #888;">If you have any questions about this invoice, please contact us.</p>
    </div>
</div>
