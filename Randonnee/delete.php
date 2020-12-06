<!--PHP-->
<?php
include("connexionBDD.php");

// Supprimer la randonnée via POST
if(isset($_POST['buttonDelete'])){

    function clean_donnees($donnees){
        $donnees = trim($donnees);//SUP espaces avant et après
        $donnees = stripslashes($donnees);//SUP les slash
        $donnees = htmlspecialchars($donnees);//SUP les caractères spéciaux
        return $donnees;
    }

    //Données à récupérer via POST
    $id = clean_donnees($_POST['toDelete']);
   
    //Tester les données via les filtres et/ou les regex
    if(isset($id) && !empty($id)
    AND filter_var($id, FILTER_VALIDATE_FLOAT)) {

    $query = 'DELETE FROM hiking WHERE id = '.$id;
    $prep = $pdo->query($query);

    $prep->closeCursor();
    $prep = NULL;
    }
}

header("Location:read.php");
?>
<!--Fin PHP-->