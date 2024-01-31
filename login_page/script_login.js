document.addEventListener('DOMContentLoaded', function() {
    var openPopupBtn = document.getElementById('openPopupBtn');
    var closePopupBtn = document.getElementById('closePopupBtn');
    var popup = document.getElementById('popup');

    openPopupBtn.addEventListener('click', function() {
        popup.style.display = 'block';
    });

    closePopupBtn.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
    
	var openAccessBtn = document.getElementById('access');
    var accessPopup = document.getElementById('access-popup');

    openAccessBtn.addEventListener('click', function() {
        accessPopup.style.display = 'block';
        popup.style.display = 'none';
        registerPopup.style.display = 'none';
    });

    var closeAccessBtn = document.getElementById('closeaccess');
    closeAccessBtn.addEventListener('click', function() {
        accessPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === accessPopup) {
            accessPopup.style.display = 'none';
        }
    });
    
    var openRegisterBtn = document.getElementById('register');
    var registerPopup = document.getElementById('register-popup');

    openRegisterBtn.addEventListener('click', function() {
        registerPopup.style.display = 'block';
        popup.style.display = 'none';
        accessPopup.style.display = 'none';
    });

    var closeRegisterBtn = document.getElementById('closeregister');

    closeRegisterBtn.addEventListener('click', function() {
        registerPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === registerPopup) {
            registerPopup.style.display = 'none';
        }
    });

	var openRegisterBtn = document.getElementById('register-out');
    var registerPopup = document.getElementById('register-popup');

    openRegisterBtn.addEventListener('click', function() {
        registerPopup.style.display = 'block';
        popup.style.display = 'none';
        accessPopup.style.display = 'none';
    });

    var closeRegisterBtn = document.getElementById('closeregister');

    closeRegisterBtn.addEventListener('click', function() {
        registerPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === registerPopup) {
            registerPopup.style.display = 'none';
        }
    });

	var openAccessBtn = document.getElementById('access-out');
    var accessPopup = document.getElementById('access-popup');

    openAccessBtn.addEventListener('click', function() {
        accessPopup.style.display = 'block';
        popup.style.display = 'none';
        registerPopup.style.display = 'none';
    });

    var closeAccessBtn = document.getElementById('closeaccess');
    closeAccessBtn.addEventListener('click', function() {
        accessPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === accessPopup) {
            accessPopup.style.display = 'none';
        }
    });
    
});
