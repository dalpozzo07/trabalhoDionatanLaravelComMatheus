<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>

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
            max-width: 700px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .info {
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .label {
            display: block;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 17px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
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
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
            margin-left: 8px;
        }
    </style>
</head>

<body>
    @include('layouts.navigation')
    <div class="container">

        <div class="card">

            <h1>Detalhes do Produto</h1>

            <div class="info">
                <span class="label">Nome</span>
                <span class="value">{{ $product->name }}</span>
            </div>

            <div class="info">
                <span class="label">Descrição</span>
                <span>{{ $product->description }}</span>
            </div>

            <div class="info">
                <span class="label">Preço</span>
                <span class="value">
                    R$ {{ number_format($product->price, 2, ',', '.') }}
                </span>
            </div>

            <div class="info">
                <span class="label">Estoque</span>
                <span class="value">{{ $product->stock }} unidades</span>
            </div>

            <div class="info">
                <span class="label">Status</span>

                @if($product->is_active)
                    <span class="status active">Ativo</span>
                @else
                    <span class="status inactive">Inativo</span>
                @endif
            </div>

            <div class="actions">

                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Voltar
                </a>

                @if(in_array(auth()->user()->role, ['admin', 'gerente']))
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-edit">
                        Editar produto
                    </a>
                @endif

            </div>

        </div>

    </div>

</body>
</html>
