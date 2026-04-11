<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body style="
    margin:0;
    font-family:'Poppins', sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
">

    <form method="POST" action="{{ route('login') }}"
        style="
        width:350px;
        padding:30px;
        border-radius:15px;
        background: rgba(101, 67, 33, 0.8);
        backdrop-filter: blur(10px);
        color:white;
        box-shadow:0 10px 25px rgba(0,0,0,0.3);
    ">

        @csrf

        <h2 style="text-align:center;">📖 ThreebanBooks</h2>
        <p style="text-align:center; font-size:14px; margin-bottom:20px;">
            Selamat datang kembali!
        </p>

        {{-- ERROR GLOBAL --}}
        @if ($errors->any())
            <p style="color:#ffbaba; text-align:center; margin-bottom:10px;">
                {{ $errors->first() }}
            </p>
        @endif

        {{-- EMAIL --}}
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
            style="width:100%; padding:10px; margin:5px 0 10px; border:none; border-radius:5px;"
        >

        {{-- PASSWORD --}}
        <label>Password</label>
        <input type="password" name="password"
            style="width:100%; padding:10px; margin:5px 0 15px; border:none; border-radius:5px;"
        >

        {{-- REMEMBER --}}
        <div style="margin-bottom:15px;">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" style="font-size:13px;">Ingat saya</label>
        </div>

        <button type="submit"
            style="
            width:100%;
            padding:12px;
            background:#d4a017;
            color:white;
            border:none;
            border-radius:5px;
            font-size:16px;
            cursor:pointer;
        ">
            Login
        </button>

        <p style="text-align:center; font-size:13px; margin-top:15px;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#ffd700;">Daftar</a>
        </p>

    </form>

</body>
</html>