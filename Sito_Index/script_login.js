/*document.addEventListener('DOMContentLoaded', function () {
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

	 function inizialiseAccessBtn() {
	 		var bottone3 = document.getElementById("avanti-access");
	 		document.getElementById("avanti-access").disabled = true;
            bottone3.style.backgroundColor = "gray";
            bottone3.style.borderColor = "gray";
            bottone3.classList.add("avanti-register-button-senza-hover");
	 }
	 function inizialiseRegisterBtn() {
	 		var bottone4 = document.getElementById("avanti-register");
	 		document.getElementById("avanti-register").disabled = true;
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

    openPopupBtn.addEventListener('click', function () {
        showPopup(popup);
    });

    closePopupBtn.addEventListener('click', function () {
        hidePopup(popup);
    });

    openAccessBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(registerPopup);
        inizialiseAccessBtn();
        showPopup(accessPopup);
    });

    closeAccessBtn.addEventListener('click', function () {
        hidePopup(accessPopup);
    });

    openAccessOutBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(registerPopup);
        inizialiseAccessBtn();
        showPopup(accessPopup);
    });

    openRegisterBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(accessPopup);
        inizialiseRegisterBtn();
        showPopup(registerPopup);
    });

    closeRegisterBtn.addEventListener('click', function () {
        hidePopup(registerPopup);
    });

    openRegisterOutBtn.addEventListener('click', function () {
        hidePopup(popup);
        hidePopup(accessPopup);
        inizialiseRegisterBtn();
        showPopup(registerPopup);
    });

    document.getElementById('showPasswordAccess').addEventListener('change', function () {
        var passwordInputAccess = document.getElementById('passwordInputaccess');
        passwordInputAccess.type = this.checked ? 'text' : 'password';
    });

    document.getElementById('showPasswordRegister').addEventListener('change', function () {
        var passwordInput = document.getElementById('passwordInput');
        passwordInput.type = this.checked ? 'text' : 'password';
    });

    function controllaPassword() {
        var valoreInput1 = document.getElementById('passwordInput').value;
        var valoreInput2 = document.getElementById('passwordInputControl').value;
        var controlloElement = document.getElementById('controllo');
        var bottone = document.getElementById("avanti-register");
        var emailInput = document.getElementById('emailInput');
        var email = emailInput.value;
        var nick = document.getElementById('nickinput').value;

        if (valoreInput1 === valoreInput2 && checkEmail(email) && nick !== '' && valoreInput1 !== '') {
            controlloElement.innerText = '';
            document.getElementById("avanti-register").disabled = false;
            bottone.style.backgroundColor = "#FF0000";
            bottone.style.borderColor = "#FF0000";
            bottone.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement.innerText = 'credenziali non valide';
            document.getElementById("avanti-register").disabled = true;
            bottone.style.backgroundColor = "gray";
            bottone.style.borderColor = "gray";
            bottone.classList.add("avanti-register-button-senza-hover");
        }
    }

    var passwordInput = document.getElementById('passwordInput');
    var passwordInputControl = document.getElementById('passwordInputControl');

    passwordInput.addEventListener('change', controllaPassword);
    passwordInputControl.addEventListener('change', controllaPassword);
    nickinput.addEventListener('change', controllaPassword);

    function checkEmail(email) {
        var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
        return re.test(email);
    }

    function controllaEmail() {
        var emailInput = document.getElementById('emailInput');
        var email = emailInput.value;
        var controlloElement = document.getElementById('controllo');
        var bottone = document.getElementById("avanti-register");
        var valoreInput1 = document.getElementById('passwordInput').value;
        var valoreInput2 = document.getElementById('passwordInputControl').value;
        var nick = document.getElementById('nickinput').value;

        if (checkEmail(email) && valoreInput1 === valoreInput2 && nick !== '' && valoreInput1 !== '') {
            controlloElement.innerText = '';
            document.getElementById("avanti-register").disabled = false;
            bottone.style.backgroundColor = "#FF0000";
            bottone.style.borderColor = "#FF0000";
            bottone.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement.innerText = 'credenziali non valide';
            document.getElementById("avanti-register").disabled = true;
            bottone.style.backgroundColor = "gray";
            bottone.style.borderColor = "gray";
            bottone.classList.add("avanti-register-button-senza-hover");
        }
    }

    document.getElementById('emailInput').addEventListener('change', controllaEmail);
    nickinput.addEventListener('change', controllaEmail);

    function controllaLogin() {
        var emailAccess = document.getElementById('emailInputaccess').value;
        var passwordAccess = document.getElementById('passwordInputaccess').value;
        var bottone2 = document.getElementById("avanti-access");
        var controlloElement2 = document.getElementById('controlloLog');

        if (checkEmail(emailAccess) && passwordAccess !== '') {
            controlloElement2.innerText = '';
            document.getElementById("avanti-access").disabled = false;
            bottone2.style.backgroundColor = "#9A9CF2";
            bottone2.style.borderColor = "#9A9CF2";
            bottone2.classList.remove("avanti-register-button-senza-hover");
        } else {
            controlloElement2.innerText = 'credenziali non valide';
            document.getElementById("avanti-access").disabled = true;
            bottone2.style.backgroundColor = "gray";
            bottone2.style.borderColor = "gray";
            bottone2.classList.add("avanti-register-button-senza-hover");
        }
    }

    document.getElementById('emailInputaccess').addEventListener('change', controllaLogin);
    passwordInputaccess.addEventListener('change', controllaLogin); 
}); */

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

    function validatePassword() {
        var passwordInput = document.getElementById('passwordInput').value;
        var confirmPasswordInput = document.getElementById('passwordInputControl').value;
        var email = document.getElementById('emailInput').value;
        var nick = document.getElementById('nickinput').value;
        var controlloElement = document.getElementById('controllo');
        var registerButton = document.getElementById('avanti-register');

        if (passwordInput === confirmPasswordInput && checkEmail(email) && nick !== '' && passwordInput !== '') {
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

        if (checkEmail(email) && passwordInput === confirmPasswordInput && nick !== '' && passwordInput !== '') {
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