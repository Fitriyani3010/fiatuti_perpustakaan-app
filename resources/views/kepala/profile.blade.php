@extends('kepala.layouts.app')

@section('content')
<style>
/* BACKGROUND VINTAGE */
body {
    font-family: Poppins, sans-serif;
    background: #e9e2d6;
}

/* SUCCESS / ERROR */
div[style*="10b981"] {
    background: #2f7a4f !important;
    color: white;
}

div[style*="ef4444"] {
    background: #b23a3a !important;
    color: white;
}

/* PROFILE CARD */
.profile-card {
    background: #fffaf3;
    padding: 30px;
    border-radius: 18px;
    display: flex;
    gap: 30px;
    align-items: center;
    flex-wrap: wrap;
    border: 1px solid #e6d3b3;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.15);
}

/* LEFT SIDE */
.profile-left {
    text-align: center;
}

/* PROFILE IMAGE */
.profile-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    background: #d8b58a;
    margin-bottom: 10px;
    border: 4px solid #d8b58a;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

/* RIGHT SIDE */
.profile-right {
    flex: 1;
    min-width: 250px;
}

/* TITLE */
.profile-right h3 {
    color: #4b2e1e;
    margin-bottom: 15px;
}

/* INPUT */
.input-group {
    margin-bottom: 15px;
}

.input-group input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #d8b58a;
    outline: none;
    background: #fffdf8;
    color: #4b2e1e;
}

/* FOCUS EFFECT */
.input-group input:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 0 2px rgba(107,63,36,0.2);
}

/* BUTTON VINTAGE */
.btn-simpan {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-simpan:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

/* FILE INPUT */
input[type="file"] {
    margin-top: 10px;
    font-size: 12px;
    color: #4b2e1e;
}

/* SMOOTH TRANSITION */
* {
    transition: 0.2s ease;
}
label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    color: #4b2e1e;
    font-weight: 600;
}

/* FILE UPLOAD CUSTOM */
.file-upload {
    margin-top: 10px;
}

.file-label {
    display: inline-block;
    padding: 10px 14px;
    background: #fffdf8;
    border: 1px dashed #d8b58a;
    border-radius: 10px;
    cursor: pointer;
    font-size: 13px;
    color: #6b3f24;
    transition: 0.2s;
}

.file-label:hover {
    background: #f7efe3;
    border-color: #6b3f24;
}

.file-label input {
    display: none;
}
</style>

@if (session('success'))
<div style="background:#10b981; color:white; padding:10px; border-radius:8px; margin-bottom:15px;">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background:#ef4444; color:white; padding:10px; border-radius:8px; margin-bottom:15px;">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<form action="{{ route('kepala.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="profile-card">

        <div class="profile-left">
            @if ($user->foto)
                <img id="preview-foto" src="{{ asset('storage/foto/' . $user->foto) }}" class="profile-img">
            @else
                <img id="preview-foto" src="https://ui-avatars.com/api/?name={{ $user->name }}" class="profile-img">
            @endif

           <div class="file-upload">
    <label class="file-label">
        📷 Pilih Foto Profil
        <input type="file" name="foto" id="foto-input">
    </label>
</div>
        </div>

        <div class="profile-right">
    <h3>Edit Profile</h3>

    <div class="input-group">
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}">
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}">
    </div>

    <div class="input-group">
        <label>NISN</label>
        <input type="text" name="nisn" value="{{ $user->nisn }}">
    </div>

    <div class="input-group">
        <label>No Telepon</label>
        <input type="text" name="no_telepon" value="{{ $user->no_telepon }}">
    </div>

    <div class="input-group">
        <label>Alamat</label>
        <input type="text" name="alamat" value="{{ $user->alamat }}">
    </div>

    <button type="submit" class="btn-simpan">Simpan</button>
</div>
    </div>
</form>

<script>
const fotoInput = document.getElementById('foto-input');
const previewFoto = document.getElementById('preview-foto');

fotoInput.addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            previewFoto.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection