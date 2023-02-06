<?php require "view_debut.php"; ?>

<div class='text'>
</br>
<h1 class='m-5'> Mot de passe oublié </h1>
<p class='mb-5'> Indiquez votre nouveau mot de passe et reconfirmez le ci-dessous.
</div>
</p>
<div class='text-form'>
<div class="alert alert-danger text-center me-5 font" role="alert" id="alertMdp" style="display: none;">
  Les deux mots de passe ne sont pas égaux, veuillez rectifiez.
</div>
<form method="post" action="?controller=password&action=newPassword" name="form-newMdp" id="form-newMdp" onsubmit="validerForm();">
    <p class='ms-5'> Nouveau mot de passe : 
        <div class="input-group w-75">
        <span class="input-group-text"  id="basic-addon1">Nouveau mot de passe : </span>
        <input type="password" class="form-control" id='newpswd' name='newpswd' placeholder="Mot de passe" required="required" autocomplete="off">
        </div>
        <input type="checkbox" onclick="showNewPassword()">Montrer le mot de passe
    </p> 
</br>
    <p class='ms-5'> Reconfirmez votre mot de passe : 
        <div class="input-group w-75">
        <span class="input-group-text"  id="basic-addon1">Reconfirmez le mot de passe : </span>
        <input type="password" class="form-control" id='confirmpswd' name='confirmpswd' placeholder="Mot de passe" required="required" autocomplete="off">
        </div>
        <input type="checkbox" onclick="showtoConfirmPassword()">Montrer le mot de passe
    </p>
    <input class="mt-3" type="submit" value="Envoyer"> 
</form>
</div>

<script src="./Content/js/setPassword.js"></script>

<?php require "view_fin.php"; ?>