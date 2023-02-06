<?php require "view_debut.php" ?>

<html>
<body>
  <h1 style = "text-align: center;">Voici les différents Stands !</h1>
<?php
$i = 0;
  foreach ($data as $key => $value) {
    if ($i != 4) {
      echo "<div class='w3-quarter'>
          <h3><a href='?controller=reservation&action=afficheurCr&nom_stand=". urlencode($value['nom_stand']) . "'>" . $value['nom_stand'] . " </a></h3>
        </div>";
      $i= $i +1;
    }
    elseif($i = 4){
      $i =0 ;
      echo "</div>";
      echo "<div class='w3-row-padding w3-padding-16 w3-center' id='food'>";
    }
  }
?>
</body>
</html>



<?php require "view_fin.php" ?>
