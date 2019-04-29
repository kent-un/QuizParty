<?php
class categorie{
    private $nomCategorie;
    private $color;
    private $icon;
    private $idCategorie;

    public function __CONSTRUCT($nomCategorie, $color, $icon, $idCategorie){
        $this->nomCategorie = $nomCategorie;
        $this->color = $color;
        $this->icon = $icon;
        $this->idCategorie = $idCategorie;
        $this->makeIcon();
    }
    public function makeIcon(){
        echo '<div class="col catIcon"><a href="categories.php?nomCategorie='.$this->nomCategorie.'&idCategorie='.$this->idCategorie.'&couleur='.$this->color.'"><button class="rondIcon" style="background-color:#'.$this->color.';"><img class="icon" src="'.$this->icon.'"/></button></a><p class="subtitle">'.$this->nomCategorie.'</p></div>';
    }
    public function getCategorie(){
        return $this->nomCategorie;
    }
    
}

?>