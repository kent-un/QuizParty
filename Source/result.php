<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    if(isset($_POST['result'])){
        $color = $_POST['color'];
        $categorie = $_POST['categorie'];
        $titreQuest = $_POST['titre'];
        $idQuest = $_POST['idQuest'];
        $nbQuest = $_POST['nbQuest'];
        $nbBonnesRep = $_POST['nbBonnesRep'];
        $rep = $_POST['rep'];
        
        $nbBonnesRepUser = 0;
        var_dump($rep);
        for($x=0; $x<=(count($rep)-1); $x++){
            if($rep[$x]==true){
                $nbBonnesRepUser++;
            }
        }
        echo $nbBonnesRep;
        echo $nbBonnesRepUser; 
        $nbBonnesRepUser = ((100*$nbBonnesRepUser)/$nbBonnesRep);
    }
    ?>
    <div class="card text-white mb-3" style="max-width: 20rem; height:100%; background-color:#<?php echo $color ?>;">
        <div class="card-header">Catégorie <?php echo $categorie ?>
        </div>
        <div class="card-body">
            <h4 class="card-title"><?php echo $titreQuest ?></h4>
            <p class="card-text">Votre score est de: <?php echo $nbBonnesRepUser ?> % </p>
            <ul>
            </ul>
        </div>
    </div>
    </main>
    <footer>

    </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   
<script src="js/index.js"></script>
</body>
</html>