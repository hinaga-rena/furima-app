<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'フリマアプリ')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        header {
            background-color: black;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .search-box input {
            padding: 10px;
            font-size: 14px;
        }

        main {
            padding: 20px;
        }

        button {
            padding: 6px 12px;
            margin-left: 10px;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
    @yield('style')
</head>

<body>
<header>
    <span class="logo">
        <img src="/images/logo.svg" alt="ロゴ" style="height:40px;">
    </span>

    <div class="search-box">
        <form method="GET" action="{{ url()->current() }}">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
        </form>
    </div>

    <div>
        @auth
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">
                    ログアウト
                </button>
            </form>
            <a href="{{ route('mypage') }}" style="margin-left: 10px;">マイページ</a>
            <a href="{{ route('products.create') }}">
                <button>出品</button>
            </a>
        @else
            <a href="{{ route('login') }}">ログイン</a>
        @endauth
    </div>
</header>

<main>
    @yield('content')
</main>

</body>
</html>