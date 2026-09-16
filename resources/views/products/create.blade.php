<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
</head>
<body>

    <h1>Cadastrar Produto</h1>

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

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div>
            <label>Nome:</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <br>

        <div>
            <label>Descrição:</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label>Preço:</label>
            <input type="number" name="price" step="0.01" value="{{ old('price') }}">
        </div>

        <br>

        <div>
            <label>Estoque:</label>
            <input type="number" name="stock" value="{{ old('stock') }}">
        </div>

        <br>

        <div>
            <label>
                <input type="checkbox" name="is_active" value="1" checked>
                Produto ativo
            </label>
        </div>

        <br>

        <button type="submit">Cadastrar</button>

        <a href="{{ route('products.index') }}">
            Voltar
        </a>
    </form>

</body>
</html>
