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
    if(isset($_SESSION['idUtilisateur'])){
        if($_GET['gestion']==1){
            require_once 'class/connectionDB.php';
            require_once 'class/categorie.php';
            $db = new connectionDb();
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
            echo 'prout numéro 2';
        }
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