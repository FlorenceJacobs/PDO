<!--PHP-->
<?php
include("connexionBDD.php");
?>
<!--Fin PHP-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Lien CSS-->
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
    <title>Randonnées à l'île de la Réunion</title>
</head>
<body>
    <h1>Les randonnées à la Réunion</h1>
    <p><a href="./create.php">Ajouter une randonnée</a></p>
    <h2>Voici quelques randonnées</h2>
    <table>
        <th>N°</th>
        <th>Nom</th>
        <th>Difficulté</th>
        <th>Distance (km)</th>
        <th>Durée</th>
        <th>Dénivelé (m)</th>
        <th>Praticabilité</th>
        <th>Mettre à jour</th>
        <th>Supprimer</th>

    <!--PHP-->
    <?php
    // Lancer la requête
    $query = 'SELECT id, name, difficulty, distance, DATE_FORMAT(duration, "%Hh%i") AS duration_hour, height_difference, available' . ' FROM hiking;';
    $prep = $pdo->query($query);
    // Récupérer toutes les données retournées
    $table ="";
    while($donnees = $prep->fetch())
    {
        $table .= '<tr>
        <td> '.$donnees['id'].'</td>
        <td> '.$donnees['name'].'</td>
        <td> '.$donnees['difficulty'].'</td>
        <td> '.$donnees['distance'].'</td>
        <td> '.$donnees['duration_hour'].'</td>
        <td> '.$donnees['height_difference'].'</td>
        <td> '.$donnees['available'].'</td>
        <td><a href="./update.php?id='.$donnees['id'].'">Mettre à jour</a></td>
        <td><form action="delete.php" method="post"><input type="hidden" name="toDelete" value="'.$donnees['id'].'"><button type="submit" name="buttonDelete">Supprimer</button></form></td>
        </tr>';
    }
    echo $table;
    // Clore la requête préparée
    $prep->closeCursor();
    // Vider l'array
    $prep = NULL;
    ?>
    <!--Fin PHP-->
    
</body>
</html>