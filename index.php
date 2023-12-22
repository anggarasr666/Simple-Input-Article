<?php
include("./db_functions.php");


// Handle form submission for deleting an article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $articleId = $_POST['article_id'];
    deleteArticle($articleId);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $shorttext = $_POST['shorttext']; // Add this line to capture $shorttext

    // Proses upload gambar
    $targetDir = "Images/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ... (sama seperti dalam skrip upload.php)

    // Simpan artikel ke database bersama dengan nama gambar
    if ($uploadOk == 1) {
        $imageName = basename($_FILES["image"]["name"]);
        addArticle($title, $content, $imageName, $shorttext);
    }
}


$articles = getAllArticles();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensiklopedia Artikel</title>
    <link rel="stylesheet" href="/lib/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles.css">
    <script src="/lib/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/script.js"></script>
    <script>
        $(document).ready(function() {
            $('.text-truncate').click(function() {
                $(this).toggleClass('text-truncate');
            });
        });

        function filterCards() {
        var input, filter, cards, card, title, shorttext, i;
        input = document.getElementById('filterInput');
        filter = input.value.toUpperCase();
        cards = document.getElementById('articleCards');
        card = cards.getElementsByClassName('col-md-4');

        for (i = 0; i < card.length; i++) {
            title = card[i].getElementsByClassName('card-title')[0];
            shorttext = card[i].getElementsByClassName('text-truncate')[0];

            if (title.innerText.toUpperCase().indexOf(filter) > -1 || shorttext.innerText.toUpperCase().indexOf(filter) > -1) {
                card[i].style.display = "";
            } else {
                card[i].style.display = "none";
            }
        }
    }

    // Panggil fungsi filterCards() saat tombol Cari ditekan
    document.getElementById('filterButton').addEventListener('click', filterCards);

    </script>
    <style>
        /* Tambahkan gaya CSS untuk mengatur ukuran gambar dalam carousel */
        .carousel-item img {
            width: 800px;
            height: 400px;
            object-fit: cover;
        }
    </style>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-light navbar-light">
        <div class="container d-flex justify-content-center">
            <div class="row">
                <div class="col-12 d-flex justify-content-center mb-3 ">
                    <a class="navbar-brand " href="#">
                        <img class="rounded-circle"
                            id="MDB-logo"
                            src="/Images/Logo.jpeg"
                            alt="MDB Logo"
                            draggable="false"
                            height="50"
                            width="50"
                        />
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
       
        <header class="col-md-12 col-lg-12 mt-5 text-center">
            <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
                <div id="heroCarousel" class="carousel carousel-fade" data-bs-ride="carousel">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="/Images/Antibiotik.jpeg" class="d-block img-fluid" alt="Image 1">
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img src="/Images/Mesin_Uap.jpeg" class="d-block img-fluid" alt="Image 2">
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <img src="/Images/Komputer.jpeg" class="d-block img-fluid" alt="Image 3">
                    </div>
                    
                    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </section>
            <h1>Selamat Datang di Ensiklopedia Penemuan Berpengaruh</h1>
        </header>

    <div class="container mt-5">
        <h2>Ensiklopedia Artikel</h2>

        <!-- Form untuk menambah artikel -->
        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Artikel:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Artikel:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Pilih Gambar:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <!-- Tambahkan input untuk $shorttext -->
            <div class="mb-3">
                <label for="shorttext" class="form-label">Pembuka Artikel:</label>
                <input type="text" class="form-control" id="shorttext" name="shorttext" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Tambah Artikel</button>
        </form>


        <!-- Tabel untuk menampilkan artikel -->
    <!-- <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Pembuka</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $article['id']; ?></td>
                <td><?= $article['title']; ?></td>
                <td><?= html_entity_decode($article['content']); ?></td>
                <td><?= $article['shorttext'];?></td>
                <td>
                    <?php if ($article['image_name']): ?>
                        <img src="Images/<?= $article['image_name']; ?>" alt="Article Image" width="100">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td>
                    <form action="index.php" method="post" style="display: inline;">
                        <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                        <button type="submit" class="btn btn-danger" name="delete">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table> -->

    </div>
    <div class="row">
            <div class="col-md-3">
                <div class="col-md-12">
                    <input type="text" id="filterInput" class="form-control" placeholder="Cari Artikel..." style="margin-top: 25px;">
                </div>
                <div class="col-md-2">
                    <button id="filterButton" class="btn btn-secondary" onclick="filterCards()" style="margin-top: 10px;">Cari</button>
                </div>

                <div class="bg-secondary text-center text-lg-start text-white" style="margin-top: 15px;">
                    <!-- Grid container -->
                    <div class="container p-4">
                      <!--Grid row-->
                      <div class="row my-4">
                        <!--Grid column-->
                        <div class="col-lg-12 col-md-12 mb-4 mb-md-0">
                
                          <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 50px; height: 50px;">
                            <img class="rounded-circle "src="/Images/Logo.jpeg" height="45" alt=""
                                 loading="lazy" />
                          </div>
                
                          <p class="text-center">Baca juga artikel lain untuk tahu lebih banyak mengenai penemuan menarik</p>
                
                        </div>
                        
                        <div class="col-lg-12 col-md-12 mb-4 mb-md-0">
                            <ul class="list-unstyled">
                                <?php foreach ($articles as $article): ?>
                                    <li class="mb-2">
                                        <a href="/show.php?id=<?= $article['id']; ?>" class="text-white">
                                            <i class="fas fa-paw pe-3"></i><?= $article['title']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                      </div>
                      <!--Grid row-->
                    </div>
                    <!-- Grid container -->
                
                    <!-- Copyright -->
                    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                    </div>
                    <!-- Copyright -->
                </div>
            </div>
            <div class="col-md-9">
                <section id="carousel" class="my-4">
                    <div class="row m-2">
                    <div id="articleCards" class="row m-2">
                            <?php foreach ($articles as $article): ?>
                                <div class="col-md-4" style="margin-bottom: 20px;">
                                    <div class="card">
                                        <img src="Images/<?= $article['image_name']; ?>" class="card-img-top" alt="<?= $article['title']; ?>" width="250" height="150">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $article['title']; ?></h5>
                                            <div class="container">
                                                <p class="text-truncate"><?= $article['shorttext']; ?></p>
                                            </div>
                                            <a href="/show.php?id=<?= $article['id']; ?>" class="btn btn-secondary">Baca Artikel</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    <footer class="text-center text-white " style="background-color: #f1f1f1; margin-top:50px;">
        <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2023 Copyright:
          <a class="text-dark" href="https://Google.com/">Google.com</a>
          <div>
            Tugas Pemrograman Web Jurusan Teknik Informatika ITS 2023
          </div>
          <div>
            5025211241, Anggara Saputra.
          </div>
        </div>
      </footer>
</body>
</html>


