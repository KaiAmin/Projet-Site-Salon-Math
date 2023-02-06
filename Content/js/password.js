var incorrectMail = "<?php Print($incorrect_mail); ?>";
var unfoundMail = "<?php Print($unfound_mail); ?>";

var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/;
let form = document.getElementById('form-mail');


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
console.log(unfoundMail);
if(unfoundMail){
    document.getElementById('unfoundMail').style.display='block';
}
