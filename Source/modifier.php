<?php session_start()?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <title>QuizParty | Modifier</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet"> 
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <main>
    <h2>Modification de quiz<br>
    <small class="text-muted"><?php $titre = $_GET['titre']; echo $titre; ?></small></h2>
    <div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
    <div class="card-body">
        <p class="card-text">
        <?php 
        require_once 'class/connectionDB.php';
        $idQuest = $_GET['id'];
        $db = new connectionDb();
        $questionnaire = $db->db->prepare('SELECT * FROM questionnaire NATURAL JOIN categorie WHERE idQuestionnaire = '.$idQuest);
        $questionnaire->execute();
        $donnees = $questionnaire->fetch();
        $idCategorie = $donnees['idCategorie'];
        $nomCategorie = $donnees['nomCategorie'];
        $questions = $db->db->prepare('SELECT * FROM question WHERE idQuestionnaire = '.$idQuest);
        $questions->execute();
        while($donneesQ= $questions->fetch()){
            $idQuestion[] = $donneesQ['idQuestion'];
            $question[] =  $donneesQ['question'];
            $choix[] = json_decode($donneesQ['choix'], true);
        }

        if(isset($_POST['valider'])){
            $modifTitre = $_POST['titre'];
            for($x=0; $x<=(count($question)-1); $x++){
                $modifCheck[$x]=$_POST['check'.($x+1)];
                $modifQuest[$x] = $_POST['titre'.($x+1)];
                $modifReponse[$x]= $_POST['rep'.($x+1)];
                for($y=0; $y<=(count($modifReponse[$x])-1); $y++){
                    for($i=0; $i<=(count($modifCheck[$x])-1); $i++){
                        if(((intval($modifCheck[$x][$i]))==($y+1))){
                            $bonnerep[$y]=true;
                            break;
                        }else{
                            $bonnerep[$y]=false;
                        }
                    }
                    $arrayRep[$y+1]=array(
                        "intitulé" => $modifReponse[$x][$y],
                        "bonneRep" => $bonnerep[$y]
                    );
                }
                $formattedRep[$y] = json_encode($arrayRep, JSON_UNESCAPED_UNICODE);
                $req=$db->db->prepare("UPDATE question SET question = :question, choix = :choix WHERE idQuestion = :idQuestion");
                $req->execute(array(
                    'question' => $modifQuest[$x],
                    'choix' => $formattedRep[$y],
                    'idQuestion' => $idQuestion[$x]
                ));
            }
            $req=$db->db->prepare("UPDATE questionnaire SET titreQuestionnaire ='$modifTitre' WHERE idQuestionnaire = ".$idQuest);
            $req->execute();
           
        }
        ?>
        <form method="post">
            <div class="form-group">
                <label for="titre" class="col-sm-2 col-form-label">Titre du questionnaire</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" id="titre" name="titre" value="<?php echo $titre; ?>">
                </div>
            </div>
            <?php  
            for($x=0; $x<=((count($question))-1); $x++){
                echo '
                <div class="form-group">
                    <label for="titre" class="col-sm-2 col-form-label">Question n°'.($x+1).':</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" id="titre'.($x+1).'" name="titre'.($x+1).'" value="'.$question[$x].'">
                    </div>
                </div>
                ';
                for($y=0; $y<=((count($choix[$x]))-1); $y++){
                    echo '
                    <div class="form-group">
                    <label for="titre" class="col-sm-2 col-form-label">Réponse n°'.($y+1).':</label>
                    <div class="col-sm-10">';
                    if($choix[$x][$y+1]['bonneRep']==True){
                        echo '<input type="checkbox" class="" name="check'.($x+1).'[]" checked="" value="'.($y+1).'">';
                    }
                    else{   
                        echo
                        '<input type="checkbox" class="" name="check'.($x+1).'[]"  value="'.($y+1).'">';

                    }
                    echo'
                        <input type="text" class="form-control-plaintext" id="rep'.($x+1).'" name="rep'.($x+1).'[]" value="'.$choix[$x][$y+1]['intitulé'].'">
                    </div>
                    </div>
                    '; 
                }
            }
            ?>
            <input type="submit" value="Valider" name="valider" class="btn btn-success btn-lg btn-block"/>
        </form>
        </p>
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