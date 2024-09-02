import Dropzone  from "dropzone";

Dropzone.autoDiscover = false;
addEventListener('DOMContentLoaded', ()=>{
    const dropzone = new Dropzone('#dropzone', {
        dictDefaultMessage: 'Sube aquí tú imagen',
        acceptedFiles: '.png,.jpg,.jpeg,.gif',
        addRemoveLinks: true,
        dictRemoveFile: 'Borrar Archivo',
        maxFiles: 1,
        uploadMultiple: false,
    
        init: function(){
            if(document.querySelector('[name="imagen"]').value.trim()){
                const imagenPublicada = {};
                imagenPublicada.size = 1234;
                imagenPublicada.name = document.querySelector('[name="imagen"]').value;
    
                this.options.addedfile.call(this, imagenPublicada);
                this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);
    
                imagenPublicada.previewElement.classList.add('dz-success','dz-complete');
            }
        }
    });
    
    
    dropzone.on('success',(file,response) => {
        console.log(response.imagen);
        document.querySelector('[name="imagen"]').value = response.imagen;
    })
    
    dropzone.on('removedfile', (f) => {
        document.querySelector('[name="imagen"]').value = '';
    })
    
    dropzone.on('error',(file,message) => {
        console.log(message);
    })

})
