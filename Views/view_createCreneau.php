<?php require "view_debut.php" ?>
<?php require_once('Models/Model.php');
            $m = Model::getModel();
            $tabAllStandInfo = $m->getTempo();
            $i = 0;
            foreach ($tabAllStandInfo as $key => $value) {
                $duree = $tabAllStandInfo[$key]['duree'];
                if($duree == null){
                    $duree = 0;
                } else {
                    /* Je sais pas new colonne excel */
                    $nombreExposantJeudi = $tabAllStandInfo[$key]['jeudi'];
                    $nombreExposantVendredi = $tabAllStandInfo[$key]['vendredi'];
                    $intersession = $tabAllStandInfo[$key]['intersession'];

        if ($tabAllStandInfo[$key]['allday'] == 'oui') {
            $allday = true;

        } else {
            $allday = false;
        }

        $niveauSepare = explode(', ', $tabAllStandInfo[$key]['niveau']);
        if (count($niveauSepare) == 3) {
            $niveau = 'PCL';
        } elseif (count($niveauSepare) > 2) {
            if ($niveauSepare[0] == "Primaire") {
                if ($niveauSepare[1] == "Collège") {
                    $niveau = 'PC';
                } else {
                    $niveau = 'PL';
                }
            }
            else{
                $niveau = 'CL';
            }
        } else {
            if ($niveauSepare[0] == "Primaire") {
                $niveau = 'P';
            } elseif ($niveauSepare[0] == "Collège") {
                $niveau = 'C';
            } else {
                $niveau = 'L';
            }
        }
        
        $presentJeudi = $tabAllStandInfo[$key]['presentjeudi'];
        $presentVendredi = $tabAllStandInfo[$key]['presentvendredi'];
        if ($presentJeudi == 'PrÃ©sent') {

            $datejeudiCreneau = '2023-01-19';
                 /* Nombre de creneau a faire*/
                 $pausedebut = $tabAllStandInfo[$key]['pausedebut'];
                 $pausefin = $tabAllStandInfo[$key]['pausefin'];
                 
                 
                 $nomStand = $tabAllStandInfo[$key]['nom_stand'];
                 $description = $tabAllStandInfo[$key]['description'];
                 $capacite = $tabAllStandInfo[$key]['capacite'];
                 
                 $tabStand = ['nom_stand' => $nomStand, 'description' => $description, 'niveau_visiteur' => $niveau, 'capacite' => $capacite, 'allday' => $allday, 'duree' => $duree, 'intersession' => $intersession, 'pausedebut' => $pausedebut, 'pausefin' => $pausefin];
                 $res = $m->addStand($tabStand);
                 $origin = DateTime::createFromFormat('H:i:s', $pausedebut);
                 $target = DateTime::createFromFormat('H:i:s', $pausefin);
                 if (!$origin) {
                     $tempsPause = 0;
                 } else {
                     
                     $interval = date_diff($origin, $target);
                     $tempsPause = $interval->format('%H:%i');
                     $tempsPauseHours = 0;
                     if (strlen($tempsPause > 2)) {
                         $tempsPauseHours = substr($tempsPause, 0, 2);
                         $tempsPauseHours = explode(':', $tempsPause);
                         $tempsPauseHours = intval($tempsPauseHours);
                         if (strlen($tempsPauseHours) > 2) {
                             $tempsPauseHours = 120;
                         } else {
                             $tempsPauseHours = 60;
                         }
                     }
                     $tempsPause = intval(substr($tempsPause, 3, 5));
                     $tempsPause = intval($tempsPause) + $tempsPauseHours;
                 }
                 
            $dureeOnce = $duree + $intersession;
            $tempsTotal = 0;
            $nbcreneau = 0;
            while ($tempsTotal < 540 - $tempsPause and $dureeOnce != 0) {
                $tempsTotal += $dureeOnce;
                $nbcreneau += 1;
                }

            $datedebut = "09:00:00";
            $datefin = date('H:i:s', strtotime($datedebut. ' + '.$duree.' minutes'));
            $idStand = $m->getIdStand($nomStand);
            $idStand = $idStand[0]['id_stand'];
            $tabCreneau = ['nbplace_restant'=>$capacite,'date_creneau'=>$datejeudiCreneau,'id_stand'=>$idStand,'id_superviseur'=>1,'heure_debut' => $datedebut, 'heure_fin' => $datefin,'disponibilite' => true];
            $m->addCreneau($tabCreneau);

            $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$intersession .' minutes'));
            for ($i=0; $i < $nbcreneau; $i++) { 
                $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$duree .' minutes'));
                $datefin = date('H:i:s', strtotime($datedebut. ' + '.$duree.' minutes'));
                if(strtotime($datedebut) >= strtotime($pausedebut) and strtotime($datefin) <= strtotime($pausefin)){
                }
                else{
                    $tabCreneau['heure_debut'] = $datedebut;
                    $tabCreneau['heure_fin'] = $datefin;
                    $m->addCreneau($tabCreneau);
                    $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$intersession .' minutes'));
                }    
            }
        }
        if ($presentVendredi == 'PrÃ©sent') {
            $datevendrediCreneau = '2023-01-20';
                 
                /* Nombre de creneau a faire*/
            
                 $pausedebut = $tabAllStandInfo[$key]['pausedebut'];
                 $pausefin = $tabAllStandInfo[$key]['pausefin'];
                 
                 
                 $nomStand = $tabAllStandInfo[$key]['nom_stand'];
                 $description = $tabAllStandInfo[$key]['description'];
                 $capacite = $tabAllStandInfo[$key]['capacite'];
                 
                 $tabStand = ['nom_stand' => $nomStand, 'description' => $description, 'niveau_visiteur' => $niveau, 'capacite' => $capacite, 'allday' => $allday, 'duree' => $duree, 'intersession' => $intersession, 'pausedebut' => $pausedebut, 'pausefin' => $pausefin];
                 $res = $m->addStand($tabStand);
                 $origin = DateTime::createFromFormat('H:i:s', $pausedebut);
                 $target = DateTime::createFromFormat('H:i:s', $pausefin);
                 if (!$origin) {
                     $tempsPause = 0;
                 } else {
                     
                     $interval = date_diff($origin, $target);
                     $tempsPause = $interval->format('%H:%i');
                     $tempsPauseHours = 0;
                     if (strlen($tempsPause > 2)) {
                         $tempsPauseHours = substr($tempsPause, 0, 2);
                         $tempsPauseHours = explode(':', $tempsPause);
                         $tempsPauseHours = intval($tempsPauseHours);
                         if (strlen($tempsPauseHours) > 2) {
                             $tempsPauseHours = 120;
                         } else {
                             $tempsPauseHours = 60;
                         }
                     }
                     $tempsPause = intval(substr($tempsPause, 3, 5));
                     $tempsPause = intval($tempsPause) + $tempsPauseHours;
                 }
            
            $dureeOnce = $duree + $intersession;
            $tempsTotal = 0;
            $nbcreneau = 0;
            while ($tempsTotal < 540 - $tempsPause and $dureeOnce != 0) {
                $tempsTotal += $dureeOnce;
                $nbcreneau += 1;
                }

            $datedebut = "09:00:00";
            $datefin = date('H:i:s', strtotime($datedebut. ' + '.$duree.' minutes'));
            $idStand = $m->getIdStand($nomStand);
            $idStand = $idStand[0]['id_stand'];
            $tabCreneau = ['nbplace_restant'=>$capacite,'date_creneau'=>$datevendrediCreneau,'id_stand'=>$idStand,'id_superviseur'=>1,'heure_debut' => $datedebut, 'heure_fin' => $datefin,'disponibilite' => true];
            $m->addCreneau($tabCreneau);

            $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$intersession .' minutes'));
            for ($i=0; $i < $nbcreneau; $i++) { 
                $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$duree .' minutes'));
                $datefin = date('H:i:s', strtotime($datedebut. ' + '.$duree.' minutes'));
                if(strtotime($datedebut) >= strtotime($pausedebut) and strtotime($datefin) <= strtotime($pausefin)){
                }
                else{
                    $tabCreneau['heure_debut'] = $datedebut;
                    $tabCreneau['heure_fin'] = $datefin;
                    $m->addCreneau($tabCreneau);
                    $datedebut = date('H:i:s', strtotime($datedebut. ' + '.$intersession .' minutes'));
                }    
            }
        }

        }
    }

?>
<p class="m-3"> <strong> Pas encore la possiblité d'ajouter un fichier donc ajout manuel du Export  </strong> </p>
           <input class="m-3" type="file" name="fileExport"> 


<?php require "view_fin.php" ?>