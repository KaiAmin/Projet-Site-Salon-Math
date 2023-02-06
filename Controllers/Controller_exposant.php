<?php
class Controller_Exposant extends Controller{


    public function action_reserver(){
      session_start();
      require_once('Models/Model.php');
      $m = Model::getModel();
      $data = $m->AllStands();
      $this->render("exposant", $data);

    }
    public function action_default(){
        $this->action_reserver();

    }
    public function action_url(){
      session_start();
      $m = Model::getModel();
      $id = $m->getIdStand(urldecode($_GET['nom_stand']));
      $data = $m->getStandInfos($id[0]['id_stand']);
      $this->render("afficheStand", $data);
    }

      public function action_afficheurCr(){
        session_start();
        $m = Model::getModel();
        $id = $m->getIdStand(urldecode($_GET['nom_stand']));
        $data['hour'] = $m->getStandInfos($id[0]['id_stand']);
        $array = $m->getCreneaufromId($id);

        $i = 0;
        foreach ($array as $key => $value) {
          if($value['disponible'] == 0){
            $id_prof = $m->getproffromcreaneau($value['id_creneau']);
            $eta = $m->getEtablissementfromProf($id_prof);
            $nbPlace_prise = $m->getPlacefromidcreneau($value['id_creneau']);
            $array[$i]['title']= $_GET['nom_stand'] .'  '. $nbPlace_prise['nbPlace_restant']. '  ont Réservé De ' . $eta['etablissement'];
            $array[$i]['color']= '#808080';
            $i = $i+1;

          }
          else{
              $array[$i]['title']=$_GET['nom_stand'].'  Disponible';
              $array[$i]['color']= '#00BFFF';
              $i = $i+1;
          }
        }
        $data['t'] = $array  ;
        $this->render("afficheStand", $data);
        }


}