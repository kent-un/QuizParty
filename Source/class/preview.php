<?php
class preview{
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
        echo '
        <a href="questionnaire.php?idQuestionnaire='.$this->idQuestionnaire.'">
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
