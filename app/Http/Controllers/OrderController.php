<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $orders = Order::with(['user', 'items.product'])
                ->latest()
                ->get();
        } else {
            $orders = Order::with('items.product')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (
            auth()->user()->role !== 'admin' &&
            $order->user_id !== auth()->id()
        ) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('erro', 'Seu carrinho está vazio.');
        }

        foreach ($cart->items as $item) {
            if (!$item->product->active) {
                return back()->with(
                    'erro',
                    'Um dos produtos do carrinho não está mais disponível.'
                );
            }

            if ($item->quantity > $item->product->stock) {
                return back()->with(
                    'erro',
                    'Estoque insuficiente para o produto: ' . $item->product->name
                );
            }
        }

        $order = DB::transaction(function () use ($cart) {
            $total = 0;

            foreach ($cart->items as $item) {
                $total += $item->quantity * $item->product->price;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pendente',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                $item->product->decrement(
                    'stock',
                    $item->quantity
                );
            }

            $cart->items()->delete();

            return $order;
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('sucesso', 'Pedido realizado com sucesso!');
    }

    public function updateStatus(Order $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        request()->validate([
            'status' => 'required|in:pendente,pago,enviado,concluido,cancelado',
        ]);

        $order->update([
            'status' => request('status'),
        ]);

        return back()->with(
            'sucesso',
            'Status do pedido atualizado!'
        );
    }
}