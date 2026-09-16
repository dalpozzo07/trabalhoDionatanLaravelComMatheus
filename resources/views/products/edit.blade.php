<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>

    <h1>Editar Produto</h1>

    @if($errors->any())
        <div>
            <h3>Erros encontrados:</h3>

            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nome:</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $product->name) }}"
            >
        </div>

        <br>

        <div>
            <label>Descrição:</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <br>

        <div>
            <label>Preço:</label>
            <input
                type="number"
                name="price"
                step="0.01"
                value="{{ old('price', $product->price) }}"
            >
        </div>

        <br>

        <div>
            <label>Estoque:</label>
            <input
                type="number"
                name="stock"
                value="{{ old('stock', $product->stock) }}"
            >
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @if($product->is_active) checked @endif
                >
                Produto ativo
            </label>
        </div>

        <br>

        <button type="submit">Salvar alterações</button>

        <a href="{{ route('products.index') }}">
            Cancelar
        </a>
    </form>

</body>
</html>
