<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
            position: relative;
        }

        /* overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
        }

        .register-box {
            position: relative;
            width: 520px;
            padding: 32px;
            border-radius: 18px;
            background: rgba(101, 67, 33, 0.88);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            z-index: 1;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
        }

        p {
            text-align: center;
            font-size: 13px;
            margin-bottom: 18px;
            opacity: 0.85;
        }

        .error {
            background: rgba(255,0,0,0.2);
            padding: 8px;
            border-radius: 8px;
            font-size: 12px;
            text-align: center;
            margin-bottom: 12px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        label {
            font-size: 12px;
            margin-bottom: 5px;
            display: block;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        textarea {
            resize: none;
        }

        .full {
            grid-column: 1 / -1;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
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

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 12px;
        }

        .footer a {
            color: #ffd700;
            text-decoration: none;
        }
    </style>
</head>

<body>

<form method="POST" action="{{ route('register') }}" class="register-box">

    @csrf

    <h2>📖 ThreebanBooks</h2>
    <p>Selamat datang 👋<br>Silakan isi data diri</p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid">

        <div>
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>No. Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <label>NISN</label>
            <input type="text" name="nisn" value="{{ old('nisn') }}">
        </div>

        <div class="full">
            <label>Alamat</label>
            <textarea name="alamat" rows="3">{{ old('alamat') }}</textarea>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation">
        </div>

    </div>

    <button type="submit">Daftar</button>

    <div class="footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
    </div>

</form>

</body>
</html>