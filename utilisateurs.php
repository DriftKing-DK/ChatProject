<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

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

include "acces.php";
$connection = new mysqli($serverip, $username, $data_password);
mysqli_select_db($connection,$database);

$sql = "SELECT nom FROM utilisateurs WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($nom);
$stmt->fetch();
$stmt->close();

$sql = "SELECT statut FROM utilisateurs WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($statut);
$stmt->fetch();
$stmt->close();

if($statut != 'admin')
{
    header("Location: messages.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ChatProject</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" href="Images/favicon.png" />
    <link rel="stylesheet" href="Styles/style_messages.css">
</head>

<!--- JAVASCRIPT --->
<SCRIPT LANGUAGE="JavaScript">
            function sendMsg(){
                document.getElementById("message_box").submit();
            }
</SCRIPT>	
<!--- JAVASCRIPT --->

<body>
<div style="display : flex; height : 80vh;">
    <?php
    // Connexion à la base de données
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);

    $sql = "SELECT * FROM utilisateurs ORDER BY id";
    $res = $connection->query($sql);
    ?>
    <div id="message_div">
        <h1>Liste des utlisateurs</h1>
        <?php
            while ($data = mysqli_fetch_array($res) )
            {
                echo $data['nom']." : ".$data['statut']." --  <a href='suppression.php?type=utilisateur&utilisateur_id=".$data['id']."'>Supprimer l'utilisateur</a></br>";
            }
    ?>
    </div>
</div>
</body>

<!--- CORPS --->