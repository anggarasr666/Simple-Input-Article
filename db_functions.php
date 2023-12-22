<?php
function dbconn() {
    $db_server = "127.0.0.1";
    $db_username = "root";
    $db_password = "";
    $db_database = "dbpweb1";
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_database);
    if (!$conn) {
        die("koneksi error");
    }
    return $conn;
}

function getAllArticles() {
    $conn = dbconn();
    $query = "SELECT * FROM articles";
    $result = mysqli_query($conn, $query);

    $articles = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }

    mysqli_close($conn);
    return $articles;
}

function addArticle($title, $content, $imageName, $shorttext) {
    $conn = dbconn();
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);

    $query = "INSERT INTO articles (title, content, image_name, shorttext) VALUES ('$title', '$content', '$imageName', '$shorttext')";
    $success = mysqli_query($conn, $query);
    mysqli_close($conn);
    return $success;
}

function deleteArticle($articleId) {
    $conn = dbconn();
    $query = "DELETE FROM articles WHERE id = $articleId";
    $success = mysqli_query($conn, $query);

    mysqli_close($conn);
    return $success;
}

function getArticleById($articleId) {
    $conn = dbconn();
    $query = "SELECT * FROM articles WHERE id = $articleId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $article = mysqli_fetch_assoc($result);

    mysqli_close($conn);
    return $article;
}
?>
