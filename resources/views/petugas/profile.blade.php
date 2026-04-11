@extends('petugas.layouts.app')

@section('title', 'Profile Petugas')

@section('content')

<style>
    .container-profile {
        max-width: 900px;
        margin: 30px auto;
        font-family: Poppins, sans-serif;
    }

    .card-profile {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .profile-header img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 20px;
    }

    .profile-header span {
        color: gray;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ddd;
        outline: none;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #6b3f24;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        background: #6b3f24;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-submit:hover {
        background: #5a331d;
    }

    .success-msg {
        background: #d1fae5;
        color: #065f46;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        text-align: center;
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
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="Foto">
            <h2>{{ $user->name }}</h2>
            <span>Petugas</span>
        </div>

        {{-- FORM --}}
        <form action="{{ route('petugas.profile.update') }}" method="POST">
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

@endsection