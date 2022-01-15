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
<img src="logo.png">
<div style="display : flex; height : 80vh;">
    <form id="message_box" action="messages_envoi.php" method="post">
        <h1>ChatProject</h1>
        <p>Ecrire un message en tant que : <b><?php echo $nom; ?></b><br/>(Appuyer sur [Entree] pour envoyer un message)</p></br>
        <textarea onKeyPress="if(event.keyCode == 13) sendMsg();" name="message" id="message" rows="20" cols="50"></textarea> 
        <input type="hidden" name="nom" id="nom" value="<?php echo $nom; ?>">
        <center><button id="refresh" onclick="window.location.href = 'messages.php';"><p>Actualiser les messages</p></button></center>
    </form>
    <?php
    // Connexion à la base de données
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);

    $sql = "SELECT * FROM messages ORDER BY id DESC LIMIT 100 ";
    $res = $connection->query($sql);
    ?>
    <div id="message_div">     
        <?php
        if ($statut == "admin")
        {
            printf("<h3>Vous êtes administrateur</h3>
                    <a href='utilisateurs.php'><h4>Afficher les utilisateurs</h4></a>");
            while ($data = mysqli_fetch_array($res) )
            {
                echo $data['auteur']." : ".$data['message']." -- ".strstr($data['date'], ' ')." <a href='suppression.php?type=message&message_id=".$data['id']."'>Supprimer</a></br>";
            }
        }
        else {
            while ($data = mysqli_fetch_array($res) )
            {
                echo $data['auteur']." : ".$data['message']." -- ".strstr($data['date'], ' ')."</br>";
            }
        }
        
    ?>
    </div>
</div>
</body>

<!--- CORPS --->