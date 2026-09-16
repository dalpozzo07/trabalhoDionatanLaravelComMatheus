<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            font-size: 30px;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 6px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            background: #f9fafb;
            color: #6b7280;
            font-size: 14px;
            padding: 14px;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f9fafb;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            white-space: nowrap;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-view {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .footer-actions {
            margin-top: 20px;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    @include('layouts.navigation')
    <div class="container">

        <div class="header">
            <div>
                <h1>Produtos</h1>
                <div class="subtitle">Gerenciamento de produtos</div>
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    + Novo produto
                </a>
            @endif
        </div>

        @if(session('sucesso'))
            <div class="success">
                {{ session('sucesso') }}
            </div>
        @endif

        <div class="card">

            @if($products->count() > 0)

                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
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
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                </td>

                                <td>
                                    {{ $product->description }}
                                </td>

                                <td>
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </td>

                                <td>
                                    {{ $product->stock }}
                                </td>

                                <td>
                                    @if($product->is_active)
                                        <span class="status active">Ativo</span>
                                    @else
                                        <span class="status inactive">Inativo</span>
                                    @endif
                                </td>

                                <td class="actions">

                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-view">
                                        Ver
                                    </a>

                                    @if(in_array(auth()->user()->role, ['admin', 'gerente']))
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-edit">
                                            Editar
                                        </a>
                                    @endif

                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('products.destroy', $product) }}"
                                              method="POST"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-delete"
                                                    onclick="return confirm('Deseja realmente excluir este produto?')">
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

                <div class="empty">
                    <h3>Nenhum produto cadastrado</h3>
                    <p>Não existem produtos disponíveis no momento.</p>
                </div>

            @endif

        </div>

        <div class="footer-actions">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="btn btn-view">
                    Gerenciar usuários
                </a>
            @endif
        </div>

    </div>

</body>
</html>
