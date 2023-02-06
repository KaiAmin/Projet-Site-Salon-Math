
function showNewPassword(){
    let password= document.getElementById('newpswd');
    if (password.type === "password"){
        password.type="text";
    }
    else{
        password.type="password";
    }
}

function showtoConfirmPassword(){
    let password= document.getElementById('confirmpswd');
    if (password.type === "password"){
        password.type="text";
    }
    else{
        password.type="password";
    }
}

function validerForm()
{
    let confirmMdp = document.forms["form-newMdp"]["confirmpswd"].value;
    let newMdp = document.forms["form-newMdp"]["newpswd"].value;
  
    if(newMdp === confirmMdp)
  { 
    return true;
  }
    event.preventDefault(); 
    document.getElementById('alertMdp').style.display='block';
    document.getElementById('confirmpswd').style.color='red';
    return false;
}