function cambiaStatoMateria(id) {
    var folderMath = document.getElementById(id);
    var titleSub = document.getElementById(id);
    folderMath.classList.toggle("folders-clicked"); 
    titleSub.classList.toggle('materia-clicked');
}
