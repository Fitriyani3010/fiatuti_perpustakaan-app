<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body style="
    margin:0;
    font-family:'Poppins', sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
">

    <form method="POST" action="{{ route('register') }}"
        style="
        width:480px;
        padding:32px;
        border-radius:16px;
        background: rgba(101, 67, 33, 0.85);
        backdrop-filter: blur(10px);
        color:white;
        box-shadow:0 12px 30px rgba(0,0,0,0.3);
    ">

        @csrf

        <h2 style="text-align:center; margin-bottom:5px;">📖 ThreebanBooks</h2>
        <p style="text-align:center; font-size:14px; margin-bottom:22px;">
            Selamat datang 👋<br>
            Silakan isi data diri kalian
        </p>

        @if ($errors->any())
            <p style="color:#ffbaba; text-align:center; margin-bottom:15px;">
                {{ $errors->first() }}
            </p>
        @endif

        <!-- GRID -->
        <div style="
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
">

    <div>
        <label style="font-size:13px; display:block; margin-bottom:6px;">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}"
            style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
    </div>

    <div>
        <label style="font-size:13px; display:block; margin-bottom:6px;">No. Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
            style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
    </div>

   <div>
    <label style="font-size:13px; display:block; margin-bottom:6px;">Email</label>
    <input type="email" name="email" value="{{ old('email') }}"
        style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
</div>

<div>
    <label style="font-size:13px; display:block; margin-bottom:6px;">NISN</label>
    <input type="text" name="nisn" value="{{ old('nisn') }}"
        style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
</div>

    <div style="grid-column:1 / -1;">
        <label style="font-size:13px; display:block; margin-bottom:6px;">Alamat</label>
        <textarea name="alamat"
            style="width:100%; padding:12px; border:none; border-radius:8px; resize:none; box-sizing:border-box;">{{ old('alamat') }}</textarea>
    </div>

    <div>
        <label style="font-size:13px; display:block; margin-bottom:6px;">Password</label>
        <input type="password" name="password"
            style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
    </div>

    <div>
        <label style="font-size:13px; display:block; margin-bottom:6px;">Konfirmasi</label>
        <input type="password" name="password_confirmation"
            style="width:100%; padding:12px; border:none; border-radius:8px; box-sizing:border-box;">
    </div>

</div>

        <button type="submit"
            style="
            width:100%;
            padding:12px;
            margin-top:20px;
            background:#d4a017;
            color:white;
            border:none;
            border-radius:6px;
            font-size:15px;
            cursor:pointer;
        ">
            Daftar
        </button>

        <p style="text-align:center; font-size:13px; margin-top:14px;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#ffd700;">Login</a>
        </p>

    </form>

</body>
</html>