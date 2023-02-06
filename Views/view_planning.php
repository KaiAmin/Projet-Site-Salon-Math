<?php require("view_debut.php");
require_once('Models/Model.php');
$m = Model::getModel();
$infoEleve = $m->getInfoEleve($_SESSION['mail']);
$infoPlanning = $m->getInfoCreneauInf5();
$infoStand = $m->getInfoStand();
?>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<div class="text-center" style="width: 75%; margin-left: 10%;">
  <h1>Planning professeur</h1>
  <p>Vous avez actuellement <strong><?php print($infoEleve[0]["nombreeleve"]);?></strong> élèves qui n'ont pas encore de réservation. Votre classe à un niveau <strong><?php print($infoEleve[0]["nom_niveau"]);?></strong> donc voici des activités pour ce niveau : </p>
<form action="?controller=planning&action=test" method="post">
  <div class='ms-3 mb-3'>
  <div style="text-align: left;">
  <h3 class="m-2">Mettez vos filtres ici:</h3>
  <p>Changez le jour et l'heure ci-dessous : </p>
  <select onchange="filtreAppear();" class='form-select mb-3' style="width:auto;" name="date" id="date" class="p-1">
    <option value="">-- Choisir ci-dessous --</option>
    <option value="2023-01-19T09:00:00,2023-01-19T13:00:00">Jeudi | 9h - 13h </option>
    <option value="2023-01-19T13:00:00,2023-01-19T18:00:00">Jeudi | 13h - 18h </option>
    <option value="2023-01-20T09:00:00,2023-01-20T13:00:00">Vendredi | 9h - 13h </option>
    <option value="2023-01-20T13:00:00,2023-01-20T18:00:00">Vendredi | 13h - 18h </option>
  </select>
</div>
</div> 

<div class="row align-items-start mb-5 ms-3">
    <div class='ms-3 me-3 col-2' id='showFiltre' style="display: none;">
    <select onchange="onChange();" class='form-select' style="width:auto;" name="filtre" id="filtre" class="p-1">
      <option value="">-- Choisir ci-dessous --</option>
      <option value="duree">Temps de l'activité</option>
      <option value="niveau">Niveau</option>
      <option value="nom">Nom du stand</option>
      <option value="horaire">Créneau horaire</option>
    </select>
    </div>
    <section class='col-6' id='sectionTemps' style="display: none;">
      <div class="row align-items-start">
        <p class="col-3 ms-5">Durée de l'activité:</p>
          <input type="time" style="width: 45%;" name="filtreDuree" id="filtreTemps" class="form-control">
          <a role="button" onclick="OnClickFiltered('Durée de l\'activité : ','tempsFiltre');" id="filtered" class="col-2 ms-2 btn btn-primary btn-block"> Filtrer </a>
        </div>
    </section>
    <section class='col-6' id='sectionNiveau' style="display: none;">
      <div class="row align-items-start">
        <p class="col-3 ms-5">Niveau des activités: </p>
        <select class='' style="width:auto;" name="niveau" id="filtreNiveau" >
                        <option value="">-- Choisir ci-dessous --</option>
                        <option value="lycee">Lycée</option>
                        <option value="college">Collège</option>
                        <option value="primaire">Primaire</option>
                    </select>
          <a role="button" onclick="OnClickFiltered('Niveau des activités : ','niveauFiltre');" id="filtered" class=" w-25 mt-2 ms-2 btn btn-primary btn-block"> Filtrer </a>
      </div>
    </section>
    <section class='col-6' id='sectionHoraire' style="display: none;">
      <div class="row align-items-start">
        <p class="col-3 ms-5">Heure début:</p>
          <input type="time" style="width: 45%;" name="filtreHD" id="filtreHD" class="form-control">
        <p class="col-3 ms-5">Heure fin:</p>
          <input type="time" style="width: 45%;" name="filtreHF" id="filtreHF" class="form-control">
          <a role="button" onclick="OnClickFiltered('Horaire : ','horaireFiltre');" id="filtered" class="col-2 ms-2 btn btn-primary btn-block"> Filtrer </a>
      </div>
    </section>
    <section class='col-6' id='sectionNom' style="display: none;">
      <div class="row align-items-start">
          <p class="col-3 ms-5">Nom du stand:</p>
           <input type="text" style="width: 45%;" name="filtreNom" id="filtreNom" class="form-control">
          <a role="button" onclick="OnClickFiltered('Nom du stand : ','nomStandFiltre');" id="filtered" class="col-2 ms-2 btn btn-primary btn-block"> Filtrer </a>
    </section>
    <section class='col-3 row align-items-start' id='vosFiltres' style="display: none;">
      <h5>Vos filtres:</h5>
    </section>
<div style="text-align: left;" class="mb-2 mt-3">
<button type="submit" onclick="searchFiltre();" class="btn btn-primary btn-block">Ordonner vos recherches</button>

</div>
</form>
</div>
 
</table>
<script>
  function filtreAppear(){
    document.getElementById('showFiltre').style.display='block';
  }
  function reserver(event){
    var infoPlanningSelected = event.target.parentNode.parentNode;
  }
  $(function() {
      $("select").selectBoxIt();
    });
  function OnClickFiltered(name,id){
    if(id == 'horaireFiltre'){
      let a = event.target.parentNode.childNodes[3].value;
      let b = event.target.parentNode.childNodes[7].value;
      let aInt =  parseInt(a.substring(0,2));
      if(a>b){
        document.getElementById('filtreHD').style.color='red';
        document.getElementById('filtreHF').style.color='red';
        return;
      }
      else{
        document.getElementById('filtreHD').style.color='black';
        document.getElementById('filtreHF').style.color='black';
      }
      var infoFiltre = a+'-'+b;
    }
    else{
      var infoFiltre = event.target.parentNode.childNodes[3].value;
    }
    if(infoFiltre.length==0){
      return;
    }
    if(document.getElementById(id)==null){
      let nameElement = document.createElement('p');
      nameElement.textContent = name;
      nameElement.id = id;
      let contentElement = document.createElement('span');
      contentElement.id = 'span_'+id;
      contentElement.textContent=infoFiltre;
      document.getElementById('vosFiltres').append(nameElement);
      document.getElementById(id).append(contentElement);
      document.getElementById('vosFiltres').style.display="block";
    }
    else{
     document.getElementById(id).querySelector('span').textContent = infoFiltre; 
    }
  }

  function searchFiltre(){
    let childNodesFiltre = document.getElementById('vosFiltres').childNodes;
    var tabFiltreInfo = [];
    for (let i = 3; i < childNodesFiltre.length; i++) {
      tabFiltreInfo[childNodesFiltre[i].id] = childNodesFiltre[i].querySelector('span').textContent;
    }
    // window.location = "/?controller=home";
  }
  function onChange(){
    var info = document.getElementById('filtre').value;
    if(info == 'horaire'){
      document.getElementById('sectionHoraire').style.display='block';
      document.getElementById('sectionNiveau').style.display='none';
      document.getElementById('sectionTemps').style.display='none';
      document.getElementById('sectionNom').style.display='none';
    }
    if(info == 'niveau'){
      document.getElementById('sectionHoraire').style.display='none';
      document.getElementById('sectionNiveau').style.display='block';
      document.getElementById('sectionTemps').style.display='none';
      document.getElementById('sectionNom').style.display='none';
    }
    if(info == 'duree'){
      document.getElementById('sectionNom').style.display='none';
      document.getElementById('sectionHoraire').style.display='none';
      document.getElementById('sectionNiveau').style.display='none';
      document.getElementById('sectionTemps').style.display='block';      
    }
    if(info == 'nom'){
      document.getElementById('sectionNom').style.display='block';
      document.getElementById('sectionHoraire').style.display='none';
      document.getElementById('sectionNiveau').style.display='none';
      document.getElementById('sectionTemps').style.display='none';  
    }
  }
</script>
<script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth'
  });
  calendar.render();
});


  <?php if(isset($filtreDate)):?>
  var DateSelected = "<?php echo($filtreDate);?>";
  var DateDebut = DateSelected.substring(0,10);;
  var HeureDebut = DateSelected.substring(11,19);
  var DateFin = DateSelected.substring(20,30);
  var HeureFin = DateSelected.substring(31,39);

  <?php else: ?>
  
  var DateDebut = '2023-01-19';
  var DateFin = '2023-01-19';
  var HeureDebut = '09:00:00';
  var HeureFin = '13:00:00';

  <?php endif; ?>


  document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    height: 1000,
    width: 5000,
    contentHeight: 600,
    expandRows: true,
    locale: 'fr',
    initialDate: '2023-01-19',
    initialView: 'timeGrid',
        slotMinTime: HeureDebut,
        slotMaxTime: HeureFin,
        slotDuration: '00:10:00',
        allDaySlot: false,
    nowIndicator: true,
    headerToolbar:{
  start: 'title', // will normally be on the left. if RTL, will be on the right
  center: '',
  end: 'prev,next' // will normally be on the right. if RTL, will be on the left
},
navLinks: true, // can click day/week names to navigate views
    editable: false,
    selectable: true,
    selectMirror: false,
    dayMaxEvents: true, // allow "more" link when too many events
visibleRange: {
    start: DateDebut,
    end: DateFin
  },
  eventClick: function(info) {
    // change the border color just for fun
    info.el.style.borderColor = 'red';
  },
  events:[
      <?php
        if(isset($count) && $count !== 0): ?>
              <?php  $getInfoCreneau = $m->findRequestedFiltre();?>
                <?php foreach ($getInfoCreneau as $key => $value):?> 
                  <?php if(isset($filtreNiveau)): ?>
                    <?php $testing = strpos($getInfoCreneau[$key]['nom_niveau'],$filtreNiveau) !== false;
                          $testing2 = $getInfoCreneau[$key]['disponibilite']==true;
                    ?>
                    <?php if((strpos($getInfoCreneau[$key]['nom_niveau'],$filtreNiveau) !== false) && $getInfoCreneau[$key]['disponibilite']==true): ?>    
            {title:"Stand : <?php print($getInfoCreneau[$key]['nom_stand'])?>",
            start: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_debut'])?>',
            end: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_fin'])?>'},
                <?php endif;?>
                <?php endif;?>
                <?php if(isset($filtreNom)): ?>
                <?php if($getInfoCreneau[$key]['nom_stand'] == $filtreNom && $getInfoCreneau[$key]['disponibilite']==true): ?>    
                  {title:"Stand : <?php print($getInfoCreneau[$key]['nom_stand'])?>",
            start: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_debut'])?>',
            end: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_fin'])?>'},
                <?php endif;?>
                <?php endif;?>
                <?php if(isset($filtreDuree)): ?>
                <?php $filtreDuree = substr($filtreDuree, 3, 5);
                intval($filtreDuree);?>
                <?php if($getInfoCreneau[$key]['duree'] == $filtreDuree && $getInfoCreneau[$key]['disponibilite']==true): ?>    
                  {title:"Stand : <?php print($getInfoCreneau[$key]['nom_stand'])?>",
                  start: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_debut'])?>',
                  end: '<?php print($getInfoCreneau[$key]['date_creneau'])?>T<?php print($getInfoCreneau[$key]['heure_fin'])?>'},
                <?php endif;?>
                <?php endif;?>
                <?php endforeach;?>
            <?php else:?>
              <?php foreach ($infoPlanning as $key => $value):?>
          {title:"Stand : <?php print($infoPlanning[$key]['nom_stand'])?>",
          start: '<?php print($infoPlanning[$key]['date_creneau'])?>T<?php print($infoPlanning[$key]['heure_debut'])?>',
          end: '<?php print($infoPlanning[$key]['date_creneau'])?>T<?php print($infoPlanning[$key]['heure_fin'])?>'},
          <?php endforeach; ?>
        <?php endif; ?>
    ] 
});
  calendar.render();
});
</script>
  <div id='calendar' style='max-width: 5000px; margin: 80px 80px;'></div>
<?php require("view_fin.php");?> 