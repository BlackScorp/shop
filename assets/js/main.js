(function(){
document.querySelector('html').classList.replace('no-js','js');
const orderStatusElements = document.querySelectorAll('.oderStatus');
orderStatusElements.forEach(function(currentOrderStatusElement){
    currentOrderStatusElement.addEventListener('change',function(){
        const formOfStatus = currentOrderStatusElement.closest('form');
        const event = new CustomEvent("submit", {"bubbles":true, "cancelable": true});
        formOfStatus.dispatchEvent(event);
        
    });
});

const ajaxForms = document.querySelectorAll('.ajax-form');
const ajaxLoader = document.querySelector('#ajaxLoader');
ajaxForms.forEach(function(currentAjaxForm){
    
    currentAjaxForm.addEventListener('submit',function(event){
        event.preventDefault();
        event.stopPropagation();
        ajaxLoader.style.display ="block";
        fetch(currentAjaxForm.getAttribute('action'),{
            method:currentAjaxForm.getAttribute('method'),
            headers:{
                'X-Requested-With':'XMLHttpRequest'
            },
            body:new FormData(currentAjaxForm)
        })
        .then(result => result.json())
        .then(result => {

            ajaxLoader.style.display ="none";
        })
           .catch(error => {
            ajaxLoader.style.display ="none";
            
            });
    });
   
});


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
                        galleryDiv.innerHTML += '<div class="col-3"><a href="index.php/product/image/select/'+currentPictureName+'"><img src="index.php/product/image/'+currentPictureName+'" class="img-thumbnail"></a></div>';
                    });
                }
                if(result.successed == false){
                    currentForm.querySelector('#uploadFailed').style.display ="block";
                }
                ajaxLoader.style.display ="none";
            })
            .catch(error => {
                //Fehlgeschlagen
                ajaxLoader.style.display ="none";
            });
            console.log("dropped");
            
        },true);

    });
}
})();