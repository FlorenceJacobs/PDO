<!--PHP-->
<?php
include("connexionBDD.php");
?>
<!--Fin PHP-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ajouter une randonnée</title>
	<link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
	<a href="read.php">Liste des données</a>
    <h1>Mettre à jour</h1>
<!--PHP-->
<?php
include("connexionBDD.php");

// Récupérer les données via l'ID($_GET)
$query = 'SELECT * '
. 'FROM hiking '
. 'WHERE id = '.$_GET['id'];
$prep = $pdo->query($query);
while ($donnees = $prep->fetch()){
?>
<!--Fin PHP-->

	<form action="" method="post">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" value="<?php echo $donnees['name'] ?>">
		</div>
		<div>
			<label for="difficulty">Difficulté</label>
			<select name="difficulty">
				<option value="très facile">Très facile</option>
				<option value="facile">Facile</option>
				<option value="moyen">Moyen</option>
				<option value="difficile">Difficile</option>
				<option value="très difficile">Très difficile</option>
			</select>
		</div>
		
		<div>
			<label for="distance">Distance</label>
			<input type="text" name="distance" value="<?php echo $donnees['distance'] ?>">
		</div>
		<div>
			<label for="duration">Durée</label>
			<input type="duration" name="duration" value="<?php echo $donnees['duration'] ?>">
		</div>
		<div>
			<label for="height_difference">Dénivelé</label>
			<input type="text" name="height_difference" value="<?php echo $donnees['height_difference'] ?>">
        </div>
        <div><span>Randonnée praticable?</span>
            <input type="radio" name="available" value="oui">
            <label for="available">OUI</label>
            <input type="radio" name="available" value="non">
            <label for="available">NON</label>
		</div>
		<button type="submit" name="button">Mettre à jour</button>
    </form>
<?php
}
//Mettre à jour les données
//Lancer la validation au click sur "Submit"
if (isset($_POST['button'])){

    //Fonction de validation des données
    function clean_donnees($donnees){
        $donnees = trim($donnees);//SUP espaces avant et après
        $donnees = stripslashes($donnees);//SUP les slash
        $donnees = htmlspecialchars($donnees);//SUP les caractères spéciaux
        return $donnees;
    }

    //Données à récupérer via POST
    $name = clean_donnees($_POST['name']);
    $difficulty = clean_donnees($_POST['difficulty']);
    $distance = clean_donnees($_POST['distance']);
    $duration = clean_donnees($_POST['duration']);
    $height_difference = clean_donnees($_POST['height_difference']);
    $available = clean_donnees($_POST['available']);

    //Tester les données via les filtres et/ou les regex
    //1-Tester les données obligatoires(required)
    if(isset($name) && !empty($name)
    AND strlen($name)<=50
    AND preg_match("/^[A-Za-z '-]+$/",$name)
    AND filter_var($name, FILTER_SANITIZE_STRING)
    AND !empty($distance)
    AND strlen($distance)<=3
    AND filter_var($distance, FILTER_VALIDATE_FLOAT)
    AND filter_var($available, FILTER_SANITIZE_STRING)) {

        //2-Tester les données facultatives = durée
        if((isset($duration) && !empty($duration) && (strlen($duration)<=5) && preg_match("/^[0-2][0-9]:[0-6][0-9]/", $duration)) OR (empty($duration))){
                
            //2-Tester les données facultatives = dénivellé
            if((isset($height_difference) && !empty($height_difference) && (strlen($height_difference)<=4) && preg_match("/^[0-9]{2,4}/", $height_difference) && filter_var($height_difference, FILTER_VALIDATE_INT)) OR (empty($height_difference))){
                if(empty($height_difference)){
                    $height_difference = 0;
                }

                // Préparer la requête
                $query = "UPDATE hiking SET name=:name, difficulty=:difficulty, distance=:distance, duration=:duration, height_difference=:height_difference, available=:available WHERE id='".$_GET['id']."'";
                $prep = $pdo->prepare($query);
                // Associer les données recues aux place-holders(la constante de type par défaut est STR -> PDO::PARAM_STR)
                $prep->bindParam(':name',$name);
                $prep->bindParam(':difficulty',$difficulty);
                $prep->bindParam(':distance',$distance);
                $prep->bindParam(':duration',$duration);
                $prep->bindParam(':height_difference',$height_difference);
                $prep->bindParam(':available',$available);
                //Compiler et exécuter la requête
                $prep->execute();
                $prep->closeCursor();
                $prep = NULL;
                //On renvoie l'utilisateur vers la page de résultat/remerciement
                echo '<script>alert("Votre randonnée a bien été mise à jour")</script>';

            }else{
                echo '<script>alert("Merci de renseigner un dénivelé en mètres. Ex: 300")</script>';
            }

        }else{
            echo '<script>alert("Merci de renseigner une durée au format HH:MM. Ex: 01:30")</script>';
        }

    }else{
        echo 'Merci de renseigner le nom de la randonnée et sa distance (3 chiffres maximum. Ex: 22.)'; 
    }
}

?>
</body>
</html>