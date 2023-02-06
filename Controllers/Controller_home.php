<?php
class Controller_home extends Controller{

    /* Action qui crée la page d'accueil */
    public function action_home(){
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = ['titre'=>'Accueil','exitInfo' => 0];
            $this->render("home", $data);
    }
    public function action_disconnect(){
        if(session_status()==1){session_start();
            session_gc();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }
        $data = ['titre'=>'Accueil','exitInfo' => 1];
        $this->render("home", $data);
    }

    /* Action par défault renvoie vers l'action home */
    public function action_default(){
        $this->action_home();
    }
}