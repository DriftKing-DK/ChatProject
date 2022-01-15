<?php
include "acces.php";
$connection = new mysqli($serverip, $username, $data_password);
mysqli_select_db($connection,$database);

session_start();
if (!isset($_SESSION["id"])) {
    unset($_SESSION["id"]);
    session_destroy();
    header('Location: ./index.php');
    exit();
}
else{
    $id = $_SESSION["id"];
    
}

$nom = $_POST['nom'];
$message = $_POST['message'];
if ($message != "" && $message != " ")
{
    echo $message;
    echo $nom;
    $sql = "INSERT INTO messages (message, auteur) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $message, $nom);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}
// Redirection du visiteur vers la page du minichat
header('Location: messages.php');
?>