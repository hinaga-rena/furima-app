<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール認証確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            background-color: #fff;
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
            max-width: 600px;
            margin: 100px auto;
            padding: 2rem;
            text-align: center;
        }

        p {
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .btn {
            background-color: #ccc;
            color: black;
            padding: 12px 28px;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #bbb;
        }

        .resend-link {
            margin-top: 2rem;
            display: block;
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .notice {
            color: green;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <header>
        <span class="logo">GT COACHTECH</span>
    </header>

    <div class="container">

        @if (session('status') == 'verification-link-sent')
            <p class="notice">新しい認証メールを送信しました。</p>
        @endif

        <p>
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn">認証はこちらから</button>
        </form>

        <a class="resend-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
            認証メールを再送する
        </a>
    </div>

</body>
</html>