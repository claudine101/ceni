const MAX_WIDTH = 400;
const MAX_HEIGHT = 400;
const MIME_TYPE = "image/png";
const QUALITY = 0.2;
 
// const input = document.getElementById("img-input");
// input.onchange = function (ev) {

function readURL(ev,id) {
  console.log(ev);
  const file = ev.files[0]; // get the file
  const blobURL = URL.createObjectURL(file);
  const img = new Image();
  img.src = blobURL;
  img.onerror = function () {
    URL.revokeObjectURL(this.src);
    // Handle the failure properly
    console.log("Cannot load image");
  };
  img.onload = function () {
    URL.revokeObjectURL(this.src);
    const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
    const canvas = document.createElement("canvas");
    canvas.id = "canv"+id;
    canvas.width = newWidth;
    canvas.height = newHeight;
    const ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0, newWidth, newHeight);

    $('#root2'+id).html("");
    $('#PHOTOS'+id).val("")

    canvas.toBlob(
      (blob) => {
       displayInfo('Fichier Compressé', blob,id);
        // Handle the compressed image. es. upload or save in local state
        displayInfo('Original file', file,id);
     // displayInfo('Compressed file', blob);
        
      },
      MIME_TYPE,
      QUALITY
    );
    
    //$('#root2').html(displayInfo('Compressed file', blob));
    //document.getElementById("root2").html("");
  
 document.getElementById("root2"+id).append(canvas);


  var canv = document.getElementById('canv'+id);
  var image = new Image();
  image.id = "imageGet"
  image.src = canv.toDataURL("image/png");
  var type = 'image/png';
  var imgName = generate_code_photo(7)+".png";
  //alert(canv.toDataURL("image/png"))

  const dataURL = canv.toDataURL("image/png");
  //document.getElementById('PHOTOS').value(dataURL)
  $('#PHOTOS'+id).val(dataURL)
    
  //download(canv.toDataURL("image/png"), imgName);

  };

}







function download(dataurl, filename) {
  const link = document.createElement("a");
  link.href = dataurl;
  link.download = filename;
  link.click();
}

function generate_code_photo(taille=0){

    var Caracteres = '0123456789'; 
    var QuantidadeCaracteres = Caracteres.length; 
    QuantidadeCaracteres--; 
    var Hash= ''; 
      for(var x =1; x <= taille; x++){ 
          var Posicao = Math.floor(Math.random() * QuantidadeCaracteres);
          Hash +=  Caracteres.substr(Posicao, 1); 
      }
      return "25"+Hash; 
}

function calculateSize(img, maxWidth, maxHeight) {
  let width = img.width;
  let height = img.height;

  // calculate the width and height, constraining the proportions
  if (width > height) {
    if (width > maxWidth) {
      height = Math.round((height * maxWidth) / width);
      width = maxWidth;
    }
  } else {
    if (height > maxHeight) {
      width = Math.round((width * maxHeight) / height);
      height = maxHeight;
    }
  }
  return [width, height];
}

// Utility functions for demo purpose

function displayInfo(label, file,id) {
  const p = document.createElement('p');
  p.innerText = `${label} - ${readableBytes(file.size)}`;
  document.getElementById('root2'+id).append(p);
}

function readableBytes(bytes) {
  const i = Math.floor(Math.log(bytes) / Math.log(1024)),
    sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

  return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
}