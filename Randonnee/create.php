<!--CONNEXION BDD PHP-->
<?php
include("connexionBDD.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Ajouter une randonnée</title>
    <!--Lien CSS-->
	<link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>

<body>
    <!--Lien retour liste rando-->
	<a href="read.php">Retour à la liste des randonnées</a>
    <h1>Ajouter ci-dessous votre randonnée</h1>

    <!--Action : POST vers process.php-->
	<form action="" method="post">
		<div>
			<label for="name">Nom</label>
			<input type="text" name="name" minlength="2" maxlength="50" required pattern="^[A-Za-z '-]+$" value="">
		</div>
		<div>
			<label for="difficulty">Difficulté</label>
			<select name="difficulty">
				<option value="tres_facile">Très facile</option>
				<option value="facile">Facile</option>
				<option value="moyen">Moyen</option>
				<option value="difficile">Difficile</option>
				<option value="tres_difficile">Très difficile</option>
			</select>
		</div>
		<div>
			<label for="distance">Distance (en km)</label>
			<input type="number" name="distance" min="1" max="200" patern="[0-9]{1,3}" required value="">
		</div>
		<div>
			<label for="duration">Durée</label>
			<input type="time" name="duration" patern="^[0-2][0-9]:[0-6][0-9]" value="">
		</div>
		<div>
			<label for="height_difference">Dénivelé (en m)</label>
			<input type="number" name="height_difference" min="0" max="6000" patern="[0-9]{1,4}"  value="">
        </div>
        <div><span>Randonnée praticable?</span>
            <input type="radio" name="available" value="oui">
            <label for="available">OUI</label>
            <input type="radio" name="available" value="non">
            <label for="available">NON</label>
		</div>
		<p><button type="submit" name="button">Envoyer votre randonnée</button></p>
    </form>

<!--DEBUT PHP-->
<?php

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
                $query = 'INSERT INTO hiking(name, difficulty, distance, duration, height_difference, available)'
                . ' VALUES (:name, :difficulty, :distance, :duration, :height_difference, :available)';
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
                echo '<script>alert("Votre randonnée a bien été ajoutée")</script>';

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
// Récupérer toutes les données retournées
// $donnees = $prep->fetchAll();
// foreach($donnees as $donnee)
// {
?>
<!--FIN PHP-->

</body>
</html>