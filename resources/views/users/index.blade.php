<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>

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
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
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

        .role {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .admin {
            background: #ede9fe;
            color: #6d28d9;
        }

        .manager {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .client {
            background: #e5e7eb;
            color: #374151;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-back {
            background: #e5e7eb;
            color: #374151;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @include('layouts.navigation')
    <div class="container">

        <div class="header">
            <h1>Usuários</h1>
            <div class="subtitle">
                Gerenciamento de usuários e níveis de acesso
            </div>
        </div>

        @if(session('sucesso'))
            <div class="success">
                {{ session('sucesso') }}
            </div>
        @endif

        <div class="card">

            <table>

                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $user)

                        <tr>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                @if($user->role === 'admin')
                                    <span class="role admin">
                                        Administrador
                                    </span>
                                @elseif($user->role === 'gerente')
                                    <span class="role manager">
                                        Gerente
                                    </span>
                                @else
                                    <span class="role client">
                                        Cliente
                                    </span>
                                @endif

                            </td>

                            <td>
                                <a href="/users/{{ $user->id }}/edit"
                                   class="btn btn-edit">
                                    Editar cargo
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <a href="{{ route('products.index') }}" class="btn btn-back">
            ← Voltar para produtos
        </a>

    </div>

</body>
</html>
