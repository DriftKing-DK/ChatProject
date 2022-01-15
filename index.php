<?php
//Connexion Page

if(isset($_POST['connexion']))
{ 
    // Connexion à la base de données
    include "acces.php";
    $connection = new mysqli($serverip, $username, $data_password);
    mysqli_select_db($connection,$database);
    $nom = $_POST['nom'];
    $mot_de_passe = $_POST['mot_de_passe'];
    
    $sql = "SELECT id FROM utilisateurs WHERE nom = ? AND mot_de_passe = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $nom, $mot_de_passe);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();

    if ($id != NULL)
    {
        session_start();
        $_SESSION["id"] = $id;
        header("Location: messages.php");
    }
    else
    {
        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
    }
}

?>


<html>
    <head>
    <meta charset="utf-8">
    <title>ChatProject - Connexion</title>
        <link rel="stylesheet" href="Styles/style_index.css" media="screen" />
    </head>
    <body>
        <img src="logo.png">
        <div id="container">
            <!-- zone de connexion -->
            <form action="index.php" method="POST">
                <h1>Connexion</h1>
                
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Nom d'utilisateur" name="nom" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" required>

                <input type="submit" id='connexion' name="connexion" value='Connexion' >                
                <button id="button" onclick="window.location.href = 'inscription.php'" ><p>Inscription</p></button>

            </form>

        </div>
    </body>
</html>
