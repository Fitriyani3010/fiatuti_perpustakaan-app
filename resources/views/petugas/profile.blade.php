@extends('petugas.layouts.app')

@section('title', 'Profile Petugas')

@section('content')

<style>
.container-profile {
    max-width: 850px;
    margin: 40px auto;
    
}

/* CARD */
.card-profile {
    background: #fdf8f3;
    border-radius: 20px;
    padding: 30px;
    border: 1px solid #e6d5c3;
    box-shadow: 0 12px 30px rgba(75, 46, 30, 0.15);
}

/* HEADER */
.profile-header {
    text-align: center;
    margin-bottom: 30px;
}

.profile-header img {
    width: 95px;
    height: 95px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 12px;
    border: 3px solid #d6c2b5;
}

.profile-header h2 {
    margin: 0;
    font-size: 22px;
    color: #4b2e1e;
    letter-spacing: 0.5px;
}

.profile-header span {
    color: #8b6f5a;
    font-size: 13px;
    font-style: italic;
}

/* FORM */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    color: #6b3f24;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* INPUT */
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #d6c2b5;
    outline: none;
    background: #fffaf5;
  
    font-size: 14px;
    transition: 0.2s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 0 3px rgba(107,63,36,0.15);
}

/* BUTTON */
.btn-submit {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff8f0;
    font-weight: 600;
    cursor: pointer;
   
    letter-spacing: 0.5px;
    transition: 0.3s;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(75, 46, 30, 0.25);
}

/* SUCCESS */
.success-msg {
    background: #f0e6d8;
    color: #6b3f24;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 18px;
    text-align: center;
    border: 1px solid #e0cfc2;
    font-size: 13px;
}
.upload-photo {
    margin-top: 10px;
}

.upload-label {
    display: inline-block;
    padding: 10px 14px;
    border: 1px dashed #d6c2b5;
    border-radius: 10px;
    background: #fffaf5;
    color: #6b3f24;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
}

.upload-label:hover {
    background: #f3e7dc;
    border-color: #6b3f24;
}

.upload-label input {
    display: none;
}
.btn-delete-photo {
    margin-top: 10px;
    padding: 8px 12px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    background: #b23a3a;
    color: white;
    font-size: 12px;
    transition: 0.2s;
}

.btn-delete-photo:hover {
    background: #922d2d;
    transform: translateY(-2px);
}
</style>

<div class="container-profile">

    <div class="card-profile">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        {{-- PROFILE HEADER --}}
        <div class="profile-header">
          @if($user->foto)
    <img id="preview-img"
         src="{{ asset('storage/foto/'.$user->foto) }}"
         alt="Foto">
@else
    <img id="preview-img"
         src="https://ui-avatars.com/api/?name={{ $user->name }}"
         alt="Foto">
@endif
            <div class="upload-photo">
    <label class="upload-label">
        📷 Ganti Foto Profil
        <input type="file" name="foto" id="foto-input">
    </label>
    @if($user->foto)
    <form action="{{ route('petugas.profile.deleteFoto') }}" method="POST" onsubmit="return confirm('Yakin hapus foto profil?')">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn-delete-photo">
            🗑 Hapus Foto
        </button>
    </form>
@endif
</div>
            <h2>{{ $user->name }}</h2>
            <span>Petugas</span>
        </div>

        {{-- FORM --}}
       <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_telepon" value="{{ $user->no_telepon }}">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3">{{ $user->alamat }}</textarea>
            </div>

            <button type="submit" class="btn-submit">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>
<script>
const input = document.getElementById('foto-input');
const preview = document.getElementById('preview-img');

input.addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection