<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'orderCount' => Order::count(),
            'userCount' => User::count(),
            'recentOrders' => Order::with(['user', 'status'])->orderBy('created_at', 'desc')->take(5)->get(),
        ]);
    }


    public function order(Order $order)
    {
        return view('admin.order.show', ['order' => $order]);
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully');
    }

    public function updateOrder(Order $order, Request $request)
    {
        $validate = $request->validate(['status_id' => 'required|exists:statuses,id']);
        $order->status_id = $validate['status_id'];
        $order->update();
        return redirect()->route('admin.orders')->with('success', 'Order updated successfully');
    }
}
