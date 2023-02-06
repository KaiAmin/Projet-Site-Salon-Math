<?php require "view_debut.php" ?>
<link rel="stylesheet" href="/Content/css/style_contact.css">

<div class="wrapper">
	<div class="inner">
		<form action="?controller=login&action=tryMdp" class="text" method="post" >
						
			<div class="alert alert-danger mb-5 font" role="alert" id="alertMdp" style="display: none;">
				Mot de passe incorrect, veuillez rectifiez.
			</div>

			<div class="alert alert-danger text-center me-5 mb-5 font" role="alert" id="alertId" style="display: none;">
				Identifiant incorrect, veuillez rectifiez.
			</div>

			<div class="text-center input-group mb-3">
				<p> Identifiants <input class="form-control" type="text" name="id" placeholder="Identifiants" required="required" autocomplete="off"> </p>
			</div>

			<div class="input-group mb-3">
				<p> Mot de passe 
				<input class="form-control" type="password" name="mdp" id="pswd" placeholder="Mot de passe" required="required" autocomplete="off">
				</p> <img src="/Content/img/eye.png" class="ms-2" id="showPassword"  width="40" height="40">
			</div>

			<div class="text-center form-group mb-4">
                    <a href="?controller=password">Mot de passe oublié</a>
            </div>

	<div class="text-center form-group mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                </div>   
</form>
     </div>
</div>
<script>
<?php if(isset($mdpFalse)):?>
	var mdpTry = "<?php Print($mdpFalse);?>";
	var idTry = "<?php Print($idFalse);?>";
	if(mdpTry === "1"){
		document.getElementById('alertMdp').style.display='block';
	}
	if(idTry === "1"){
		document.getElementById('alertId').style.display='block';
	}
<?php else: ?>
	document.getElementById('alertMdp').style.display='none';
	document.getElementById('alertId').style.display='none';

	<?php endif;?>

	document.getElementById('showPassword').addEventListener('click',showPassword);
	function showPassword(){
    let password = document.getElementById('pswd');
    if (password.type === "password"){
        password.type="text";
    }
    else{
        password.type="password";
    }
}
</script>
<?php require "view_fin.php" ?>