<?php
class Controller_planning extends Controller{
    
    /* Action qui crée la page d'accueil */
    public function action_planning(){
            session_start();
            require_once('Models/Model.php');
            $m = Model::getModel();
            if($_SESSION['connecter']){
                $data = ['titre'=>'Planning'];
                $this->render("planning", $data);   
            }
            else{
                $data = ['titre'=>'Accueil'];
            $this->render("home", $data);
            }
    }

    public function action_test(){
        session_start();
        require_once('Models/Model.php');
        $data = ['titre'=>'test'];
        $count = 0;
        $req = "'select * from creneau inner join stand on creneau.id_stand=stand.id_stand join niveauvisiteur on stand.niveau_visiteur=niveauvisiteur.id_niveau;'";
        if (isset($_POST['niveau']) && strlen($_POST['niveau']) != 0) {
            $data['filtreNiveau'] = $_POST['niveau'];
            $count += 1;
            $req .= 'niveau_visiteur=’' . $_POST['niveau'].'’';
        }
        if(isset($_POST['date']) && strlen($_POST['date'])!=0){
            $data['filtreDate'] = $_POST['date'];
            $count += 1;
            $req .= ' and date_creneau=' . $_POST['date'];
        }
        if(isset($_POST['filtreHD']) && isset($_POST['filtreHF']) && strlen($_POST['filtreHD'])!=0 && strlen($_POST['filtreHF'])!=0 ){
            $data['filtreHD'] = $_POST['filtreHD'];
            $data['filtreHF'] = $_POST['filtreHF'];
            $count += 1;
            $req .= ' and heure_debut = ' . $_POST['filtreHD'] . ' and heure_fin'. $_POST['filtreHF'];
        }
        if(isset($_POST['filtreNom']) && strlen($_POST['filtreNom']) != 0 ){
            $data['filtreNom'] = $_POST['filtreNom'];
            $count += 1;
            $req .= ' and nom_stand = ' . $_POST['filtreNom'];
        }
        if(isset($_POST['filtreDuree']) && strlen($_POST['filtreDuree'])!=0){
            $data['filtreDuree'] = $_POST['filtreDuree'];
            $count += 1;
            $req .= " and duree = '" . $_POST['filtreDuree']."'";
        }
        if($count == 0){
            $data['noFiltre'] = true;
        }
        else{
            if($count == 1){
            }
        }
        $data['count'] = $count;
        $data['requete']=$req;
        $this->render('planning', $data);
    }

    /* Action par défault renvoie vers l'action home */
    public function action_default(){
        $this->action_planning();
    }

    public function action_filtre(){
        session_start();
        require_once('Models/Model.php');
        $m = Model::getModel();
    }
}