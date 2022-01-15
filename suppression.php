<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//inscription Page

if($_GET['type'] == 'message')
{ 
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);

    $sql = "DELETE FROM messages WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $_GET['message_id']);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    header('Location: messages.php');
}

if ($_GET['type'] == 'utilisateur')
{
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);

    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $_GET['utilisateur_id']);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    header('Location: utilisateurs.php');
}

?>
