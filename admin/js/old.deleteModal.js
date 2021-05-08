let del            = document.querySelector('.delete-bubbling-container');
let deleteModal    = document.querySelector('#delete-modal .modal-content h5');
let btnModalDelete = document.querySelector('.btnModalDelete');

let deleteId;
let deleteName;
let deleteIdType;
let targetTR;

del.addEventListener('click', e =>{
    let target = e.target.tagName;

    if(target == 'BUTTON' || target == 'I'){
        deleteId      = (target == 'BUTTON') ? e.target.previousElementSibling.value   : e.target.parentElement.previousElementSibling.value;
        deleteName    = (target == 'BUTTON') ? e.target.dataset.name : e.target.parentElement.dataset.name;
        deleteIdType  = (target == 'BUTTON') ? e.target.previousElementSibling.name    : e.target.parentElement.previousElementSibling.name;
        targetTR      = (target == 'BUTTON') ? e.target.parentElement.parentElement    : e.target.parentElement.parentElement.parentElement;
        deleteModal.innerHTML = `Are you sure to delete ${deleteName}?`;
    }
});

btnModalDelete.addEventListener('click', e =>{

    ajaxDelete('includes/ajax_functions.php', deleteIdType, deleteId)
        .then(response =>{
            if(response.location){
                if(window.location.pathname.includes('edit')){
                    window.location.href = response.location;
                }else{
                    //M.toast({html: response.message, classes: 'green rounded'});
                    //targetTR.remove();
                    window.location.reload();
                }
            }else{
                console.log('ID Type not valid');
            }

        })
        .catch(err =>{
            console.log(err.message);
        });

});


const ajaxDelete = async (path, type, id)=>{

    formData = new FormData();
    formData.append('idType', type);
    formData.append('id', id);

    const response = await fetch(path, {method: 'POST', body: formData});

    if(response.status != 200){
        throw new Error('There is an error in requesting');
    }

    const data = await response.json();

    return data;

}