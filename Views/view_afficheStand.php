<?php include('view_debut.php');?>
<?php
require_once("./Models/Model.php");
$m = Model::getModel();
$id = $m->getIdStand(urldecode($_GET['nom_stand']));
$data['hour'] = $m->getStandInfos($id[0]['id_stand']);
$tableau = $m->getCreneaufromId($id);
?>
<link rel="stylesheet" type="text/css" href="stand.css"/>


<!-- About -->

<div class="about-us section-padding" data-scroll-index='1'>
  <div class="container">
    <div class="row">
      <div class="col-md-12 section-title text-center">
        <h3><?php echo $hour['nom_stand']?></h3>
        <span class="section-title-line"></span> </div>
      <div class="col-md-6 mb-50">
        <div class="section-info">
          <div class="sub-title-paragraph">
            <h4>Description</h4>
            <p><?php echo $hour['description']?></p>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- End About -->


<script src='Utils/fullcalendar-6.0.2/dist/index.global.js'></script>
<script src='Utils/fullcalendar-6.0.2/dist/index.global.min.js'></script>

<script>


document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'fr',
    initialDate: '2023-01-19',
    initialView: 'timeGrid',
    height: 800,
    contentHeight: 2000,
    expandRows: true,
        slotMinTime: '09:00:00',
        slotMaxTime: '13:30:00',
    slotDuration: '00:15:00',
        allDaySlot: false,
    nowIndicator: true,
    headerToolbar:{
  start: 'title', // will normally be on the left. if RTL, will be on the right
  center: '',
  end: '' // will normally be on the right. if RTL, will be on the left
},
handleWindowResize: true,
navLinks: true, // can click day/week names to navigate views
    editable: false,
    selectable: true,
    selectMirror: false,
    dayMaxEvents: true, // allow "more" link when too many events
visibleRange: {
  start: '2023-01-19',
  end: '2023-01-20'
  },
  events : [
      <?php foreach ($t as $key => $value):?>
      {title:"Stand : <?php print($value['title']); ?>",
      start: '<?php print($value['date_creneau'])?>T<?php print($value['heure_debut'])?>',
      end: '<?php print($value['date_creneau'])?>T<?php print($value['heure_fin'])?>',
      color: '<?php print($value['color'])?>'},
      <?php endforeach; ?>
    ]




});
document.getElementById('Matin').addEventListener('click', function() {
    calendar.setOption('slotMinTime', '09:00:00');
    calendar.setOption('slotMaxTime', '13:30:00');

});
document.getElementById('Après-Midi').addEventListener('click', function() {
    calendar.setOption('slotMinTime', '13:30:00');
    calendar.setOption('slotMaxTime', '18:00:00');
});

document.getElementById('Jeudi').addEventListener('click', function() {
    calendar.setOption('visibleRange',
{    start: '2023-01-19',
  end: '2023-01-20'
 }
    );
});
document.getElementById('Vendredi').addEventListener('click', function() {
    calendar.setOption('visibleRange',
     { start: '2023-01-20',
    end: '2023-01-20' }
    );
});
  calendar.updateSize();
  calendar.render();
});

</script>
<input type="button" value="Jeudi" id='Jeudi' style='  margin-left:auto; ' />
<input type="button" value="Vendredi" id='Vendredi'style='margin-left:auto; ' />
<input type="button" value="Matin" id='Matin' style='  margin-left:auto; ' />
<input type="button" value="Après-Midi" id='Après-Midi'style='margin-left:auto; ' />

  <div id='calendar' style='max-width: 5000px; margin: 80px 150px;'></div>




<?php require "view_fin.php" ?>