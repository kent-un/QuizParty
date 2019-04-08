<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <title>QuizParty</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet"> 
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
    <?php
    if(isset($_POST['valider'])){
        $idQuestionnaire=$_POST['idQuestionnaire'];
        require_once 'class/connectionDB.php';
        $db = new connectionDb();
        $req = $db->db->prepare('UPDATE questionnaire SET etat=1 WHERE idQuestionnaire ='.$idQuestionnaire);
        $req->execute(); 
        echo '
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Votre quiz a été transmis à l\'administration.
        </div>';
    }
    if(isset($_SESSION['idUtilisateur']) && $_SESSION['statut']==1){
        echo '
        <div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
        <div class="card-header">Interface Membre</div>
        <div class="card-body">
        <a href="gestionQuiz.php?gestion=1"><button type="button" class="btn btn-primary btn-lg btn-block">Créer un quiz</button></a>
        <a href="gestionQuiz.php?gestion=2"><button type="button" class="btn btn-primary btn-lg btn-block">Gérer un quiz</button></a>
        <button type="button" class="btn btn-primary btn-lg btn-block">Consulter les quiz créés</button>
        </div>
      </div>';
    }else if(isset($_SESSION['idUtilisateur']) && $_SESSION['statut']==2){
        echo '
        <div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
        <div class="card-header">Interface Administrateur</div>
        <div class="card-body">
        <a href="gestionQuiz.php?gestion=1"><button type="button" class="btn btn-primary btn-lg btn-block">Créer un quiz</button></a>
        <a href="gestionQuiz.php?gestion=2"><button type="button" class="btn btn-primary btn-lg btn-block">Gérer un quiz</button></a>
        <button type="button" class="btn btn-primary btn-lg btn-block">Consulter les quiz</button>
        <button type="button" class="btn btn-primary btn-lg btn-block">Gestion des membres</button>
        </div>
      </div>';
    }else{
        echo '<a href="index.php"><button type="button" class="btn btn-primary btn-lg btn-block">Retourner à l\'accueil</button></a>';
    }
    ?>
    </main>
    <footer>

    </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   
</body>
</html>