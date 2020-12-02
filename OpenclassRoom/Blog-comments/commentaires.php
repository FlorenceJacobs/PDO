<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <title>Commentaires du blog</title>
</head>
<body>
<h1>Mon BLOG (TP OpenClassRoom)</h1>
<h2>Voici les derniers commentaires</h2>

<?php

// Effectuer ici la requête qui insère le message
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=openclassroom;charset=utf8', 'Florence', 'florence', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

    // Requête BDD or Die(message erreur)
    $request = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_creation_fr FROM blog_articles WHERE id = ?") or die(print_r($bdd->errorInfo()));
    $request->execute(array($_GET['article']));

    $donnees = $request->fetch();

    ?>
    <div class="news">
        <h3>
            <?php 
            // On affiche le titre
            echo htmlspecialchars($donnees['titre']); ?><br>
            <em>Le <?php echo $donnees['date_creation_fr']; ?></em>
        </h3>
        
        <p>
        <?php
        // On affiche le contenu du billet
        echo nl2br(htmlspecialchars($donnees['contenu']));
        ?>
        </p>
    </div>
    <?php
     // Fin de la boucle des billets
    $request->closeCursor();

    $request = $bdd->prepare('SELECT id_article, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire_fr FROM blog_commentaires WHERE id_article = ? ORDER BY date_commentaire_fr DESC') or die(print_r($bdd->errorInfo()));
    $request->execute(array($_GET['article']));
    while ($donnees = $request->fetch())
    {
    
    echo '<p>Le ' . $donnees['date_commentaire_fr'] . ', ' . $donnees['auteur'] . ' a écrit :</p> <p><em>' . $donnees['commentaire'] . '</em></p>'; 
    }
    $request->closeCursor();
    ?>
    <em><h2><a href="index.php">Revenir aux articles</a></h2></em>
</body>
</html>