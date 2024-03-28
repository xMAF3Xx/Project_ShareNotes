//import JSZip from 'jszip/dist/jszip.js'
//import FileSaver from 'file-saver/dist/FileSaver.js'

function downloadNota(titoloNota, contenutoNota){
	const ZIP = new JSZip();
    const encoded = contenutoNota.split(',')[1];
	ZIP.file(titoloNota+'.png', encoded, {base64: true});
	ZIP.generateAsync({type: 'blob'}).then(function (contenuto){
		saveAs(contenuto, titoloNota+'.zip');
	});
}