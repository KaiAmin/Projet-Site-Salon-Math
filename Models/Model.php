<?php
class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * bCGmAmNluTxMrrASveyX uknow iknow
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */                    
 private function __construct()
{
$dsn='pgsql:host=localhost;dbname=postgres';
$login='postgres';
$mdp='qiyana&';
$this->bd = new PDO($dsn, $login, $mdp);
$this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$this->bd->query("SET names 'utf8'");
}

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
 
    /**
     * Méthode qui rajoute dans la base de donnée les informations à la création d'un nouveau compte d'utilisateur
     * @param array $tab tableau contenant les données de l'utilisateur
     * @return bool
     */
    public function addUser($tab){
        $pswd = $tab['mdp'];
        $options = ['cost' => 13];
        $pswdH=password_hash($pswd, PASSWORD_BCRYPT, $options);
        $req = $this->bd->prepare('insert into professeur (mail,nom,prenom,etablissement,niveau,nombreEleve,mdp) values (:mail,:nom,:prenom,:etablissement,:niveau,:nombreEleve,:mdp);');
        $mark = ['mail','nom','prenom','etablissement','niveau','nombreEleve'];
        foreach($mark as $m){
        $req->bindValue(':'.$m,$tab[$m]);
        }
        $req->bindValue(':mdp', $pswdH);  
        $req->execute();
        return(bool) $req->rowCount();
    }
    
    /**
     * Méthode qui met a jour les informations d'un utilisateur
     * @param array $tab tableau contenant les données à mettre a jour de l'utilisateur
     * @return bool True si tout va bien, False si il y a un soucis
     */
    public function updateUserInfo($tab,$id){
        $req = $this->bd->prepare('update user set mail=:mail,nom=:nom,prenom=:prenom,mdp=:mdp,type_user=:type_user;');
        $mark = ['mail','nom','prenom','mdp','type_user'];
        foreach($mark as $m){
        $req->bindValue(':'.$m,$tab[$m]);
        }   
        $req->execute();
        return(bool) $req->rowCount();
    }

    /**
     * Méthode qui retourne toutes les informations d'un créneau à l'aide de son l'identifiant
     * @param int $id l'identifiant du créneau
     * @return array tableau des infos du créneau
     */
    public function getCreneauInfos($id){
        $req = $this->bd->prepare('select * from creneau where id_creneau=:id;');
        $req->bindValue(':id',$id);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_ASSOC); /* assoc pas ASSOC */
        return $tab[0];
    }

    /**
     * Méthode qui retourne toutes les informations d'une réservation à l'aide de son l'identifiant
     * @param int $id l'identifiant de la réservation
     * @return array tableau des infos de la réservation
     */
    public function getReservationInfos($id){
        $req = $this->bd->prepare('select * from reservation where id_reservation=:id;');
        $req->bindValue(':id',$id);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_ASSOC); /* assoc pas ASSOC */
        return $tab[0];
    }

/**
     * Méthode qui retourne toutes les informations d'un utilisateur à l'aide de son l'identifiant
     * @param int $id l'identifiant de l'utilisateur
     * @return array tableau des infos de l'utilisateur 
     */
    public function getUserInfos($id){
        $req = $this->bd->prepare('select * from user where id_user=:id;');
        $req->bindValue(':id',$id);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_ASSOC); /* assoc pas ASSOC */
        return $tab[0];
    }
/**
     * Méthode qui retourne toutes les informations d'un stand à l'aide de son l'identifiant
     * @param int $id l'identifiant du stand
     * @return array tableau des infos du stand
     */
    public function getStandInfos($id){
        $req = $this->bd->prepare('select * from stand where id_stand=:id;');
        $req->bindValue(':id',$id);
        $req->execute();
        $tab = $req->fetchAll(PDO::FETCH_ASSOC); /* assoc pas ASSOC */
        return $tab[0];
    }

/**
     * Méthode qui retourne toutes les informations d'un DERNIER stand à l'aide de son l'identifiant
     * @param int $id l'identifiant du dernier stand
     * @return array tableau des infos du dernier  stand
     */
    public function getLastStand(){
        $req = $this->bd->prepare('select * from stand order by date desc limit 20;');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC); 
    }

/**
     * Méthode qui test si un mail est présent dans la base de données
     * @param string $mail le mail à vérifier 
     * @return bool Si le mail existe ou pas
     */
    public function inDataBase($mail){
        $req = $this->bd->prepare('select mail from professeur where mail=:mail;');
        $req->bindValue(':mail',$mail);
        $req->execute();
        return(bool) $req->rowCount();
    }

    /**
     * Méthode qui met à jour le mot de passe d'un utilisateur 
     * @param string $pswd le mot de passe à modifier
     * @param string $mail le mail de l'utilisateur
     * @return bool tableau des infos du dernier  stand
     */
    public function updatePassword($pswd,$mail){
        /* faut hacher le mdp $pswd=password_hash($pswd, PASSWORD_DEFAULT); */
        $options = ['cost' => 13];
        $pswdH=password_hash($pswd, PASSWORD_BCRYPT, $options);
        $req = $this->bd->prepare('update utilisateur set mdp=:pswd where mail=:mail;');
        $req->bindValue(':pswd',$pswdH);
        $req->bindValue(':mail',$mail);
        $req->execute();
        return(bool) $req->rowCount();
    }
    public function getMdp($id){
        $req = $this->bd->prepare('select mdp from professeur where mail=:id;');
        $req->bindValue(':id', $id);
        $req->execute();
        $res=$req->fetchAll(PDO::FETCH_ASSOC);
        return $res; 
    }
    public function addEtablissement($tab){
        $req = $this->bd->prepare('insert into etablissement values (:etablissement,:ville,:cp);');
        $mark = ['etablissement','ville','cp'];
        foreach($mark as $m){
        $req->bindValue(':'.$m,$tab[$m]);
        }   
        $req->execute();
        return(bool) $req->rowCount();
    }

    public function existEtablissement($nom){
        $req = $this->bd->prepare('select nom_etablissement from etablissement where nom_etablissement=:nom;');
        $req->bindValue(':nom', $nom);
        $req->execute();
        return(bool) $req->rowCount();
    } 

    public function getEtablissement(){
        $req = $this->bd->prepare('select * from etablissement;');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC); 
    }
    public function getEtablissementCPC($nom){
        $req = $this->bd->prepare('select * from etablissement where nom_etablissement=:nom;');
        $req->bindValue(':nom', $nom);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoEleve($mail){
        $req = $this->bd->prepare('select nombreEleve,nom_niveau from professeur join niveauvisiteur on professeur.niveau=niveauvisiteur.id_niveau where mail=:mail;');
        $req->bindValue(':mail', $mail);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoPlanning(){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau ,heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);   
    }
    public function getCreneau(){
        $req = $this->bd->prepare("select * from creneau;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoStand2($nomS){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau ,heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand where nom_stand=:v;");
        $req->bindValue(':v',$nomS);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);   
    }

    public function getInfoSortedDate($db,$df){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau, heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand where date_debut=:date_debut and date_fin=:date_fin;");
        $req->bindValue(':date_debut', $db);
        $req->bindValue(':date_fin', $df);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoSortedNiveau($niveau){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau, heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand where niveau=:niveau;");
        $req->bindValue(':niveau', $niveau);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoSortedNom($nom){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau, heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand where nom_stand=:nom;");
        $req->bindValue(':nom', $nom);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getInfoSortedTemps($temps){
        $req = $this->bd->prepare("select nom_stand,capacite,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau, heure_debut,heure_fin from stand  inner join creneau on stand.id_stand=creneau.id_stand where temps=:temps;");
        $req->bindValue(':temps', $temps);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getInfoStand(){
        $req = $this->bd->prepare("select nom_stand,capacite,description from stand;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function InsertStandInfos($nom,$cap,$niveau,$description){
    	$req = $this->bd->prepare('INSERT INTO Stand(nom_stand,capacite,niveau_visiteur,description) VALUES (:n,:c,:nv,:d)');
    	$req->bindValue(':n',$nom);
    	$req->bindValue(':c',$cap);
    	$req->bindValue(':nv',$niveau);
    	$req->bindValue(':d',$description);
    	$req->execute();
    	return(bool) $req->rowCount();


	}
	public function AllStands(){
  	$req = $this->bd->prepare('select distinct nom_stand,capacite,description from Stand ORDER by nom_stand ASC;');
  	$req->execute();
  	return $req->fetchAll(PDO::FETCH_ASSOC);

	}

	public function getIdStand($nom){
  	$req = $this->bd->prepare('select id_stand from Stand where nom_stand=:n;');
  	$req->bindValue(':n',$nom);
  	$req->execute();
  	return $req->fetchAll(PDO::FETCH_ASSOC);

	}

	public function AjoutCreneau($date,$debut,$fin,$id){
  	$req = $this->bd->prepare('INSERT INTO creneau (date_creneau,heure_debut,heure_fin,id_stand) VALUES (:d,:heureD,:heureF,:idStand);');
  	$req->bindValue(':d',$date);
  	$req->bindValue(':heureD',$debut);
  	$req->bindValue(':heureF',$fin);
  	$req->bindValue(':idStand',$id[0]['id_stand']);
  	$req->execute();
  	return(bool) $req->rowCount();
	}
	
	public function getIdProfesseur($nom,$prenom){
  	$req = $this->bd->prepare('select id_professeur from Professeur where nom=:n and prenom=:p;');
  	$req->bindValue(':n',$nom);
    $req->bindValue(':n',$prenom);
  	$req->execute();
  	return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	public function Reservation($id_creneau,$id_professeur,$nbPlace_prise){
      $req = $this->bd->prepare('INSERT INTO Reservation (id_creneau,id_professeur,nbPlace_prise) VALUES (:c,:p,:nb);');
      $req->bindValue(':c',$id_creneau);
      $req->bindValue(':p',$id_professeur);
      $req->bindValue(':nb',$nbPlace_prise);
      $req->execute();
      return(bool) $req->rowCount();
    }

    public function getTempo(){
        $req = $this->bd->prepare('select * from tempo');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNombreAnimateurVendredi($idStand){
        $req = $this->bd->prepare('select jeudi from tempo)');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProfesseurInfosId($id){
        $req = $this->bd->prepare("select nom,prenom,etablissement,niveau,nombreeleve,mdp from professeur where id_professeur =:id;");
        $req->bindValue(':id',$id);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC); /* assoc pas num */
         }
        /**
         * Méthode qui retourne l'identifiant d'un professeur à l'aide de son mail
         * @param $mail mail du professeur
         */
         public function getProfesseurInfosMail($mail){
            $req = $this->bd->prepare("select id_professeur from professeur where mail =:mail;");
            $req->bindValue(':mail',$mail);
            $req->execute();
            $prof = $req->fetchAll(PDO::FETCH_ASSOC); /* assoc pas num */
            return $prof;
        }

    public function addStand($tab)
    {
        $req = $this->bd->prepare("insert into stand (nom_stand,description,niveau_visiteur,capacite,allday,duree,intersession,pausedebut,pausefin) values (:nom_stand,:description,:niveau_visiteur,:capacite,:allday,:duree,:intersession,:pausedebut,:pausefin);");
        $mark = ['nom_stand', 'description', 'niveau_visiteur', 'capacite', 'allday','duree','intersession','pausedebut','pausefin'];
        foreach ($mark as $m) {
            $req->bindValue(':' . $m, $tab[$m]);
        }
        $req->execute();
        return(bool) $req->rowCount();
    }
    public function addCreneau($tab){
        $req = $this->bd->prepare("insert into creneau (nbplace_restant,date_creneau,heure_debut,heure_fin,id_stand,id_superviseur,disponibilite) values (:nbplace_restant,:date_creneau,:heure_debut,:heure_fin,:id_stand,:id_superviseur,:disponibilite);");
        $mark = ['nbplace_restant', 'date_creneau', 'heure_debut', 'heure_fin', 'id_stand','id_superviseur','disponibilite'];
        foreach ($mark as $m) {
            $req->bindValue(':' . $m, $tab[$m]);
        }
        $req->execute();
        return(bool) $req->rowCount();
    }
    public function getInfoCreneauInf5(){
        $req = $this->bd->prepare("select *, TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau from creneau inner join stand on creneau.id_stand=stand.id_stand where creneau.id_stand < 5;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCreneaufromId($get){
        $req = $this->bd->prepare("select id_creneau,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau ,heure_debut,heure_fin from creneau where id_stand =:id;");
        $req->bindValue(':id',$get[0]['id_stand']);
        $req->execute();
        $creneau = $req->fetchAll(PDO::FETCH_ASSOC);
        return $creneau;
      }

      public function getStandNiveauFiltre($niveau){
        $req = $this->bd->prepare("select * from stand join niveauvisiteur on stand.niveau_visiteur=niveauvisiteur.id_niveau where nom_niveau =:niveau;");
        $req->bindValue(':niveau',$niveau);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
      }
      public function findRequestedFiltre(){
          $req = $this->bd->prepare("select *,TO_CHAR(date_creneau,'YYYY-MM-DD' ) as date_creneau  from creneau join stand on creneau.id_stand=stand.id_stand join niveauvisiteur on stand.niveau_visiteur=niveauvisiteur.id_niveau where creneau.id_stand < 10; ;");
          $req->execute();
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            return $res;
    }
    public function findRequestedFiltre2(){
        $req = $this->bd->prepare("select distinct nom_stand from creneau inner join stand on creneau.id_stand=stand.id_stand join niveauvisiteur on stand.niveau_visiteur=niveauvisiteur.id_niveau;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
         
    }

    public function getPlacefromidcreneau($get){
        $req = $this->bd->prepare("select nbPlace_restant from creneau where id_creneau =:id;");
        $req->bindValue(':id',$get);
        $req->execute();
        $creneau = $req->fetch(PDO::FETCH_ASSOC);
        return $creneau;
      }
      public function getproffromcreaneau($get){
          $req = $this->bd->prepare("select id_professeur from reservation where id_creneau =:id;");
          $req->bindValue(':id',$get);
          $req->execute();
          $creneau = $req->fetch(PDO::FETCH_ASSOC);
          return $creneau;
        }
        public function getEtablissementfromProf($get){
            $req = $this->bd->prepare("select etablissement from professeur where id_professeur =:id;");
            $req->bindValue(':id',$get['id_professeur']);
            $req->execute();
            $creneau = $req->fetch(PDO::FETCH_ASSOC);
            return $creneau;
          }

          public function IsAStand($n){
            $req = $this->bd->prepare("select * from stand where nom_stand=:nom;");
            $req->bindValue(':nom', $n);
            $req->execute();
            return $req->rowCount();
        }

}
