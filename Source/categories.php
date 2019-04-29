<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet"> 
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>QuizParty | <?php echo $_GET['nomCategorie']?> </title>
</head>
<body>
    <header>
        <?php include 'header.php';?>
    </header>
    <main>
    <p class='division'>
    Catégorie <?php echo $nomCategorie = $_GET['nomCategorie'];?> 
    </p>
    
    <?php 
    require_once 'class/connectionDB.php';
    require_once 'class/categorie.php';
    require_once 'class/preview.php';
    $idCategorie = $_GET['idCategorie'];
    $couleurCat = $_GET['couleur'];
    $db = new connectionDb();

    $reponse = $db->db->prepare("SELECT * FROM questionnaire WHERE idCategorie = ".$idCategorie." AND etat = 2");
    $reponse->execute(); 
    while($donnees = $reponse->fetch()){
        $questions = $db->db->prepare("SELECT COUNT(question) AS numberQuest FROM question WHERE idQuestionnaire =".$donnees['idQuestionnaire']);
        $questions->execute();
        $numbQuest = $questions->fetch();
            $preview[]= new preview($donnees['titreQuestionnaire'], $numbQuest['numberQuest'], $couleurCat, $donnees['idQuestionnaire']);
    }
    if($reponse->rowCount()==0){
        echo'
                <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">OUPS !</h4>
                <p class="mb-0">Cette catégorie ne contient pas encore de quiz</p>
                </div>';
    }
    ?> 
    </main>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   

</body>

</html>