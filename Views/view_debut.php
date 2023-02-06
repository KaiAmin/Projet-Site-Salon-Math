<?php if(session_status()==1 && isset($exitInfo) && $exitInfo !== 1){session_start();}?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="Content/css/style.css">
  <!-- CSS only -->
  <script src='Utils/fullcalendar-6.0.2/dist/index.global.js'></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<?php 
  require_once('Models/Model.php');
  $m = Model::getModel();?>
  <header class="">
    <nav>
      <a href="?controller=home&action=home"><img src="Content/img/animath.png" class="logo"></a>
      <ul>
        <li> <a href="?controller=home&action=home">Accueil</a> </li>
        <li> <a href="?controller=reservation">Exposant</a> </li>
        <li> <a href="?controller=planning&action=planning" id='showPlanning' style='display:none;'>Planning</a> </li>
        <li> <a href="?controller=faq&action=creneau">Faq</a> </li>
        <li> <a href="?controller=contact">Contact</a> </li>
      </ul>
      <div class="dropdown">
        <button type="button" name="button" id='dropdown'><img src="Content/img/user.png" alt="" class="menu"></button>
          <div class="content" id='compte'>
            <?php if(isset($_SESSION['connecter'])):?>
              <a href="?controller=monCompte">Mon compte</a>
              <a href="?controller=home&action=disconnect" id="exit">Déconnexion</a>
              <script> document.getElementById('showPlanning').style.display='block';</script>
              <?php else: ?>
              <a href="?controller=login">Se connecter</a>
              <a href="?controller=signin">S'inscrire</a>
              <?php endif;?>
          </div>
      </div>
    </nav>
    <div class="img">
    </div>
    <script>
      document.getElementById('exit').addEventListener('click',function(){'<?php session_write_close();?>'});
      let dropdown = document.getElementById('dropdown');
      let compte = document.getElementById('compte');
      compte.style.display='none';
      dropdown.addEventListener('click',afficheCompte);
      function afficheCompte(){
        if(compte.style.display=='block'){
          compte.style.display='none';
        }
        else{
          compte.style.display='block';
        }
      }
    </script>
  </header>
  <body>



