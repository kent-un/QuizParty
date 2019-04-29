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
    if(isset($_SESSION['idUtilisateur']) && $_SESSION['statut']==2){
    echo '
    <div class="table-responsive-md">
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Utilisateur</th>
            <th scope="col">Supprimer l\'utilisateur</th>
            </tr>
        </thead>
        <tbody>';
    $req = new connectionDb();
    $blop = $req->db->prepare("SELECT idUtilisateur, pseudo, email, statut FROM utilisateur");
    $blop->execute();
    while($donnees= $blop->fetch()){
        if($donnees['statut']==2){
            echo '<tr class="table-warning">
            <td>'.$donnees['pseudo'].' | '.$donnees['email'].'</td>
            <td>admin</td>
          </tr>';
        }else{
            echo '<tr>
            <td>'.$donnees['pseudo'].' | '.$donnees['email'].'</td>
            <form action="#" method="post">
            <input type="hidden" name="id" value="'.$donnees['idUtilisateur'].'">
            <td><button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button></td>
            </form>
          </tr>';

        }
    }
    
    echo'
        </tbody>
    </table>
    </div>';
    }else{
        echo '<a href="index.php"><button type="button" class="btn btn-primary btn-lg btn-block">Retourner à l\'accueil</button></a>';
    }
    if(isset($_POST['supprimer'])){
        $idUtilisateur = $_POST['id'];
        $db = new connectionDb();
        $req = $db->db->prepare("DELETE FROM utilisateur WHERE idUtilisateur = $idUtilisateur");
        $req->execute();

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