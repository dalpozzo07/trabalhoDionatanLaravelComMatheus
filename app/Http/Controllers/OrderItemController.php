<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::with(['order', 'product'])->get();

        return view('order_items.index', compact('items'));
    }

    public function create()
    {
        return view('order_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        OrderItem::create($request->all());

        return redirect()
            ->route('order-items.index')
            ->with('sucesso', 'Item adicionado ao pedido!');
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);

        return view('order_items.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        return view('order_items.edit', compact('orderItem'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()
            ->route('order-items.index')
            ->with('sucesso', 'Item atualizado com sucesso!');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()
            ->route('order-items.index')
            ->with('sucesso', 'Item removido do pedido!');
    }
}