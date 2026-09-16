<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Produto</title>
</head>
<body>

    <h1>Detalhes do Produto</h1>

    <p><strong>Nome:</strong> {{ $product->name }}</p>

    <p><strong>Descrição:</strong> {{ $product->description }}</p>

    <p><strong>Preço:</strong> R$ {{ number_format($product->price, 2, ',', '.') }}</p>

    <p><strong>Estoque:</strong> {{ $product->stock }}</p>

    <p>
        <strong>Status:</strong>

        @if($product->is_active)
            Ativo
        @else
            Inativo
        @endif
    </p>

    <br>

    <a href="{{ route('products.index') }}">
        Voltar para produtos
    </a>

</body>
</html>
