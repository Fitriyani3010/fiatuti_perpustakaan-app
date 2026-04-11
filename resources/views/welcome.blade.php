<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThreebanBooks</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Libre+Baskerville&display=swap" rel="stylesheet">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f4ede4;
        font-family: 'Libre Baskerville', serif;
        color: #3e2c1c;
    }

    .navbar {
        background: #3e2c1c;
        color: #f4ede4;
        padding: 20px 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #c8a96a;
    }

    .logo {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 600;
    }

    .login a {
        color: #f4ede4;
        text-decoration: none;
        border: 1px solid #c8a96a;
        padding: 8px 18px;
        border-radius: 6px;
        transition: 0.3s;
    }

    .login a:hover {
        background: #c8a96a;
        color: #3e2c1c;
    }

    .hero {
        text-align: center;
        padding: 70px 20px;
        border-bottom: 2px dashed #c8a96a;
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        margin-bottom: 10px;
    }

    .hero p {
        max-width: 600px;
        margin: auto;
        font-size: 14px;
        line-height: 1.7;
        color: #5c4433;
    }

    .search-box {
        margin-top: 25px;
    }

    .search-box input {
        width: 300px;
        padding: 10px 16px;
        border: 1px solid #c8a96a;
        border-radius: 20px;
        background: #fffaf3;
        outline: none;
    }

    .info {
        text-align: center;
        padding: 30px;
        font-size: 14px;
        color: #6b4f3b;
    }

    .bookshelf {
        padding: 50px 60px;
    }

    .bookshelf h2 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 25px;
        border-left: 5px solid #c8a96a;
        padding-left: 10px;
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .book-card {
        background: #fffaf3;
        border: 1px solid #e0d6c8;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        transition: 0.3s;
    }

    .book-card:hover {
        transform: translateY(-4px);
    }

    .book-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .book-title {
        font-weight: 700;
        font-size: 14px;
    }

    .book-author {
        font-size: 12px;
        color: #7a5c45;
    }

    footer {
        text-align: center;
        padding: 20px;
        border-top: 1px solid #c8a96a;
        font-size: 12px;
        margin-top: 40px;
    }
</style>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">📚 ThreebanBooks</div>
        <div class="login">
            <a href="{{ route('login') }}">Login</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <h1>Perpustakaan Digital Sekolah</h1>
        <p>
            ThreebanBooks adalah sistem perpustakaan digital untuk membantu siswa mengakses buku pelajaran
            dan referensi dengan lebih mudah dan terorganisir.
        </p>

        
    </section>

    <!-- INFO -->
    <div class="info">
        Mendukung kegiatan literasi sekolah dan meningkatkan minat baca siswa.
    </div>

    <!-- BOOKS -->
    <section class="bookshelf">
        <h2>Buku Rekomendasi</h2>

        <div class="book-grid">

            <div class="book-card">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f" alt="">
                <div class="book-title">Bahasa Indonesia</div>
                <div class="book-author">Kelas X</div>
            </div>

            <div class="book-card">
                <img src="https://images.unsplash.com/photo-1509228468518-180dd4864904" alt="">
                <div class="book-title">Matematika Dasar</div>
                <div class="book-author">Kelas XI</div>
            </div>

            <div class="book-card">
                <img src="https://images.unsplash.com/photo-1519682337058-a94d519337bc" alt="">
                <div class="book-title">Sejarah Indonesia</div>
                <div class="book-author">Kelas XII</div>
            </div>

            <div class="book-card">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794" alt="">
                <div class="book-title">Pemrograman Web</div>
                <div class="book-author">Produktif</div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        © 2026 ThreebanBooks — Perpustakaan Digital Sekolah
    </footer>

</body>

</html>