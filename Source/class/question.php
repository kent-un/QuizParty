<?php

class question{
    private $nomCat; 
    private $color; 
    private $titreQuest;
    private $idQuestion;
    private $question; 
    private $choix;


    public function __CONSTRUCT($nomCat, $color, $titreQuest, $idQuestion , $question, $choix){
        $this->nomCat = $nomCat;
        $this->color = $color; 
        $this->titreQuest = $titreQuest;
        $this->idQuestion = $idQuestion; 
        $this->question = $question;
        $this->choix = $choix;
        $this->createQuest();  
    }

    public function createQuest(){
        echo'
        <div class="carousel-item">
        <div class="card text-white mb-3" style="max-width: 20rem; height:100%; background-color:#'.$this->color.';">
                    <div class="card-header">Catégorie '.$this->nomCat.'
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">'.$this->titreQuest.'</h4>
                        <p class="card-text">'.$this->question.'</p>
                        <ul>';
        $decodeRep = json_decode($this->choix, true);
        // var_dump($decodeRep);
        $compteurTrue = 0;

        for($x=1; $x<=count($decodeRep); $x++){
            if($decodeRep[$x]['bonneRep']==true){
                $compteurTrue++;
            }
        }

        if(($compteurTrue)>1){
            for($x=1; $x<=count($decodeRep); $x++){
    
                echo '<li>
                        <input type="checkbox" id="quest'.$this->idQuestion.'" name="rep[]" value="';
                        if($decodeRep[$x]['bonneRep']==true){
                            echo 'true';
                        }else{
                            echo 'false';
                        }
                        
                echo '">
                        <label for="quest'.$this->idQuestion.'">'.$decodeRep[$x]['intitulé'].'</label></li>';
            }    
        }elseif(($compteurTrue)==1){
            for($x=1; $x<=count($decodeRep); $x++){
    
                echo '<li>
                        <input type="radio" id="quest'.$this->idQuestion.'" name="rep[]" value="';
                        if($decodeRep[$x]['bonneRep']==true){
                            echo 'true';
                        }else{
                            echo 'false';
                        }
                        
                echo '">
                        <label for="quest'.$this->idQuestion.'">'.$decodeRep[$x]['intitulé'].'</label></li>';
            } 
        }

        echo'
                        </ul>
                    </div>
        </div>
        </div>';
    }
}
?>