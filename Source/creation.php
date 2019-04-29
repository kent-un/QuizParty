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
    if(isset($_SESSION['idUtilisateur'])){
        if(isset($_POST['creer'])){
            require_once 'class/connectionDB.php';
            require_once 'class/categorie.php';
            $db = new connectionDb();
            $titre = addslashes($_POST['titre']);
            $idUtilisateur = $_SESSION['idUtilisateur'];
            $idCategorie = $_POST['categorie'];
            $numberQuestions = $_POST['numberQuestions'];
            $reponse = $db->db->prepare("INSERT INTO questionnaire(titreQuestionnaire, etat, dateQuestionnaire, idUtilisateur, idCategorie) VALUES (:titreQuestionnaire, :etat, :dateQuestionnaire, :idUtilisateur, :idCategorie)");
            $reponse->execute(array(
                'titreQuestionnaire' => $titre,
                'etat' => 0,
                'dateQuestionnaire' => date("Y-m-d H:i:s"),
                'idUtilisateur' => $idUtilisateur,
                'idCategorie' => $idCategorie
            ));
            $idQuestionnaire = $db->db->lastInsertId();
            echo '<form method="post" action="creation.php">
            <input type="hidden" name="numberQuestions" value="'.$numberQuestions.'">
            <input type="hidden" name="idQuestionnaire" value="'.$idQuestionnaire.'">';
            for($x=1; $x<=$numberQuestions; $x++){
                $y = 3;
                echo '
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Question n°'.$x.'</div>
                <div class="card-body">
                <div id="question'.$x.'">
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" name="question'.$x.'" max-lenght="140" class="form-control" id="question">
                    </div>
                    <p>Cochez la/les bonne(s) réponse(s)</p>
                    <div class="form-group">
                        <label for="reponse">Réponse n°1</label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="check'.$x.'[]" value="1">
                            </div>
                        </div>
                        <input type="text" name="reponse'.$x.'[1]" max-lenght="250" class="form-control" id="reponse">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reponse">Réponse n°2</label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" aria-label="Checkbox for following text input" name="check'.$x.'[]" value="2">
                            </div>
                        </div>
                        <input type="text" name="reponse'.$x.'[2]" max-lenght="250" class="form-control" id="reponse">
                        </div>
                        </div>
                        </div>
                        <button type="button" name="addAnswer" id="addAnswer'.$x.'" onclick="addReponse('.$x.','.$y.')" value="'.$x.'" class="btn btn-primary btn-lg btn-block">Ajouter une réponse</button>
                </div>
              </div>';
            }
            echo '<input type="submit" name="validerQuestions" class="btn btn-success btn-lg btn-block"/>';
            echo '</form>';

        }else if(isset($_POST['validerQuestions'])){
            require_once 'class/connectionDB.php';
            require_once 'class/categorie.php';
            $db = new connectionDb();
            $numberQuestions = $_POST['numberQuestions'];
            $idQuestionnaire = $_POST['idQuestionnaire'];
            for($x=1 ; $x<=($numberQuestions) ; $x++){

                $check=$_POST['check'.$x];
                $question[$x]=$_POST['question'.$x];
                $reponses[$x]=$_POST['reponse'.$x];
                for($y=1 ; $y<=(count($reponses[$x])) ; $y++){
                    for($i=0; $i<=(count($check));$i++){
                        if((intval($check[$i]))==$y){
                            $bonneRep[$y]=true;
                            break;
                        }else{
                            $bonneRep[$y]=false;
                        }
                    }
                    $arrayRep[$y]=array(
                        "intitulé" => $reponses[$x][$y],
                        "bonneRep" => $bonneRep[$y]
                    ); 
                }
                $formattedReponses[$y] = json_encode($arrayRep, JSON_UNESCAPED_UNICODE);
                var_dump($formattedReponses);
                echo '<hr>';
                $req=$db->db->prepare('INSERT INTO question(question, choix, idQuestionnaire) VALUES (:question, :choix, :idQuestionnaire)');
                $req->execute(array(
                    'question' => $question[$x],
                    'choix' => $formattedReponses[$y],
                    'idQuestionnaire' => $idQuestionnaire
                ));

            };
            $req= $db->db->prepare('SELECT titreQuestionnaire FROM questionnaire WHERE idQuestionnaire = '.$idQuestionnaire);
            $req->execute();
            $titreQuest = $req->fetch();

            $req2= $db->db->prepare('SELECT * FROM question WHERE idQuestionnaire = '.$idQuestionnaire);
            $req2->execute();
            while($donnees = $req2->fetch()){
                $reponses[]=json_decode($donnees['choix'], true);
            }

            $req3=$db->db->prepare('SELECT question FROM question WHERE idQuestionnaire ='.$idQuestionnaire);
            $req3->execute();
            while($donneesR=$req3->fetch()){
                $questions[]=$donneesR['question'];
            }
           
            
            echo '
            <div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
            <div class="card-header">Récapitulatif</div>
            <div class="card-body">
                <h4 class="card-title">'.$titreQuest['titreQuestionnaire'].'</h4>
                <p class="card-text">';
            for($x=0 ; $x<=((count($questions))-1) ; $x++){
                echo ($x+1).': ';
                echo $questions[$x];
                echo '<hr><ul>';
                for($y=0; $y<=((count($reponses[$x]))-1); $y++){
                    if($reponses[$x][$y+1]['bonneRep']==True){
                    echo '<li>'.$reponses[$x][$y+1]['intitulé'].' <span class="badge badge-pill badge-success">Bonne réponse</span>
                    </li>';
                    }else{
                    echo '<li>'.$reponses[$x][$y+1]['intitulé'].'</li>';
                    }

                }
                echo '<hr></ul>';
            }
            echo'
                </p>
            </div>
            </div>
            <form method="post" action="gestion.php">
            <input type="hidden" name="idQuestionnaire" value="'.$idQuestionnaire.'">
            <input type="submit" value="Valider" name="valider" class="btn btn-success btn-lg btn-block"/>
            </form>';
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
<script src="js/index.js"></script>
</body>
</html>