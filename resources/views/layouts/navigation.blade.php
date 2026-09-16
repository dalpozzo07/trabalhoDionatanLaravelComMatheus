<style>
    .navbar {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 0 30px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand {
        font-size: 20px;
        font-weight: bold;
        color: #2563eb;
        text-decoration: none;
    }

    .navbar-links {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar-link {
        padding: 9px 14px;
        border-radius: 7px;
        text-decoration: none;
        color: #4b5563;
        font-size: 14px;
        font-weight: 600;
    }

    .navbar-link:hover {
        background: #f3f4f6;
        color: #2563eb;
    }

    .navbar-user {
        color: #6b7280;
        font-size: 14px;
        margin-left: 15px;
    }
</style>

<nav class="navbar">

    <a href="{{ route('dashboard') }}" class="navbar-brand">
        Sistema
    </a>

    <div class="navbar-links">

        <a href="{{ route('dashboard') }}" class="navbar-link">
            Dashboard
        </a>

        <a href="{{ route('products.index') }}" class="navbar-link">
            Produtos
        </a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('users.index') }}" class="navbar-link">
                Usuários
            </a>
        @endif

        <span class="navbar-user">
            {{ auth()->user()->name }}
        </span>

    </div>

</nav>
