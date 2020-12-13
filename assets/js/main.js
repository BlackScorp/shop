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

            console.log("dropped");
            
        },true);

    });
}
})();