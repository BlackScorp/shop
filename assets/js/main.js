(function(){
document.querySelector('html').classList.replace('no-js','js');

let isDragAndDropUpload = function(){
    let div = document.createElement('div');
    return ('draggble' in div || ('ondragstart' in div && 'ondrop' in div)) 
    && 'FormData' in window && 'FileReader' in window;
}

if(isDragAndDropUpload){
    document.querySelectorAll('form.droppable').forEach(function(currentForm){
        currentForm.classList.add('can-drop');
        let ajaxLoader = currentForm.querySelector('#ajaxLoader');
        let galleryDiv = currentForm.querySelector('#pictures .row');
        ['dragover','dragenter'].forEach(function(eventName){
      
            currentForm.addEventListener(eventName,function(event){
                event.preventDefault();
                event.stopPropagation();
                currentForm.classList.add('is-dragover');
            },true);
        });

        ['dragleave','dragend','drop'].forEach(function(eventName){
            currentForm.addEventListener(eventName,function(event){
                event.preventDefault();
                event.stopPropagation();
                currentForm.classList.remove('is-dragover');
         },true);
        });

        currentForm.addEventListener('drop',function(event){
            event.preventDefault();
            event.stopPropagation();
            let formData = new FormData(currentForm);
            let droppedFiles = event.dataTransfer.files;
            ajaxLoader.style.display ="block";
            formData.delete('picture[]');

            for(let i = 0,ilenght =droppedFiles.length ;i<ilenght;i++){
                formData.append('picture[]',droppedFiles[i]);   
            }
            
            fetch(currentForm.getAttribute('action'),{
                method:currentForm.getAttribute('method'),
                headers:{
                    'X-Requested-With':'XMLHttpRequest'
                },
                body:formData
            })
            .then(result => result.json())
            .then(result => {
                if(result.successed){
                    currentForm.querySelector('#uploadSuccess').style.display ="block";
                    result.pictures.forEach(function(currentPictureName){
                        galleryDiv.innerHTML += '<div class="col-3"><img src="index.php/product/image/'+currentPictureName+'" class="img-thumbnail"></div>';
                    });
                }
                if(result.successed == false){
                    currentForm.querySelector('#uploadFailed').style.display ="block";
                }
                setTimeout(() => { ajaxLoader.style.display ="none"; }, 2000);
            })
            .catch(error => {
                //Fehlgeschlagen
                currentForm.querySelector('#uploadFailed').style.display ="block";
                console.error('Error:', error);
                setTimeout(() => { ajaxLoader.style.display ="none"; }, 2000);
            });
            console.log("dropped");
            
        },true);

    });
}
})();
