<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
</head>

<body>

    <h1>Gerenciar Usuários</h1>

    @if(session('sucesso'))
        <p>{{ session('sucesso') }}</p>
    @endif

    <table border="1">
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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    <td>
                        <a href="/users/{{ $user->id }}/edit">
                            Editar cargo
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <a href="{{ route('products.index') }}">
        Voltar para produtos
    </a>

</body>

</html>
