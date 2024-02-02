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
        function showPopup(popupElement) {
            popupElement.style.display = 'block';
        }
        function hidePopup(popupElement) {
            popupElement.style.display = 'none';
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
            showPopup(accessPopup);
        });

        closeAccessBtn.addEventListener('click', function () {
            hidePopup(accessPopup);
        });

        openAccessOutBtn.addEventListener('click', function () {
            hidePopup(popup);
            hidePopup(registerPopup);
            showPopup(accessPopup);
        });

        openRegisterBtn.addEventListener('click', function () {
            hidePopup(popup);
            hidePopup(accessPopup);
            showPopup(registerPopup);
        });

        closeRegisterBtn.addEventListener('click', function () {
            hidePopup(registerPopup);
        });

        openRegisterOutBtn.addEventListener('click', function () {
            hidePopup(popup);
            hidePopup(accessPopup);
            showPopup(registerPopup);
        });

		document.getElementById('showPasswordAccess').addEventListener('change', function() {
      	var passwordInput = document.getElementById('passwordInputaccess');
      	passwordInput.type = this.checked ? 'text' : 'password';
  		});
  		
		document.getElementById('showPasswordRegister').addEventListener('change', function() {
      	var passwordInput = document.getElementById('passwordInput');
      	passwordInput.type = this.checked ? 'text' : 'password';
  		});
  		
        function controllaInput() {
            var valoreInput1 = document.getElementById('passwordInput').value;
            var valoreInput2 = document.getElementById('passwordInputControl').value;
            var controlloElement = document.getElementById('controllo');
            var bottone = document.getElementById("avanti-register");

            if (valoreInput1 === valoreInput2) {
            	controlloElement.innerText = '';
            	document.getElementById("avanti-register").disabled = false;
            	bottone.style.backgroundColor = "#FF0000";
            	bottone.style.borderColor = "#FF0000";
            	bottone.classList.remove("avanti-register-button-senza-hover");
            } else {
                controlloElement.innerText = 'le password non corrispondono';
                document.getElementById("avanti-register").disabled = true; 
                bottone.style.backgroundColor = "gray";
                bottone.style.borderColor = "gray"
                bottone.classList.add("avanti-register-button-senza-hover");
            }
        }

        var passwordInput = document.getElementById('passwordInput');
        var passwordInputControl = document.getElementById('passwordInputControl');

        passwordInput.addEventListener('blur', controllaInput);
        passwordInputControl.addEventListener('blur', controllaInput);
  	  	});

        function checkEmail(theForm) {
            var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/
            if (re.test(theForm.news.value))
                return true;
            alert("l'eMail \"" + theForm.news.value + "\" NON \u00c8 valida!");
            return false;
        }