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
    <div class="card border-success text-center mb-3" style="max-width: 20rem;">
        <div class="card-body">
            <h4 class="title">Inscription</div>
            <div class="card-text">
            <form method="post" action="" id="inscription" >
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" name="pseudo" id="pseudo">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <input type="submit" name="submit" class="btn btn-success" value="S'inscrire">
            </form>
        </div>
    </div>
            <?php 
                require_once 'class/connectionDB.php';

                if(isset($_POST['submit'])){
                $db = new connectionDb();
                $pseudo = $_POST['pseudo'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = $_POST['email'];
                $reponse = $db->db->prepare("INSERT INTO utilisateur(pseudo, email, statut, motdepasse, dateInscription) VALUES ('".$pseudo."', '".$email."', 1, '".$password."', '".date("Y-m-d H:i:s")."')");
                if($reponse->execute()){
                    echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Votre profil a bien été créé! Profitez désormais des fonctionnalités membre de QuizParty en vous connectant.
                    </div>';
                }else{
                    echo '<div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Veuillez réessayer de vous inscrire.
                  </div>';
                };

                }
            ?>
    </div>
    </main>
    <footer>

    </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>   
</body>
</html>