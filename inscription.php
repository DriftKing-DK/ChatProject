<?php
//inscription Page

if(isset($_POST['inscription']))
{ 
    // inscription à la base de données
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);
    $nom = $_POST['nom'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $statut = "utilisateur";

    $sql = "INSERT INTO utilisateurs (nom, mot_de_passe, statut) VALUES (?,?,?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $nom, $mot_de_passe, $statut);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    echo "Inscription Réussie ! Vous pouvez retourner sur <a href='index.php'>la page de connexion !</a>";
}

?>


<html>
    <head>
    <meta charset="utf-8">
    <title>ChatProject - Inscription</title>
        <link rel="stylesheet" href="Styles/style_index.css" media="screen" />
    </head>
    <body>
        <div id="container">
            <!-- zone de inscription -->
            <form action="inscription.php" method="POST">
                <h1>Inscription</h1>
                
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Nom d'utilisateur" name="nom" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" required>
                <input type="submit" id='inscription' name="inscription" value='inscription' >                
            </form>

        </div>
    </body>
</html>
