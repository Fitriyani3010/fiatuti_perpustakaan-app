@extends('user.layouts.app')

@section('content')
    <style>
   body {
    background: #eae6e3;
}

.profile-card {
    background: #fdf8f3;
    padding: 30px;
    border-radius: 20px;
    display: flex;
    gap: 30px;
    align-items: center;
    flex-wrap: wrap;
    border: 1px solid #d6c2b5;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* FOTO */
.profile-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #6b3f24;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* TEXT */
.profile-right h3 {
    color: #6b3f24;
    margin-bottom: 15px;
}

/* INPUT */
.input-group label {
    font-size: 13px;
    color: #6b3f24;
    font-weight: 600;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #d6c2b5;
    background: #fffaf5;
    transition: 0.2s;
}

.input-group input:focus {
    border-color: #6b3f24;
    outline: none;
    box-shadow: 0 0 0 2px rgba(107,63,36,0.2);
}

/* BUTTON */
.btn-simpan {
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.2s;
}

.btn-simpan:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* ALERT */
.alert-success {
    background: #42ce6a;
    color: white;
    padding: 10px;
    border-radius: 10px;
}

.alert-error {
    background: #a94442;
    color: white;
    padding: 10px;
    border-radius: 10px;
}
    </style>
    <div class="main-content">
        {{-- allert success --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- allert error --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-card">
                <div class="profile-left">
                    @if ($user->foto)
                        <img id="preview-foto" src="{{ asset('storage/foto/' . $user->foto) }}" class="profile-img">
                    @else
                        <img id="preview-foto" src="https://via.placeholder.com/120" class="profile-img">
                    @endif
                    <input type="file" name="foto" id="foto-input" accept="image/*">
                </div>
                <div class="profile-right">
                    <h3>Edit Profile</h3>
                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                    
                    <div class="input-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}">
                    </div>
                    <div class="input-group">
    <label>Kelas</label>
    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XI RPL 1">
</div>
                    <div class="input-group">
                        <label>No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}">
                    </div>
                    <div class="input-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}">
                    </div>
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        const fotoInput = document.getElementById('foto-input');
        const previewFoto = document.getElementById('preview-foto');
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
