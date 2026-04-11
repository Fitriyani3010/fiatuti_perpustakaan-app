@extends('kepala.layouts.app')

@section('content')

<style>
.profile-card {
    background: #f9fafb;
    padding: 30px;
    border-radius: 16px;
    display: flex;
    gap: 30px;
    align-items: center;
    flex-wrap: wrap;
}

.profile-left {
    text-align: center;
}

.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    background: #d1d5db;
    margin-bottom: 10px;
}

.profile-right {
    flex: 1;
    min-width: 250px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.btn-simpan {
    background: #10b981;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
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

            <input type="file" name="foto" id="foto-input">
        </div>

        <div class="profile-right">
            <h3>Edit Profile</h3>

            <div class="input-group">
                <input type="text" name="name" value="{{ $user->name }}">
            </div>

            <div class="input-group">
                <input type="email" name="email" value="{{ $user->email }}">
            </div>

            <div class="input-group">
                <input type="text" name="nisn" value="{{ $user->nisn }}">
            </div>

            <div class="input-group">
                <input type="text" name="no_telepon" value="{{ $user->no_telepon }}">
            </div>

            <div class="input-group">
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