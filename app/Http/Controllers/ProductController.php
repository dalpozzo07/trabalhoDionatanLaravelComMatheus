<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

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

        $dados['active'] = $request->boolean('active');

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
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        $dados['active'] = $request->boolean('active');

        $product->update($dados);

        return redirect()
            ->route('products.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('sucesso', 'Produto excluído com sucesso!');
    }
}
