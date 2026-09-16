<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
</head>
<body>

    <h1>Lista de Produtos</h1>

    @if(session('sucesso'))
        <p>{{ session('sucesso') }}</p>
    @endif

    @if($products->count() > 0)

        <table border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>

                        <td>
                            @if($product->is_active)
                                Ativo
                            @else
                                Inativo
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('products.show', $product) }}">
                                Ver
                            </a>

                            @if(auth()->user()->role === 'admin')
                                |
                                <a href="{{ route('products.edit', $product) }}">
                                    Editar
                                </a>

                                |

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit">
                                        Excluir
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p>Nenhum produto cadastrado.</p>
    @endif

    <br>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('products.create') }}">
            Cadastrar novo produto
        </a>
    @endif

</body>
</html>