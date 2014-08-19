<?php

include './db-utils.php';
header("Access-Control-Allow-Origin: *");

if(isset($_POST['add-user']) && $_POST['add-user'] == 'true'){
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $image = $_POST['image'];
    $id = DbUtils::addUser($email, $pseudo, $image);
    die($id);
}

if(isset($_POST['new-place']) && $_POST['new-place'] == 'true'){
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $nom = $_POST['nom'];
    $id_user = $_POST['id-user'];
    $comment = $_POST['comment'];
    $id_place = DbUtils::addPlace($lat, $lng, $nom, 1);

    DbUtils::addComment($id_user, $id_place, $comment);
    die("ok");
}
if(isset($_POST['add-comment']) && $_POST['add-comment'] == 'true'){
    $id_user = $_POST['id-user'];
    $id_place = $_POST['id-place'];
    $comment = $_POST['comment'];
    DbUtils::addComment($id_user, $id_place, $comment);
    die("ok");
}
if(isset($_GET['get-comments']) && $_GET['get-comments'] == 'true'){
    $comments = DbUtils::getComments();
    die(json_encode($comments));
}

if(isset($_GET['get-places']) && $_GET['get-places'] == 'true'){
    $places = DbUtils::getPlaces();
    die(json_encode($places));
}
if(isset($_GET['confirm-place']) && $_GET['confirm-place'] == 'true'){
    $id = $_GET['id'];
    DbUtils::confirmPlace($id);
    die('ok');
}