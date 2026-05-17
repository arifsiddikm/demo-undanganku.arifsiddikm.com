<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['package', 'bankAccount'])
            ->latest()
            ->paginate(10);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['package', 'bankAccount'])
            ->findOrFail($id);

        return view('dashboard.orders.show', compact('order'));
    }
}
