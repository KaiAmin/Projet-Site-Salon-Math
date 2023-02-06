<?php
class Controller_login extends Controller{

    public function action_login(){
            session_start();
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = [];
            $this->render("login", $data);
    }

    public function action_default(){
        $this->action_login();
    }
    public function action_tryMdp(){
        require_once('Models/Model.php');
        $m = Model::getModel();
        $data = [];
        session_start();
        if(isset($_POST['id']) && isset($_POST['mdp'])){
            $res = $m->inDataBase($_POST['id']);
            if($res){
                $mdpH = $m->getMdp($_POST['id']);
                $mdpTry = password_verify($_POST['mdp'], $mdpH[0]['mdp']);
                if($mdpTry){
                    $_SESSION["connecter"] = true;
                    $_SESSION["mail"] = $_POST["id"];
                    $data = [];
                    $this->render("home", $data);
                }
                else{
                    $data = ['mdpFalse' => true,'idFalse' => false];
                    $this->render("login", $data);
                }
            }
            else{
                $data = ['idFalse' => true,'mdpFalse' => false];
                $this->render("login", $data);
            }
        }
        else{
            $this->action_login();
        }
    }
}