<?php
use function CommonMark\Render;
class Controller_creneau extends Controller{

  public function action_default(){
    $this->action_creneau();

}
  public function action_creneau(){
  require_once("Models/Model.php");
  $mod = Model::getModel();
  $nom = $_POST["nom"] ;
  $id = $mod->getIdStand($nom);
  $heureD = $_POST["HeureD"].':00';
  $heureF = $_POST["HeureF"].':00';
  $jour = $_POST["Jour"];
  $requete = $mod->AjoutCreneau($jour,$heureD,$heureF,$id);
    if($requete)
    {
      echo("L'insertion a été correctement effectuée") ;
    }
    else
    {
      echo("L'insertion à échouée") ;
    }
    $data = ['titre'=>'idk','exitInfo' => 0];
    $this->render("home", $data);
  }
  public function action_createCreneau(){
    require_once('Models/Model.php');
    $m = Model::getModel();
    $data = ['titre'=>'CreateCreneau','exitInfo' => 0];
    $this->render("createCreneau", $data);
  }
}
?>