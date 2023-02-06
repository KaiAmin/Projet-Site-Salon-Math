<?php
class Controller_test extends Controller{

    /* Action qui crée la page d'accueil */
    public function action_test(){
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = ['titre'=>'yes'];
            $this->render("test", $data);
    }
    /* Action par défault renvoie vers l'action home */
    public function action_default(){
        $this->action_test();
    }
}