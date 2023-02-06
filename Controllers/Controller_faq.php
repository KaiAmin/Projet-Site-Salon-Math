<?php
class Controller_faq extends Controller{

    /* Action qui crée la page faq */
    public function action_faq(){
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = ['titre'=>'FAQ'];
            $this->render("faq", $data);
    }

    /* Action par défault renvoie vers l'action faq */
    public function action_default(){
        $this->action_faq();
    }

}