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
        <p class="division">
            Catégories
        </p>
        <?php 
        require_once 'class/connectionDB.php';
        require_once 'class/categorie.php';
        $db = new connectionDb();
        $reponse = $db->db->prepare('SELECT * FROM categorie');
        $reponse->execute();
        echo '<div class="container"><div class="row">';
        while($donnees = $reponse->fetch()){
            $categories[] = new categorie($donnees['nomCategorie'], $donnees['couleur'], $donnees['icon']);
        }
        echo '</div></div>';
        ?>
        <p class="division">
            Derniers quiz
        </p>
        <?php
        require_once 'class/preview.php';
        $reponse2 = $db->db->prepare('SELECT idQuestionnaire, titreQuestionnaire, idCategorie FROM questionnaire WHERE etat = 2  ORDER BY idQuestionnaire DESC LIMIT 2');
        $reponse2->execute();
        while($donnees2= $reponse2->fetch()){
            $previewId[]=$donnees2['idQuestionnaire'];
            $previewCat[]=$donnees2['idCategorie'];
            $previewTitre[]=$donnees2['titreQuestionnaire'];
        }
        $reponse3 = $db->db->prepare('SELECT couleur FROM categorie WHERE idCategorie = '.$previewCat[0].'');
        $reponse3->execute();
        $previewColor[0]=($reponse3->fetch());

        $reponse4 = $db->db->prepare('SELECT couleur FROM categorie WHERE idCategorie = '.$previewCat[1].'');
        $reponse4->execute();
        $previewColor[1]= $reponse4->fetch();

        $reponse5 = $db->db->prepare('SELECT count(question) AS numberQuest FROM question WHERE idQuestionnaire ='.$previewId[0]);
        $reponse5->execute();
        $previewNb[0]=($reponse5->fetch());

        $reponse6 = $db->db->prepare('SELECT count(question) AS numberQuest FROM question WHERE idQuestionnaire ='.$previewId[1]);
        $reponse6->execute();
        $previewNb[1]=($reponse6->fetch());

        for($x=0;$x<2;$x++){
            $preview[$x]= new preview($previewTitre[$x], $previewNb[$x]['numberQuest'], $previewColor[$x]['couleur'], $previewId[$x]);
        }
        ?>
        <p class="division">
            Mieux notés
        </p>
    </main>
    <footer>

    </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   
</body>
</html>