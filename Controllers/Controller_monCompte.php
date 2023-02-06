<?php
class Controller_monCompte extends Controller{
    /* Action qui crée la page d'accueil */
    public function action_monCompte(){
        session_start();
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = [];
            $this->render("monCompte", $data);

    }
    public function action_default(){
        $this->action_monCompte();
    }
}
?>