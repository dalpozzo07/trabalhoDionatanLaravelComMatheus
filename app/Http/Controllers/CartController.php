<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;

        if (!$product->active) {
            return back()->with('erro', 'Produto indisponível.');
        }

        if ($product->stock < $quantity) {
            return back()->with('erro', 'Estoque insuficiente.');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $novaQuantidade = $item->quantity + $quantity;

            if ($novaQuantidade > $product->stock) {
                return back()->with('erro', 'Quantidade maior que o estoque disponível.');
            }

            $item->update([
                'quantity' => $novaQuantidade,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('sucesso', 'Produto adicionado ao carrinho!');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->quantity > $item->product->stock) {
            return back()->with('erro', 'Quantidade maior que o estoque disponível.');
        }

        $item->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()
            ->route('cart.index')
            ->with('sucesso', 'Quantidade atualizada!');
    }

    public function remove(CartItem $item)
    {
        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return redirect()
            ->route('cart.index')
            ->with('sucesso', 'Produto removido do carrinho!');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()
            ->route('cart.index')
            ->with('sucesso', 'Carrinho limpo!');
    }
}