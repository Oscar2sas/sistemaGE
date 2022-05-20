// Obtener referencia al input y a la imagen

/*const $cbandera = document.querySelector("#cbandera"),
  $preview = document.querySelector("#preview");

// Escuchar cuando cambie
$cbandera.addEventListener("change", () => {
  // Los archivos seleccionados, pueden ser muchos o uno
  const archivos = $cbandera.files;
  // Si no hay archivos salimos de la función y quitamos la imagen
  if (!archivos || !archivos.length) {
    $preview.src = "";
    return;
  }
  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
  const primerArchivo = archivos[0];
  // Lo convertimos a un objeto de tipo objectURL
  const objectURL = URL.createObjectURL(primerArchivo);
  // Y a la fuente de la imagen le ponemos el objectURL
  $preview.src = objectURL;
}); */

document.getElementById("file").onchange = function(e) {
	let reader = new FileReader();
  
  reader.onload = function(){
    let preview = document.getElementById('preview'),
    		image = document.createElement('img');

    image.src = reader.result;
    
    preview.innerHTML = '';
    preview.append(image);
  };
 
  reader.readAsDataURL(e.target.files[0]);
}