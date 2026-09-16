<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>

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
            max-width: 650px;
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

        .user-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .user-info p {
            margin: 6px 0;
        }

        .label {
            color: #6b7280;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            background: white;
            font-size: 15px;
        }

        select:focus {
            outline: none;
            border-color: #2563eb;
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

            <h1>Editar cargo</h1>

            <div class="user-info">
                <p>
                    <span class="label">Nome:</span>
                    <strong>{{ $user->name }}</strong>
                </p>

                <p>
                    <span class="label">E-mail:</span>
                    {{ $user->email }}
                </p>
            </div>

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

            <form action="{{ route('users.update', $user) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="field">

                    <label for="role">
                        Nível de acesso
                    </label>

                    <select name="role" id="role">

                        <option value="cliente"
                            @if($user->role === 'cliente') selected @endif>
                            Cliente
                        </option>

                        <option value="gerente"
                            @if($user->role === 'gerente') selected @endif>
                            Gerente
                        </option>

                        <option value="admin"
                            @if($user->role === 'admin') selected @endif>
                            Administrador
                        </option>

                    </select>

                </div>

                <div class="actions">

                    <button type="submit" class="btn btn-primary">
                        Salvar alteração
                    </button>

                    <a href="{{ route('users.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>
</html>
