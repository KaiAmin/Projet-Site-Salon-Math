<?php
class Controller_password extends Controller{

    /* Crée la page mdp oublié demandant l'email du compte de l'utilisateur */
    public function action_password(){
            require_once('Models/Model.php');
            $m = Model::getModel();
            $data = [];
            $this->render("password", $data);
    }

    /* Action par défault, renvoie vers l'action password */
    public function action_default(){
        $this->action_password();
    }

    /* On fait attendre l'utilisateur ici le temps qu'il confirme son email 
        Ou on lui envoie dans l'email direct un lien qui clique 
    */
    public function action_waitScreen(){
        require_once('Models/Model.php');
        $m = Model::getModel();
        if(isset($_POST['mail'])){
            if($m->inDataBase($_POST['mail'])){
                sendMailPassword($_POST['mail']);
                setcookie('mail', $_POST["mail"], time() + 3600 ,null,null,true,true);
                $data=[];
                $this->render("waitingScreen",$data);
                require_once ('Utils/function.php');
            }
            else{
                /* pas dans la db */
                $data=["mail" => $_POST["mail"],
                        "error" => "unfound_mail"];
                $this->render("password",$data);
            }
        }
        else{
            $data=["mail" => $_POST["mail"],
                    "error" => "no_data"]; 
            $this->render("password",$data);
        }
    }

    /* Ici on test si les mdp sont corrects
        et on le met a jour dans la base de données
    */
    
    public function action_newPassword(){
        require_once('Models/Model.php');
        $m = Model::getModel();
        if(isset($_POST['newpswd']) && isset($_POST['confirmpswd'])) {
            $data=["mail" => $_COOKIE["mail"]];
            if($_POST['newpswd'] == $_POST['confirmpswd']){

                $res=$m->updatePassword($_POST['newpswd'],$_COOKIE['mail']);
                if($res){
                    $this->render("home",$data);
                }
                else{
                    $data = [
                        'title' => "Error",
                        'message' => "Problème dans la base de données",
                    ];
                    $this->render("message", $data);
                }
            }
            else{
                $this->render('setPassword',$data);
            }
        } 
        else {
                echo ('probleme');}
        }
    }
