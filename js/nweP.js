document.addEventListener('DOMContentLoaded', function() {
    var btnGo = document.getElementById('go');
    btnGo.disabled = true;
    btnGo.classList.remove("goBtnOpen");
    btnGo.classList.add("goBtnLocked");
});

function ctrPassword() {
    const LUNGMINPSW = 8;
    let spaces = false;
    var psw = document.getElementById('password');
    var ctrPsw = document.getElementById('passwordCtr');
    var btnGo = document.getElementById('go');
    var ctrReset = document.getElementById('ctrPsw');
    for (let i = 0; i < password.value.length; i++) {
        if (psw.value[i] === ' ') {
            ctrReset.innerText = 'la password non è conforme ai criteri :(';
            btnGo.disabled = true;
            btnGo.classList.remove("goBtnOpen");
            btnGo.classList.add("goBtnLocked");
            spaces = true;
            break;
        } else {
            spaces = false;
        }
    }
    if (spaces === false && psw.value === ctrPsw.value && psw.value != '' && psw.value.length >= LUNGMINPSW && psw.value[0] != '$' && psw.value[0] != '@' && psw.value != 'password' && psw.value != 'PASSWORD' && psw.value != '12345678' && psw.value != '00000000' && psw.value != 'ABCDEFGH' && psw.value != 'abcdefgh') {
        ctrReset.innerText = '';
        btnGo.disabled = false;
        btnGo.classList.remove("goBtnLocked");
        btnGo.classList.add("goBtnOpen");
        spaces = false;
    } else {
        ctrReset.innerText = 'la password non è conforme ai criteri :(';
        btnGo.disabled = true;
        btnGo.classList.remove("goBtnOpen");
        btnGo.classList.add("goBtnLocked");
        spaces = true;
    }
}

document.addEventListener('click', makeVisiblePsw());

function makeVisiblePsw(visiblePsw) {
    var psw = document.getElementById('password');
    var ctrPsw = document.getElementById('passwordCtr');
    var visiblePsw = document.getElementById('showPsw');
    if (visiblePsw.checked) {
        psw.type = 'text';
        ctrPsw.type = 'text';
    } else {
        psw.type = 'password';
        ctrPsw.type = 'password';
    }
}