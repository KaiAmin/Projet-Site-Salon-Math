<?php
class Controller_contact extends Controller{
    /* Action qui crée la page d'accueil */
    public function action_contact(){
            session_start();
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = ['titre'=>'Contact'];
            $this->render("contact", $data);

    }

    public function action_sendMail(){
        require_once('Models/Model.php');
        $m = Model::getModel();
        try{
            if(isset($_POST['mail']) && isset($_POST['message']) && isset($_POST['nom']) ){
                require_once ('../MVC/Utils/functions.php');
                $res=sendMailContact($_POST['nom'],$_POST['mail'],$_POST['message']);
                if($res){
                    $data = ['title'=>'contact'];
                    $this->render("contact", $data);    
                }
                $data = ['title'=>'Error','message'=>"Erreur le mail ne s'est pas envoyé"];
                $this->render("message", $data);
            }   
            else{
                $data = ['title'=>'Error','message'=>"Erreur les valeurs du formulaire n'ont pas était envoyé"];
                $this->render("message", $data); 
            }
        }
        catch (Exception $e){
            echo($e);
        }
    }

    /* Action par défault renvoie vers l'action home */
    public function action_default(){
        $this->action_contact();
    }
}