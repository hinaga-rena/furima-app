<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000000;
            padding: 1rem;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .container {
            max-width: 400px;
            margin: 60px auto;
            padding: 2rem;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 1.2rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #ff5c5c;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 2rem;
            width: 100%;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ff3b3b;
        }

        .register-link {
            margin-top: 1.5rem;
            display: block;
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.85rem;
            margin-top: 0.2rem;
        }

        @media (min-width: 768px) and (max-width: 850px) {
            .container {
                max-width: 90%;
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.4rem;
            }

            .btn {
                font-size: 0.95rem;
            }
        }

        @media (min-width: 1400px) and (max-width: 1540px) {
            .container {
                max-width: 600px;
                padding: 3rem;
            }

            h2 {
                font-size: 1.8rem;
            }

            .btn {
                font-size: 1.1rem;
                padding: 14px;
            }
        }
    </style>
</head>
<body>

    <header>
        <span class="logo">
            <img src="/images/logo.svg" alt="ロゴ" style="height:40px;">
        </span>
    </header>

    <div class="container">
        <h2>ログイン</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn">ログインする</button>
        </form>

        <a class="register-link" href="{{ route('register') }}">会員登録はこちら</a>
    </div>

</body>
</html>