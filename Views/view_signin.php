<?php require "view_debut.php" ?>
<div class="login-form">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<?php
require_once("./Models/Model.php");
$m = Model::getModel();
$tabEtablissement = $m->getEtablissement();
?>		
<link rel="stylesheet" href="./Content/css/style_contact.css">

<div class="wrapper mt-3">
	<div class="inner">
<form action="?controller=signin" class="text" id='form' method="post" onsubmit="onSubmit();">
    
    
    <div class="alert alert-success" id='alerteSuccess' style="display: none;">
        <strong>Succès</strong> inscription réussie !
    </div>
    <div class="alert alert-danger" id='alerteMdp' style="display: none;">
        <strong>Erreur</strong> mot de passe différent
    </div>
    <div class="alert alert-danger" id='alertMail' style="display: none;">
        <strong>Erreur</strong> email non valide
    </div> 
    
    <div class="alert alert-danger" id='alerteMailLong' style="display: none;">
        <strong>Erreur</strong> email trop long
    </div>
    
    <div class="alert alert-danger" id='alertePseudo' style="display: none;">
        <strong>Erreur</strong> pseudo trop long
    </div>

    <div class="alert alert-danger" id='alerteCompte' style="display: none;">
        <strong>Erreur</strong> compte deja existant
        </div>
                <h2 class="text-center">Inscription</h2>       
                <div class="form-group mb-4">
                    <input type="email" name="mail" id='mailInput' class="form-control" placeholder="Email" required="required" autocomplete="off">
                </div>
                <div class="form-group mb-4">
                    <input type="text" name="nom" id='nom' class="form-control" placeholder="Nom" required="required" autocomplete="off">
                </div>
                <div class="form-group mb-4">
                    <input type="text" name="prenom" id='prenom' class="form-control" placeholder="Prenom" required="required" autocomplete="off">
                </div>
                <div class="form-group mb-4">
                    <input type="number" name="nbEleve" id='nbEleve' class="form-control" placeholder="Nombre d'élèves" required="required" autocomplete="off">
                </div>
                <div class="form-group mb-4">
                    <label for="niveau" class='mb-3'>
                    Choisir le niveau de vos élèves:</label>
                    <select class='form-select' style="width:auto;" name="niveau" id="niveau" class="p-1">
                        <option value="">-- Choisir ci-dessous --</option>
                        <option value="L">Lycée</option>
                        <option value="C">Collège</option>
                        <option value="P">Primaire</option>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="niveau" class='mb-3'>
                    Choisir votre établissement:</label>
                    <select onchange="selectOther();" class='form-select' style="width:auto;" name="etablissement" id="etablissement" class="p-1">
                        <option value="">-- Choisir ci-dessous --</option>
                        <?php foreach($tabEtablissement as $tab):?>
                        <option value="<?= $tab["nom_etablissement"]?>"><?= $tab["nom_etablissement"]?> - <?=$tab["ville"]?></option>
                        <?php endforeach;?>
                        <option value="other">Autre</option>
                    </select>
                    <div id="adresseDiv" style='display:none'>
                        <div class="form-group col">
                            <input type="text" class="form-control ms-4" id="adresse" name="adresse" placeholder="Adresse" autocomplete="off" data-toggle="tooltip" data-placement="top" />
                            <div class="address-feedback position-absolute list-group" style="z-index:1100;"></div>
                        </div>
                        <div class="row align-items-start">
                            <div class="form-group mb-4 mt-4 col">
                                <input type="text" name="ville" id='ville' class="form-control" placeholder="Ville"  autocomplete="off">
                            </div>
                            <div class="form-group mb-4 mt-4 col">
                                <input type="text" name="cp" id='cp' class="form-control" placeholder="Code postale" autocomplete="off">
                            </div>
                    </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <input type="password" name="mdp" id='pswd' class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                    <img src="Content/img/eye.png" onclick="showNewPassword()" class="ms-2" id="showPassword" width="40" height="40"> Montrer le mot de passe
                </div>
                <div class="form-group mb-4">
                    <input type="password" name="mdp_retype" id='confirmpswd' class="form-control" placeholder="Re-tapez le mot de passe" required="required" autocomplete="off">
                    <img src="Content/img/eye.png" onclick="showConfirmPassword()" class="ms-2" id="showPassword" width="40" height="40"> Montrer le mot de passe
                </div>
                <form>
                <div class="form-group mb-4">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                        Voir les CGU
                    </button>
                </div>
                <div class="form-group mb-4">
                    <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter">
                    <label for="subscribeNews">J'accepte les conditions d'utilisations</label>
                </div>

                <!-- CGU -->

                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="-1">Conditions générales d'utilisation</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <?php require('textCGU.html');?>
                            <div class="modal-footer">  
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Understood</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                </div>
                
            </form>
                        </div>
                        </div>
        </div>
<script src="./Content/js/signIn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<?php require "view_fin.php" ?>