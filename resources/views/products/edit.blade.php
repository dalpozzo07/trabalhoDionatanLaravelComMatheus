<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>

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
            margin: 40px auto;
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
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox input {
            width: auto;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .errors ul {
            margin-bottom: 0;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 11px 18px;
            border-radius: 7px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }
    </style>
</head>

<body>
    @include('layouts.navigation')
    <div class="container">

        <div class="card">

            <h1>Editar Produto</h1>
            <p class="subtitle">Atualize as informações do produto.</p>

            @if($errors->any())
                <div class="errors">
                    <strong>Corrija os seguintes erros:</strong>

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

                <div class="field">
                    <label for="name">Nome</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                    >
                </div>

                <div class="field">
                    <label for="description">Descrição</label>

                    <textarea
                        id="description"
                        name="description"
                    >{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="field">
                    <label for="price">Preço</label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        step="0.01"
                        min="0"
                        value="{{ old('price', $product->price) }}"
                    >
                </div>

                <div class="field">
                    <label for="stock">Estoque</label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="{{ old('stock', $product->stock) }}"
                    >
                </div>

                <div class="checkbox">
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        @if($product->is_active) checked @endif
                    >

                    <label for="is_active">
                        Produto ativo
                    </label>
                </div>

                <div class="actions">

                    <button type="submit" class="btn btn-primary">
                        Salvar alterações
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>
</html>
