document.getElementById('input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        caricaContenuto();
    }
});

function caricaContenuto() {
    var inputValue = document.getElementById('input').value;
    window.location.href = "ok.html";
}

function submitSelected(idValue, Form = 'Filters'){
	var selectedValue = document.getElementById(idValue).value;
    localStorage.setItem("selectedOption"+idValue, selectedValue);
	document.getElementById(Form).submit();
}

function setSelectedValue(idValue) {
	var selectedValue = localStorage.getItem("selectedOption"+idValue);
	if (selectedValue) {
		document.getElementById(idValue).value = selectedValue;
	}
}

function setAll(){
	setSelectedValue('classFilter');
	setSelectedValue('annoFilter');
    setSelectedValue('matFilter');
	setSelectedValue('input');
}