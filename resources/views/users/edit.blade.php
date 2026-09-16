<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>

    <h1>Editar Cargo do Usuário</h1>

    <p>
        <strong>Nome:</strong> {{ $user->name }}
    </p>

    <p>
        <strong>E-mail:</strong> {{ $user->email }}
    </p>

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

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="role">Cargo:</label>

        <select name="role" id="role">
            <option value="cliente" @if($user->role === 'cliente') selected @endif>
                Cliente
            </option>

            <option value="gerente" @if($user->role === 'gerente') selected @endif>
                Gerente
            </option>

            <option value="admin" @if($user->role === 'admin') selected @endif>
                Administrador
            </option>
        </select>

        <br><br>

        <button type="submit">
            Salvar alteração
        </button>

        <a href="{{ route('users.index') }}">
            Cancelar
        </a>
    </form>

</body>
</html>
