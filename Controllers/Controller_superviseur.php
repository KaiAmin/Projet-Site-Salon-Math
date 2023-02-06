<?php
class Controller_Superviseur extends Controller{
  public function action_default(){
      $this->action_ajoutCreneau();
    }

      public function action_ajoutCreneau(){
          require_once("Models/Model.php");
          $mod = Model::getModel();

          if($mod->IsAStand($_POST["nom"])){
            $nom = $_POST["nom"];
            $id = $mod->getIdStand($nom);
            $heureD = $_POST["HeureD"].':00';
            $heureF = $_POST["HeureF"].':00';
            $jour = $_POST["Jour"];
            $requete = $mod->AjoutCreneau($jour,$heureD,$heureF,$id);
            echo "L'insertion a été correctement effectuée";
            $this->render("ModificationSuper", $data);
            }
        else
        {
        echo "L'insertion à échouée";
        $this->render("ModificationSuper", $data);
        }

    }

}
?>