<?php
class categorie{
    private $nomCategorie;
    private $color;
    private $icon;

    public function __CONSTRUCT($nomCategorie, $color, $icon){
        $this->nomCategorie = $nomCategorie;
        $this->color = $color;
        $this->icon = $icon;
        $this->makeIcon();
    }
    public function makeIcon(){
        echo '<div class="col catIcon"><button class="rondIcon" style="background-color:#'.$this->color.';"><img class="icon" src="'.$this->icon.'"/></button><p class="subtitle">'.$this->nomCategorie.'</p></div>';
    }
    public function getCategorie(){
        return $this->nomCategorie;
    }
    
}

?>