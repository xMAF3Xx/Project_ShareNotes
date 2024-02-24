function cambiaStatoMateria(id) {
    var folderMath = document.getElementById(id);
    var titleSub = document.getElementById(id);
    folderMath.classList.toggle("folders-clicked"); 
    titleSub.classList.toggle('materia-clicked');
}

function sort(idApp, classScomp, all) {
	if (all === "all") {
		var classOpen = document.getElementsByClassName(classScomp);
		for(var i = 0; i < classOpen.length; i++) {
    		classOpen[i].style.display = "block";
		}
	} else {
		var elementiDaNascondere = document.getElementsByClassName(classScomp);
    	var elementoDaApparire = document.getElementById(idApp);
		for(var i = 0; i < elementiDaNascondere.length; i++) {
    		elementiDaNascondere[i].style.display = "none";
		}
		elementoDaApparire.style.display = "block";
	}
}
