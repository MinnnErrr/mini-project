const imageInput = document.getElementById('id-image-input');
imageInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();

    if(file){
        const imageStudent = document.getElementById('imageStudent');
/*************  ✨ Codeium Command ⭐  *************/
        // Once the image is loaded, this function is called
        // The image is then set as the source of the imageStudent element
        // This will update the image that is displayed on the webpage
/******  1221e9b1-5c71-4b65-a622-e4903b6b64b1  *******/         reader.onload = function (event) {
        imageStudent.src = event.target.result;
        };
    }
   
    reader.readAsDataURL(file);
})
;