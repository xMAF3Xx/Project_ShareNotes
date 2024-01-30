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

    var openRegisterBtn = document.getElementById('register');
    var registerPopup = document.getElementById('register-popup');

    openRegisterBtn.addEventListener('click', function() {
        registerPopup.style.display = 'block';
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

    var openLoginBtn = document.getElementById('login');
    var loginPopup = document.getElementById('login-popup');

    openLoginBtn.addEventListener('click', function() {
        loginPopup.style.display = 'block';
    });

    var closeLoginBtn = document.getElementById('closelogin');
    closeLoginBtn.addEventListener('click', function() {

        loginPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === loginPopup) {
            loginPopup.style.display = 'none';
        }
    });
});

