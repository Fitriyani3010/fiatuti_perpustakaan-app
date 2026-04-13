<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
        }

        /* OVERLAY biar lebih soft */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
        }

        .login-box {
            position: relative;
            width: 360px;
            padding: 30px;
            border-radius: 18px;
            background: rgba(101, 67, 33, 0.85);
            backdrop-filter: blur(12px);
            color: #fff;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            z-index: 1;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
            opacity: 0.85;
        }

        label {
            font-size: 13px;
            margin-top: 10px;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: none;
            outline: none;
            margin-bottom: 12px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #d4a017;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            background: #c28c12;
        }

        .error {
            background: rgba(255,0,0,0.2);
            padding: 8px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 10px;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
        }

        .footer a {
            color: #ffd700;
            text-decoration: none;
        }
    </style>
</head>

<body>

<form method="POST" action="{{ route('login') }}" class="login-box">

    @csrf

    <div class="title">📖 ThreebanBooks</div>
    <div class="subtitle">Selamat datang kembali!</div>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">

    <label>Password</label>
    <input type="password" name="password">

   

    <button type="submit">Login</button>

    <div class="footer">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar</a>
    </div>

</form>

</body>
</html>