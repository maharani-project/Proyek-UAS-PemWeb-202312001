<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>

<?php include '../../includes/header.php'; ?>

<style>
    body {
        background: linear-gradient(to bottom right, #fbc2eb, #a6c1ee, #fde2e2);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .menu-icons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 30px 0 10px;
        flex-wrap: wrap;
    }

    .menu-icon {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 30px; /* oval horizontal */
        padding: 12px 30px; /* lebih ramping */
        text-align: center;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        min-width: 100px;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .menu-icon:hover {
        background-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-3px);
    }

    .menu-icon .emoji {
        font-size: 1.6rem;
        display: block;
        margin-bottom: 3px;
    }

    .video-container {
        width: 100%;
        max-height: 400px;
        overflow: hidden;
        margin-bottom: 10px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .video-container video {
        width: 100%;
        height: auto;
    }

    .video-caption {
        text-align: center;
        font-size: 1.4rem;
        font-weight: 600;
        color: #fff;
        margin-top: 10px;
        font-family: 'Georgia', serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
    }

    .promo-section {
        text-align: center;
        margin: 20px 0;
    }

    .promo-image {
        width: 90%;
        max-width: 800px;
        border-radius: 20px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .promo-text {
        font-size: 1.1rem;
        color: #fff;
        font-weight: 500;
        margin-bottom: 40px;
        font-style: italic;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    .about-section {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 25px;
        border-radius: 15px;
        margin: 40px auto;
        max-width: 800px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .about-section h4 {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .about-section p {
        font-size: 1rem;
        color: #444;
        line-height: 1.6;
    }

    .banner-img {
        height: auto;
        object-fit: contain;
    }

    .carousel-inner {
        max-height: 180px;
    }

    @media (max-width: 768px) {
        .menu-icons {
            flex-direction: column;
            align-items: center;
        }

        .menu-icon {
            margin-bottom: 10px;
            min-width: 130px;
            padding: 20px 30px;
        }

        .promo-image {
            width: 95%;
        }

        .video-caption {
            font-size: 1.2rem;
        }

        .about-section {
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .menu-icon {
            padding: 15px 20px;
            font-size: 0.95rem;
        }

        .menu-icon .emoji {
            font-size: 1.5rem;
        }

        .promo-text {
            font-size: 1rem;
        }

        .video-caption {
            font-size: 1rem;
        }

        .about-section p {
            font-size: 0.95rem;
        }
    }
</style>

<div class="container text-center">

    <!-- 🚀 BANNER CAROUSEL (Bootstrap) -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../../assets/banner/1.png" class="d-block w-100 img-fluid" style="object-fit: contain; height: auto;" alt="1">
            </div>
            <div class="carousel-item">
                <img src="../../assets/banner/2.png" class="d-block w-100 img-fluid" style="object-fit: contain; height: auto;" alt="2">
            </div>
            <div class="carousel-item">
                <img src="../../assets/banner/3.png" class="d-block w-100 img-fluid" style="object-fit: contain; height: auto;" alt="3">
            </div>
            <div class="carousel-item">
                <img src="../../assets/banner/4.png" class="d-block w-100 img-fluid" style="object-fit: contain; height: auto;" alt="4">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

<!-- 🔍 SEARCH BAR with Navbar-like Effect -->
<div class="my-4 d-flex justify-content-center">
    <form action="../shop/index.php" method="GET" style="width: 100%; max-width: 800px;">
        <div style="
            position: relative;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        ">
            <input type="text" name="q" class="form-control" placeholder="Cari produk fashion favoritmu..."
                style="border: none; background: transparent; padding: 12px 50px 12px 20px; border-radius: 30px; color: #333;">
            <button type="submit" aria-label="Cari produk"
                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); border: none; background: none; font-size: 1.2rem; color: #333;">
                🔍
            </button>
        </div>
    </form>
</div>

    <!-- MENU ICON -->
    <div class="menu-icons">
        <a href="../shop/index.php" class="menu-icon">
            <span class="emoji">🛒</span>
            <span>Belanja</span>
        </a>
        <a href="../shop/riwayat.php" class="menu-icon">
            <span class="emoji">📦</span>
            <span>Riwayat</span>
        </a>
        <a href="../user/profil.php" class="menu-icon">
            <span class="emoji">👤</span>
            <span>Data Diri</span>
        </a>
    </div>

    <!-- VIDEO -->
    <div class="video-container mx-auto">
        <video autoplay muted loop playsinline>
            <source src="../../assets/video/fashion1.mp4" type="video/mp4">
            Browser Anda tidak mendukung video.
        </video>
    </div>
    <div class="video-caption">"Gaya adalah ekspresi terbaik dari dirimu."</div>

    <!-- PROMO FOTO -->
    <div class="promo-section">
        <img src="../../assets/img/1.jpg" class="promo-image" alt="Fashion 1">
        <div class="promo-text"> Ekspresikan gaya unikmu setiap hari </div>

        <img src="../../assets/img/2.jpg" class="promo-image" alt="Fashion 2">
        <div class="promo-text"> Tampil stylish & nyaman sepanjang waktu </div>

        <img src="../../assets/img/3.jpg" class="promo-image" alt="Fashion 3">
        <div class="promo-text"> Simpel, elegan, dan menawan </div>

        <img src="../../assets/img/4.jpg" class="promo-image" alt="Fashion 4">
        <div class="promo-text"> Pakaian yang berbicara tentang kepribadianmu </div>
    </div>

    <!-- ABOUT -->
    <div class="about-section">
        <h4>Tentang Kami</h4>
        <p>
            Kami adalah platform fashion yang hadir untuk kamu yang ingin tampil percaya diri tanpa harus mengorbankan kenyamanan.
            Kami percaya bahwa setiap orang berhak mengekspresikan diri lewat gaya berpakaian yang simpel namun elegan.
        </p>
        <p>
            Dengan koleksi yang terus diperbarui dan layanan ramah pengguna, kami siap menemani langkah gayamu setiap hari.
        </p>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
