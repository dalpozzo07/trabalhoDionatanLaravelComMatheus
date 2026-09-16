<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $dados = $request->validated();

        $dados['is_active'] = $request->boolean('is_active');

        Product::create($dados);

        return redirect()
            ->route('products.index')
            ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', $product);

        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $dados['is_active'] = $request->boolean('is_active');

        $product->update($dados);

        return redirect()
            ->route('products.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('sucesso', 'Produto excluído com sucesso!');
    }
}
