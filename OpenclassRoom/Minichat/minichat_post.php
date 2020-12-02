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
    // Nettoyer les $_POST
function clean($data) {
	$data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}
    // Valider les $_POST
if (isset($_POST['pseudo'], $_POST['message']) AND !empty($_POST['pseudo']) AND !empty($_POST['message'])) {
    $cleanMessage = filter_var(clean($_POST['message']), FILTER_SANITIZE_STRING);
    $cleanPseudo = filter_var(clean($_POST['pseudo']), FILTER_SANITIZE_STRING);

    // Requête BDD or Die(message erreur)
    $request = $bdd->prepare("INSERT INTO minichat(pseudo, message) VALUE (:rPseudo, :rMessage)") or die(print_r($bdd->errorInfo()));
    $request->execute(array(
        'rPseudo'=>$cleanPseudo,
        'rMessage'=>$cleanMessage));
    $request -> closeCursor();
} else {
    echo 'L\'accès à la base de données a échoué';
}
// Puis rediriger vers minichat.php pour éviter le message à l'utilisateur de recharge de données :
header('Location: minichat.php');
?>