var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/;
let form = document.getElementById('form');

function onSubmit(){
    if(!document.getElementById('adresse').value.length==0){
        $_POST['etablissement']=document.getElementById('adresse').value;
    }

    if(!formTryMail()){
        event.preventDefault();
    }
    if(!formTryMdp()){
        event.preventDefault();
    }
    if(!formTryName()){
        event.preventDefault();
    }
    if(formTryMdp()){
        event.preventDefault();
    }
}



function selectOther(){
    $val = document.forms["form"]["etablissement"].value;
    if($val == 'other'){
        document.getElementById('adresseDiv').style.display='block';
    }
    else{
        document.getElementById('adresseDiv').style.display='none';
        document.getElementById('ville').value='';
        document.getElementById('cp').value='';
    }
}

function formTryMail(){
    var x = document.forms["form"]["mail"].value;
    form.addEventListener('keydown',formTryMail());
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

function formTryMdp(){
    var mdp = document.forms["form"]["mdp"];
    var mdpConfirm = document.forms["form"]["mdp_retype"];
    if(mdp === mdpConfirm){
        return true;
    }
    document.getElementById('alertMdp').style.display='block';
    return false;
}

function formTryPseudo(){
    var x = document.forms["form"]["prenom"].value;
    if(x.length > 100 ){
        document.getElementById('alertPseudo').style.display='block';
        return false;
    }
    return true;
}

function formTryName(){
    var x = document.forms["form"]["nom"].value;
    if(x.length > 100 ){
        document.getElementById('alertPseudo').style.display='block';
        return false;
    }
    return true;
}

function showNewPassword(){
    let password= document.getElementById('pswd');
    if (password.type === "password"){
        password.type="text";
    }
    else{
        password.type="password";
    }
}

function showConfirmPassword(){
    let password= document.getElementById('confirmpswd');
    if (password.type === "password"){
        password.type="text";
    }
    else{
        password.type="password";
    }
}

function formTryPassword()
{
    let confirmMdp = document.forms["form"]["confirmpswd"].value;
    let newMdp = document.forms["form"]["pswd"].value;
  
    if(newMdp === confirmMdp)
  { 
    return true;
  }
    event.preventDefault(); 
    document.getElementById('alertMdp').style.display='block';
    document.getElementById('confirmpswd').style.color='red';
    return false;
}




/* Recherche d'adresse */

  var currentFocus = -1;
  var fetchTrigger = 0;

  // Fonction pour mettre en forme visuellement un résultat sélectionné
  function setActive() {
    var nbVal = $("div.address-feedback a").length;
    if (!nbVal)
      return false; // Si on n'a aucun résultat listé, on s'arrête là.
    // On commence par nettoyer une éventuelle sélection précédente
    $('div.address-feedback a').removeClass("active");

    // Bidouille mathématique pour contraindre le focus dans la plage du nombre de résultats
    currentFocus = ((currentFocus + nbVal - 1) % nbVal) + 1;

    $('div.address-feedback a:nth-child(' + currentFocus + ')').addClass("active");
  }

  // Au clic sur une adresse suggérée, on ventile l'adresse dans les champs appropriés. On espionne mousedown plutôt que click pour l'attraper avant la perte de focus du champ adresse.
  $('div.address-feedback').on("mousedown", "a", function(event) {
    // Stop la propagation par défaut
    event.preventDefault();
    event.stopPropagation();

    $("#adresse").val($(this).attr("data-name"));
    $("#cp").val($(this).attr("data-postcode"));
    $("#ville").val($(this).attr("data-city"));
    if($(".waiting")[0]){

      var option = '<option class="waiting" value="'+$(this).attr("data-name")+' - '+$(this).attr("data-city")+'">'+$(this).attr("data-postcode")+' - '+$(this).attr("data-city")+'</option>';
      $('.waiting').replaceWith(option);
    }
    else{
      var option = '<option class="waiting" value="'+$(this).attr("data-name")+' - '+$(this).attr("data-city")+'">'+$(this).attr("data-postcode")+' - '+$(this).attr("data-city")+'</option>';
      $('#etablissement').append(option);
    }
    
    $('.address-feedback').empty();
  });

  // On espionne le clavier dans le champ adresse pour déclencher les actions qui vont bien
  $("#adresse").keyup(function(event) {
    // Stop la propagation par défaut
    event.preventDefault();
    event.stopPropagation();

    if (event.keyCode === 38) { // Flèche HAUT
      currentFocus--;
      setActive();
      return false;
    } else if (event.keyCode === 40) { // Flèche BAS
      currentFocus++;
      setActive();
      return false;
    } else if (event.keyCode === 13) { // Touche ENTREE
      if (currentFocus > 0) {
        // On simule un clic sur l'élément actif
        $("div.address-feedback a:nth-child(" + currentFocus + ")").mousedown();
      }
      return false;
    }

    // Si on arrive ici c'est que l'user a avancé dans la saisie : on réinitialise le curseur de sélection.
    $('div.address-feedback a').removeClass("active");
    currentFocus = 0;

    // On annule une éventuelle précédente requête en attente
    clearTimeout(fetchTrigger);

    // Si le champ adresse est vide, on nettoie la liste des suggestions et on ne lance pas de requête.
    let rue = $("#adresse").val();
    if (rue.length === 0) {
      $('.address-feedback').empty();
      return false;
    }

    // On lance une minuterie pour une requête vers l'API.
    fetchTrigger = setTimeout(function() {
      // On lance la requête sur l'API
      $.get('https://data.education.gouv.fr/api/records/1.0/search/?dataset=fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre', {
        q: rue,
        limit: 15,
        autocomplete: 1
      }, function(data, status, xhr) {
        let liste = "";
        $.each(data.records, function(i, obj) {
          // données phase 1 (obj.fields.label) & phase 2 : name, postcode, city
          // J'ajoute chaque élément dans une liste
          let madeaddress = obj.fields.appellation_officielle + " "  + obj.fields.adresse_uai + " "+  obj.fields.code_postal_uai +" <strong>" + obj.fields.libelle_commune + "</strong>";
          liste += '<a class="list-group-item list-group-item-action py-1" href="#" name="' + obj.fields.libelle_academie + '" data-name="' + obj.fields.appellation_officielle + '" data-postcode="' + obj.fields.code_postal_uai + '" data-adresse="' + obj.fields.adresse_uai +'" data-city="' + obj.fields.libelle_commune + '">' + madeaddress + '</a>';
        });
        $('.address-feedback').html(liste);
      }, 'json');
    }, 500);
  }); 

  // On cache la liste si le champ adresse perd le focus
  $("#adresse").focusout(function() {
    $('.address-feedback').empty();
  });

  // On annule le comportement par défaut des touches entrée et flèches si une liste de suggestion d'adresses est affichée
  $("#adresse").keydown(function(e) {
    if ($("div.address-feedback a").length > 0 && (e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13)) {
      e.preventDefault();
    }
  });