<?php require "view_debut.php" ?>

<?php
require_once("./Models/Model.php");
$m = Model::getModel();
$id = $m->getProfesseurInfosMail($_SESSION["mail"]);
$Prof = $m->getProfesseurInfosId($id[0]["id_professeur"]);
?>

<br>
<h1>Mon compte</h1>
<br>
<table class="table table-dark col">
  <tr>
    <th>Nom </th>
    <th>prenom</th>
    <th>etablissement</th>
    <th>niveau</th>
    <th>nombreeleve</th>
</tr>
    <tr>
    <td><?=$Prof["nom"] ?></td>
    <td><?=$Prof["prenom"] ?></td>
    <td><?=$Prof["etablissement"] ?></td>
    <td><?=$Prof["niveau"] ?></td>
    <td><?=$Prof["nombreeleve"] ?></td>
</td> 
</tr>
</table>
  



<?php require "view_fin.php" ?>