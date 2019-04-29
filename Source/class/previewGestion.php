<?php

class previewGestion{
    private $titleQuiz;
    private $numberQuest; 
    private $color;
    private $idQuestionnaire; 

    public function __CONSTRUCT($titleQuiz, $numberQuest, $color, $idQuestionnaire){
        $this->titleQuiz = $titleQuiz;
        $this->numberQuest = $numberQuest;
        $this->color = $color;
        $this->idQuestionnaire = $idQuestionnaire;
        $this->makePreview(); 
    }
    public function makePreview(){
        require_once 'connectionDB.php';
        $db = new connectionDb();
        $req=$db->db->prepare("SELECT nomCategorie FROM questionnaire NATURAL JOIN categorie WHERE idQuestionnaire= $this->idQuestionnaire LIMIT 1");
        $req->execute();
        $nomcategorie = $req->fetch();
        echo '
        <a href="modifier.php?id='.$this->idQuestionnaire.'&titre='.$this->titleQuiz.'">
        <div class="card mb-3" style="color:white; max-width: 20rem; background-color:#'.$this->color.';">
            <div class="card-body">
            '.$this->titleQuiz.' 
            <blockquote class="blockquote mb-0">
                <footer style="color:white;"class="blockquote-footer">'.$this->numberQuest.' questions</footer>
                </blockquote>
            </div>
        </div></a>';
    }
} 
?>