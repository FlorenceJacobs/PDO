<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minichat OpenClassRoom</title>
</head>
<body>

<form action="minichat_post.php" method="post">
<p><label for="pseudo">Pseudo</label></p>
<p><input type="text" name="pseudo"></p>
<p><label for="message">Votre message</label></p>
<p><input type="text" id="name" name="message" minlength="4" maxlength="255"></p>
<p><input type="submit" value="Poster"></p>
</form>

<?php
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

$request = $bdd->query('SELECT * FROM minichat ORDER BY ID DESC LIMIT 0, 10');
while ($donnees = $request->fetch()) { 
	echo '<p>' .$donnees['pseudo'].' a posté : '. $donnees['message'] . '</p>';
}
$request -> closeCursor();

?>
</body>
</html>