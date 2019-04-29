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
    require_once 'class/connectionDB.php';
    require_once 'class/question.php';
    $db = new connectionDb();

    $color = $_GET['1'];
    $categorie = $_GET['2'];
    $nbQuestions = $_GET['3'];
    $idQuestionnaire = $_GET['4'];
    $titreQuest = $_GET['5'];

    $req = $db->db->prepare('SELECT idQuestion, question, choix FROM question WHERE idQuestionnaire = '.$idQuestionnaire);
    $req->execute();
    while($donnees = $req->fetch()){
        $idQuestions[] = $donnees['idQuestion'];
        $questions[] = $donnees['question'];
        $choix[] = $donnees['choix'];
    }
    $nbBonnesRep = 0;
    for($y=0; $y<=(count($questions))-1 ; $y++){
        for($x=0; $x<=(count($choix)-1); $x++){
            if($choix[$x][$y+1]['bonneRep']==true){
                $nbBonnesRep++;
            };

    }};
    ?>
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php 
            for($x=0; $x<=$nbQuestions; $x++){
                echo '<li data-target="#carousel" data-slide-to="'.$x.'"></li>';
            }

            ?>
        </ol>
            <form action="result.php" method="post">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card text-white mb-3" style="max-width: 20rem; height:100%; background-color:#<?php echo $color ?>;">
                            <div class="card-header">Catégorie <?php echo $categorie ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $titreQuest ?></h4>
                                <p class="card-text">Prêt à commencer ?</p>
                                <ul>
                                </ul>
                            </div>
                </div>
            </div>
            <?php 
            for($y=0; $y<count($idQuestions); $y++){
                $cardQuestions[$y] = new question($categorie, $color, $titreQuest, $idQuestions[$y], $questions[$y], $choix[$y]);
            }
            ?>
            
            <div class="carousel-item">
                <div class="card text-white mb-3" style="max-width: 20rem; height:100%; background-color:#<?php echo $color ?>;">
                            <div class="card-header">Catégorie <?php echo $categorie ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $titreQuest ?></h4>
                                <p class="card-text">Fin du quizz</p>
                                <input type="hidden" name="categorie" value="<?php echo $categorie ?>">
                                <input type="hidden" name="color" value="<?php echo $color ?>">
                                <input type="hidden" name="titre" value="<?php echo $titreQuest ?>">
                                <input type="hidden" name="idQuest" value="<?php echo $idQuestionnaire ?>" >
                                <input type="hidden" name="nbQuest" value="<?php echo $nbQuestions ?>" >
                                <input type="hidden" name="nbBonnesRep" value="<?php echo $nbBonnesRep ?>" >
                                <button type="submit" id="result" name="result" class="btn btn-success btn-lg btn-block">Voir le résultat</button>
                            </div>
                </div>
            </div>
            </form>
        </div>
        <a class="carousel-control-prev" style='display:none;' href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" style='background-color:green; opacity:100; height:40px; width:40px; margin-top:auto; margin-bottom:auto; margin-right:5%;border-radius:50%;' href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
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