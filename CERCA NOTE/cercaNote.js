document.getElementById('input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        caricaContenuto();
    }
});

function caricaContenuto() {
    var inputValue = document.getElementById('input').value;
    window.location.href = "ok.html";
}