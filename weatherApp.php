<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=weatherapp;charset=utf8', 'Florence', 'florence', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

function clean($data) {
	$data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST['ville'], $_POST['haut'], $_POST['bas'])) {
$ville = filter_var(clean($_POST['ville']), FILTER_SANITIZE_STRING);
$haut = filter_var(clean($_POST['haut']), FILTER_SANITIZE_NUMBER_INT);
$bas = filter_var(clean($_POST['bas']), FILTER_SANITIZE_NUMBER_INT);

	if (!preg_match("/[a-zA-Z]/", $ville)) {
		echo 'Pour renseigner un nom de ville, seuls les caractères alphabétiques sont acceptés';
	} else {

		if (filter_var($haut, FILTER_VALIDATE_INT) AND filter_var($bas, FILTER_VALIDATE_INT)){
			$reponse = $bdd->query("INSERT INTO météo (ville, haut, bas) VALUES ('$ville', '$haut', '$bas')");
			$reponse -> closeCursor();
			echo'Votre ville a bien été ajoutée à la base de données';
		} else {
			echo 'L\'ajout à la base de données à échoué';
		}
	}
$_POST = array();
}

if (isset($_POST['toDelete'])){
	$listId = "";
	foreach($_POST['toDelete'] as $ide) {
		$listId = $listId . $ide . ', ';
	}
	$listIdNoSemicolon = substr($listId, 0, -2);
	$result = $bdd->query("DELETE FROM météo WHERE id IN ($listIdNoSemicolon)");
			$result -> closeCursor();
	$_POST = array();
}

?>

	<form action="" method="post" name="checkedForm">
		<table>
			<th style="border: 1px solid black">Sup</th>
			<th style="border: 1px solid black">ville</th>
			<th style="border: 1px solid black">T° max</th>
			<th style="border: 1px solid black">T° min</th>
<?php
$table ="";
$reponse = $bdd->query('SELECT * FROM météo');
while ($donnees = $reponse->fetch()) { 
	$table .= '<tr><td style="border: 1px solid black"><input type="checkbox" value="'.$donnees['id'].'" name="toDelete[]"></td>
	<td style="border: 1px solid black"> '.$donnees['ville'].'</td>
	<td style="border: 1px solid black"> '.$donnees['haut'].'</td>
	<td style="border: 1px solid black"> '.$donnees['bas'].'</td>
	</tr>';
}

echo $table;
$reponse->closeCursor();
?>
		
		</table>
		<input type="submit" value="Supprimer">
	</form>

	<form action="" method="post" name="ajout">
		<div>
			<label for="name">Quelle ville : </label>
			<input type="text" name="ville">
		</div>
		<div>
			<label for="haut">Temp max: </label>
			<input type="number" name="haut">
		</div>
		<div>
			<label for="bas">Temp min: </label>
			<input type="number" name="bas">
		</div>
		<input type="submit" value="Enregistrer">
	</form>

</body>
</html>
    