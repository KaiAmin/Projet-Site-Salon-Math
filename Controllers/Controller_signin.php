<?php
class Controller_signin extends Controller{

    public function action_signin(){
        require_once('Models/Model.php');
        $m = Model::getModel();
        if( isset($_POST['mail']) && isset($_POST['mdp']) && isset($_POST['mdp_retype']))
        {
        $mailTry = $m->inDataBase($_POST['mail']);
        if(!$mailTry){
            if(isset($_POST['adresse']) && (!strlen($_POST['adresse'])==0)){
                    $etablissement = $_POST['adresse'];
            }
            else{
                $etablissement = $_POST['etablissement'];
            }
            $tab = [
                'mail' => $_POST['mail'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'etablissement' => $etablissement,
                'niveau' => $_POST['niveau'],
                'nombreEleve' => $_POST['nbEleve'],
                'mdp' => $_POST['mdp'],
            ];
            $tabEtablissement = [
                    'etablissement' => $etablissement,
                    'ville' => $_POST['ville'],
                    'cp' => $_POST['cp']
            ];
                $res2 = true;
            if(!$m->existEtablissement($tabEtablissement['etablissement'])){
                $res2 = $m->addEtablissement($tabEtablissement);
            }
            $res = $m->addUser($tab);
            if($res && $res2){
                $_SESSION["connecter"] = true;
                $_SESSION["mail"] = $_POST["mail"];
                $err = '';
                $data = ['titre'=>'home','reg_err'=>$err];
                $this->render("home", $data);  
            }
            else{
                $err = 'Probleme sur la BD';
                $data = ['titre'=>'Inscription','reg_err'=>$err];
                $this->render("signin", $data);
            }
        }
        else{
            $err = 'Mail deja dans la BD';
                $data = ['titre'=>'Error','reg_err'=>$err];
                $this->render("signin", $data);
        }
    }
    $err='Pas de mail ou de mdp';
        $data = ['titre'=>'Inscription','reg_err'=>$err];
        $this->render("signin", $data);
    }

    public function action_default(){
        $this->action_signin();
    }
}