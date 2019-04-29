<?php

class previewAdmin{
    private $titleQuiz;
    private $color;
    private $idQuestionnaire; 
    private $nomCategorie;
    private $date; 

    public function __CONSTRUCT($titleQuiz, $color, $idQuestionnaire, $nomCategorie, $date){
        $this->titleQuiz = $titleQuiz;
        $this->color = $color;
        $this->idQuestionnaire = $idQuestionnaire;
        $this->nomCategorie = $nomCategorie;
        $this->date = $date;
        $this->makePreview(); 
    }
    public function makePreview(){
        echo '
        <a href="questionnaire.php?1='.$this->color.'&2='.$this->nomCategorie.'&4='.$this->idQuestionnaire.'&5='.$this->titleQuiz.'">
        <div class="card mb-3" style="color:white; max-width: 20rem; background-color:#'.$this->color.';">
            <div class="card-body">
            '.$this->titleQuiz.' 
            </div></a>
            <blockquote class="blockquote mb-0">
                <footer style="color:white;"class="blockquote-footer"> Créé le '.$this->date.'</footer>
            </blockquote>
            <br>
            <form method="post" action="#">
            <div class="modal-footer">
                <input type="hidden" value="'.$this->idQuestionnaire.'" name="idQuestionnaire">
                <input type="submit" value="Publier "name="publier" class="btn btn-primary">
                <input type="submit" value="Archiver" name="archiver" class="btn btn-secondary">
            </div>
            </form>
        </div>';
    }
} 
?>