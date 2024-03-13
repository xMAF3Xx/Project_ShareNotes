document.addEventListener('DOMContentLoaded', function () {
    var popup = document.getElementById('popup');
    var openPopupBtn = document.getElementById('openPopupBtn');
    var closePopupBtn = document.getElementById('closePopupBtn');
    var accessPopup = document.getElementById('access-popup');
    var openAccessBtn = document.getElementById('access');
    var closeAccessBtn = document.getElementById('closeaccess');
    var openAccessOutBtn = document.getElementById('access-out');
    var registerPopup = document.getElementById('register-popup');
    var openRegisterBtn = document.getElementById('register');
    var closeRegisterBtn = document.getElementById('closeregister');
    var openRegisterOutBtn = document.getElementById('register-out');
    var blurry = document.getElementById('blurrato');

    /*var popupWrapper = document.getElementById("popup-requirements");
    popupWrapper.style.display = "block";
    blurry.classList.add("blur-screen");*/

    function initializeAccessBtn() {
        var bottone3 = document.getElementById("avanti-access");
        bottone3.disabled = true;
        bottone3.style.backgroundColor = "gray";
        bottone3.style.borderColor = "gray";
        bottone3.classList.add("avanti-register-button-senza-hover");
    }

    function initializeRegisterBtn() {
        var bottone4 = document.getElementById("avanti-register");
        bottone4.disabled = true;
        bottone4.style.backgroundColor = "gray";
        bottone4.style.borderColor = "gray";
        bottone4.classList.add("avanti-register-button-senza-hover");
    }

    function showPopup(popupElement) {
        popupElement.style.display = 'block';
        blurry.classList.add("blur-screen");
    }

    function hidePopup(popupElement) {
        popupElement.style.display = 'none';
        blurry.classList.remove("blur-screen");
    }

    function closePopups() {
        hidePopup(popup);
        hidePopup(accessPopup);
        hidePopup(registerPopup);
    }

    document.addEventListener('click', function (event) {
        var isClickInsidePopups = popup.contains(event.target) || accessPopup.contains(event.target) || registerPopup.contains(event.target);
    
        if (!isClickInsidePopups) {
            closePopups();
        }
    });
    
    openPopupBtn.addEventListener('click', function (event) {
        event.stopPropagation(); 
        showPopup(popup);
    });

    closePopupBtn.addEventListener('click', function () {
        hidePopup(popup);
    });

    openAccessBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(registerPopup);
        initializeAccessBtn();
        showPopup(accessPopup);
    });

    closeAccessBtn.addEventListener('click', function () {
        hidePopup(accessPopup);
    });

    openAccessOutBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(registerPopup);
        initializeAccessBtn();
        showPopup(accessPopup);
    });

    openRegisterBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(accessPopup);
        initializeRegisterBtn();
        showPopup(registerPopup);
    });

    closeRegisterBtn.addEventListener('click', function () {
        hidePopup(registerPopup);
    });

    openRegisterOutBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(accessPopup);
        initializeRegisterBtn();
        showPopup(registerPopup);
    });

    document.getElementById('showPasswordAccess').addEventListener('change', function () {
        var passwordInputAccess = document.getElementById('passwordInputaccess');
        passwordInputAccess.type = this.checked ? 'text' : 'password';
    });

    document.getElementById('showPasswordRegister').addEventListener('change', function () {
        var passwordInput1 = document.getElementById('passwordInput');
        var passwordInput2 = document.getElementById('passwordInputControl');
        passwordInput1.type = this.checked ? 'text' : 'password';
        passwordInput2.type = this.checked ? 'text' : 'password';
    });

    function checkEmail(email) {
        var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
        return re.test(email);
    }

    document.getElementById('classes').addEventListener('change', validatePassword);
    
    function validatePassword() {
        var passwordInput = document.getElementById('passwordInput').value;
        var confirmPasswordInput = document.getElementById('passwordInputControl').value;
        var email = document.getElementById('emailInput').value;
        var nick = document.getElementById('nickinput').value;
        var controlloElement = document.getElementById('controllo');
        var registerButton = document.getElementById('avanti-register');
        var classy = document.getElementById('classes').value;

        if (passwordInput === confirmPasswordInput && checkEmail(email) && nick !== '' && passwordInput !== '' && classy !== 'none') {
            controlloElement.innerText = '';
            registerButton.disabled = false;
            registerButton.style.backgroundColor = "#FF0000";
            registerButton.style.borderColor = "#FF0000";
            registerButton.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement.innerText = 'Credenziali non valide :(';
            registerButton.disabled = true;
            registerButton.style.backgroundColor = "gray";
            registerButton.style.borderColor = "gray";
            registerButton.classList.add("avanti-register-button-senza-hover");
        }
    }

    function validateEmail() {
        var email = document.getElementById('emailInput').value;
        var passwordInput = document.getElementById('passwordInput').value;
        var confirmPasswordInput = document.getElementById('passwordInputControl').value;
        var nick = document.getElementById('nickinput').value;
        var controlloElement = document.getElementById('controllo');
        var registerButton = document.getElementById('avanti-register');
        var classy = document.getElementById('classes').value;

        if (checkEmail(email) && passwordInput === confirmPasswordInput && nick !== '' && passwordInput !== '' && classy !== 'none') {
            controlloElement.innerText = '';
            registerButton.disabled = false;
            registerButton.style.backgroundColor = "#FF0000";
            registerButton.style.borderColor = "#FF0000";
            registerButton.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement.innerText = 'Credenziali non valide :(';
            registerButton.disabled = true;
            registerButton.style.backgroundColor = "gray";
            registerButton.style.borderColor = "gray";
            registerButton.classList.add("avanti-register-button-senza-hover");
        }
    }

    function validateLogin() {
        var email = document.getElementById('emailInputaccess').value;
        var password = document.getElementById('passwordInputaccess').value;
        var loginButton = document.getElementById('avanti-access');
        var controlloElement = document.getElementById('controlloLog');
        var checkon = document.getElementById('loggedOn'); 
        var checkoff = document.getElementById('loggedOff'); 

        if (checkEmail(email) && email!=="" && password !== '' && (checkon.checked || checkoff.checked)) {
            controlloElement.innerText = '';
            loginButton.disabled = false;
            loginButton.style.backgroundColor = "#9A9CF2";
            loginButton.style.borderColor = "#9A9CF2";
            loginButton.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement.innerText = 'Credenziali non valide :(';
            loginButton.disabled = true;
            loginButton.style.backgroundColor = "gray";
            loginButton.style.borderColor = "gray";
            loginButton.classList.add("avanti-register-button-senza-hover");
        }
    }
    
    loggedOn.addEventListener('change', validateLogin);
    loggedOff.addEventListener('change', validateLogin);
    
    function onlyOneYes() {
        var checkon1 = document.getElementById('loggedOn'); 
        var checkoff1 = document.getElementById('loggedOff'); 

        if (checkoff1.checked) {
            checkoff1.checked = false;
        }
    }
    loggedOn.addEventListener('change', onlyOneYes);
    
    function onlyOneNo() {
        var checkon1 = document.getElementById('loggedOn'); 
        var checkoff1 = document.getElementById('loggedOff'); 

        if (checkon1.checked) {
            checkon1.checked = false;
        } 
    }
    loggedOff.addEventListener('change', onlyOneNo);

    document.getElementById('passwordInput').addEventListener('change', validatePassword);
    document.getElementById('passwordInputControl').addEventListener('change', validatePassword);
    document.getElementById('nickinput').addEventListener('change', validatePassword);
    document.getElementById('emailInput').addEventListener('change', validateEmail);
    document.getElementById('passwordInputaccess').addEventListener('change', validateLogin);
    document.getElementById('emailInputaccess').addEventListener('change', validateLogin);

});

