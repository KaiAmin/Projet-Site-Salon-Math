<?php require "view_debut.php";?>

<div class='text'>
<h1 class='mb-7 text'> Mot de passe oublié </h1>
<p class='mb-5'> Indiquez l'adresse mail associé à votre compte pour générer un nouveau mot de passe.</p>
</div>
<div class="alert alert-danger text-center ms-5 me-5 font" role="alert" id="unfoundMail" style="display: none;">
  L'adresse mail fournis n'existe pas sur ce site, changez de mail ou inscrivez vous <a href="?controller=home" >ici</a>.
</div>
<div class="alert alert-danger text-center ms-5 me-5 font" role="alert" id="alertMail" style="display: none;">
  L'adresse mail fournis n'est pas correct, référez vous à l'exemple.
</div>

<form method="post" action="?controller=password&action=waitScreen" class='text' name="form-mail" id="form-mail" onsubmit="if(!formTry()){event.preventDefault();}">
    <p id='mail'> Adresse mail :
    </br>
    <div class="input-group mb-3 ms-5 w-75">
        <input type="email" class="form-control" id="mailInput" name='mail' placeholder="Votre adresse mail" required="required" autocomplete="off">
        <span class="input-group-text" id="basic-addon2">exemple@exemple.com</span>
    </div></p>
    <div class="form-group ms-5 mt-5">
      <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
    </div> 
</form>

<script>
  <?php if(isset($error)):?>
  var error = "<?php Print($error);?>";
  if(error == "unfound_mail"){
    document.getElementById("unfoundMail").style.display='block';
    event.preventDefault();
  }
  <?php endif ;?>
  
  var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/;
  let form = document.getElementById('form-mail');

function onSubmit(){
  if(!formTry()){
    event.preventDefault();
  }
}

function formTry(){
    var x = document.forms["form-mail"]["mail"].value;
    form.addEventListener('keydown',formTry);
    if (pattern.test(x)){
        document.getElementById('alertMail').style.display='none';
        document.getElementById('mailInput').style.color='black';
        return true;
    }
    else{
        document.getElementById('alertMail').style.display='block';
        document.getElementById('mailInput').style.color='red';
        return false;
    }
}


</script>

<?php require "view_fin.php"; ?>