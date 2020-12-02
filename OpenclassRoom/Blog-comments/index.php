<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <title>Articles du blog</title>
</head>
<body>
<h1>Mon BLOG (TP OpenClassRoom)</h1>
<h2>Voici les derniers articles</h2>

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
    $request = $bdd->query("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_creation_fr FROM blog_articles ORDER BY date_creation DESC LIMIT 0,4") or die(print_r($bdd->errorInfo()));

    while ($donnees = $request->fetch())
    {
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
        <br />
        <em><a href="commentaires.php?article=<?php echo $donnees['id']; ?>">Commentaires</a></em>
        </p>
    </div>
    <?php
    } // Fin de la boucle des billets
    $request->closeCursor();
    ?>
    
</body>
</html>