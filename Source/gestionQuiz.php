<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <title>QuizParty | Gestion de quiz</title>
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
    // Vérifier si l'utilisateur est connecté
    if(isset($_SESSION['idUtilisateur'])){
        // Intégration des classes objets pour la connexion à la DB et les catégories
        require_once 'class/connectionDB.php';
        require_once 'class/categorie.php';
        // Conditions pour vérifier si l'action que l'utilisateur veut effectuer
        if($_GET['gestion']==1){
            // Connexion à la base de donnée
            $db = new connectionDb();
            // Récupération des ID et des noms de catégories
            $reponse = $db->db->prepare('SELECT idCategorie, nomCategorie FROM categorie');
            $reponse->execute();
            echo '<div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
                    <div class="card-header">Création de quiz</div>
                    <div class="card-body">
                    <form method="post" action="creation.php">  
                        <div class="form-group">
                            <label for="titre">Titre du quiz</label>
                            <input type="text" name="titre" max-lenght="140" class="form-control" id="titre">
                        </div>
                        <div class="form-group">
                            <label for="numberQuestions">Nombre de questions</label>
                            <input type="number" class="form-control" name="numberQuestions" id="numberQuestions">
                        </div>
                        <div class="form-group">
                            <label for="categorie">Catégorie du quiz</label>
                            <select class="custom-select" name="categorie" id="categorie">
                            <option value="" selected="true" disabled="disabled">Choisissez la catégorie</option>';
            while($donnees= $reponse->fetch()){
                echo '<option value="'.$donnees['idCategorie'].'">'.$donnees['nomCategorie'].'</option>';

            }
            echo'
                            </select>
                        </div>
                        <input type="submit" value="Créer" name="creer" class="btn btn-primary btn-lg btn-block"/>
                    </form>
                    </div>
                </div>';
        }else if($_GET['gestion']==2){
            require_once 'class/previewGestion.php';
            $db = new connectionDb();
            if($_SESSION['statut']==1){
                $utilisateur = $_SESSION['idUtilisateur'];
                $reponse = $db->db->prepare("SELECT * FROM questionnaire NATURAL JOIN categorie WHERE idUtilisateur =".$utilisateur);
                $reponse->execute();
                while($donnees = $reponse->fetch()){
                    $questions = $db->db->prepare("SELECT COUNT(question) AS numbQuest FROM question WHERE idQuestionnaire=".$donnees['idQuestionnaire']);
                    $questions->execute();
                    $numbQuest = $questions->fetch();
                    $preview[] = new previewGestion($donnees['titreQuestionnaire'], $numbQuest['numbQuest'], $donnees['couleur'], $donnees['idQuestionnaire']);
                }
                if(($reponse->rowCount())==0){
                    echo '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p class="mb-0">Vous n\'avez pas encore publié de quiz</p>
                  </div>'; 
                }
                    
            }else{
                $reponse = $db->db->prepare("SELECT * FROM questionnaire NATURAL JOIN categorie");
                $reponse->execute();
                while($donnees = $reponse->fetch()){
                    $questions = $db->db->prepare("SELECT COUNT(question) AS numbQuest FROM question WHERE idQuestionnaire=".$donnees['idQuestionnaire']);
                    $questions->execute();
                    $numbQuest = $questions->fetch();
                    $preview[] = new previewGestion($donnees['titreQuestionnaire'], $numbQuest['numbQuest'], $donnees['couleur'], $donnees['idQuestionnaire']);
            }}
        }else if($_GET['gestion']==3){
            require_once 'class/previewAdmin.php';
            $db = new connectionDb();
            $reponse = $db->db->prepare("SELECT * FROM questionnaire NATURAL JOIN categorie WHERE etat = 0");
            $reponse->execute();
            echo '<h6>Questionnaires en attente de validation</h6>';
            while($donnees = $reponse->fetch()){
                $preview[] = new previewAdmin($donnees['titreQuestionnaire'], $donnees['couleur'], $donnees['idQuestionnaire'], $donnees['nomCategorie'], $donnees['dateQuestionnaire']);
            }
            echo '<h6>Questionnaires archivés</h6>';
            $reponse = $db->db->prepare("SELECT * FROM questionnaire NATURAL JOIN categorie WHERE etat = 1");
            $reponse->execute();
            while($donnees = $reponse->fetch()){
                $preview[] = new previewAdmin($donnees['titreQuestionnaire'], 'DCDCDC', $donnees['idQuestionnaire'], $donnees['nomCategorie'], $donnees['dateQuestionnaire']);
            }
        }
    }else{
        echo '<a href="index.php"><button type="button" class="btn btn-primary btn-lg btn-block">Retourner à l\'accueil</button></a>';
    }
    if(isset($_POST['publier'])){
        $publier = $db->db->prepare("UPDATE questionnaire SET etat = 2 WHERE idQuestionnaire =".$_POST['idQuestionnaire']);
        $publier->execute();

    }
    else if(isset($_POST['archiver'])){
        $archiver = $db->db->prepare("UPDATE questionnaire SET etat = 1 WHERE idQuestionnaire =".$_POST['idQuestionnaire']);
        $archiver->execute();
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