document.addEventListener('DOMContentLoaded', () => {
    mailText = document.getElementById('mail');
    passwordText = document.getElementById('password');
    loginButton = document.getElementById('login');

    mailText.addEventListener('change', nullCheck);
    passwordText.addEventListener('change', nullCheck);
});

function nullCheck(){
    if(mailText.value != "" && passwordText.value != ""){
        if(mailText.value != " " && mailText.value != "　" && passwordText.value != " " && passwordText.value != "　"){
            loginButton.removeAttribute('disabled');
        }
    } else {
        loginButton.setAttribute('disabled', true);
    }
}
