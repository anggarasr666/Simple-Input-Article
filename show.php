<?php
include_once 'db_functions.php';

$articleId = isset($_GET['id']) ? $_GET['id'] : null;
$article = getArticleById($articleId);

if (!$article) {
    echo "Artikel tidak ditemukan";
}

$articles = getAllArticles(); // Query ulang untuk mendapatkan semua artikel
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensiklopedia Artikel</title>
    <link rel="stylesheet" href="/lib/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="/lib/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/script.js"></script>
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
        <header class="mt-5 text-center">
            <h1><?= $article['title']; ?></h1>
        </header>
        <div class="row justify-content-center align-items-center">
            <div class="col-8">
                <img src="/Images/<?= $article['image_name']; ?>" class="img-fluid" alt="<?= $article['title']; ?>" width="750" height="400">
            </div>
        </div>
        <article class="mt-4">
            <?= html_entity_decode($article['content']); ?>
        </article>
    </div>

    <div class="container my-5">
        <footer class="bg-secondary text-center text-lg-start text-white">
            <!-- Grid container -->
            <div class="container p-4">
                <!--Grid row-->
                <div class="row my-4">
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                        <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 150px; height: 150px;">
                            <img class="rounded-circle "src="/Images/Logo.jpeg" height="145" alt=""
                                loading="lazy" />
                        </div>

                        <p class="text-center">Baca juga artikel lain untuk tahu lebih banyak mengenai penemuan menarik</p>

                        <ul class="list-unstyled d-flex flex-row justify-content-center">
                            <li>
                                <a class="text-white px-2" href="#!">
                                    <i class="fab fa-facebook-square"></i>
                                </a>
                            </li>
                            <li>
                                <a class="text-white px-2" href="#!">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a class="text-white ps-2" href="#!">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
<div class="col-lg-3 col-md-6 mb-4 mb-md-0">
    <h5 class="text-uppercase mb-4">Content</h5>

    <ul class="list-unstyled">
        <?php
        $displayedArticleIds = array(); // Array untuk menyimpan ID artikel yang sudah ditampilkan
        foreach ($articles as $article):
            $articleId = $article['id'];
            if (!in_array($articleId, $displayedArticleIds)): // Cek apakah artikel belum ditampilkan
        ?>
        <li class="mb-2">
            <a href="/show.php?id=<?= $articleId; ?>" class="text-white"><i class="fas fa-paw pe-3"></i><?= $article['title']; ?></a>
        </li>
        <?php
            $displayedArticleIds[] = $articleId; // Tandai bahwa artikel ini sudah ditampilkan
            endif;
        endforeach;
        ?>
    </ul>
</div>
<!--Grid column-->


                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase mb-4">Contact</h5>

                        <ul class="list-unstyled">
                            <li>
                                <p><i class="fas fa-phone pe-2"></i>+ 62 812 6017 9930</p>
                            </li>
                            <li>
                                <p><i class="fas fa-envelope pe-2 mb-0"></i>angga060803@gmail.com</p>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            </div>
            <!-- Copyright -->
        </footer>
    </div>
</body>

</html>
