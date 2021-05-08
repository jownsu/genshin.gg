var charList = document.querySelector(".char-modal");

charList.addEventListener('click', e =>{
    e.preventDefault();

     var charTarget = e.target.parentElement.tagName;
     var charId = e.target.parentElement.dataset.id;
     var charInfoModal = document.querySelector('#charInfoModal');

    // var path = e.target.src.split('/');
    // path[path.length - 2] = 'Portraits';
    // var portraitPath = path.join('/');
    if(charTarget == 'A'){
        showCharInfo("ajax_code.php", charId)
            .then(data =>{
                charInfoModal.innerHTML = data;
            })
            .catch(err =>{
                console.log(err.message);
            });
    }

});

const showCharInfo = async (path, id) =>{
    const formData = new FormData();
    formData.append('charId', id);
    const response = await fetch(path,{method:'post',body: formData});

    if(response.status !== 200){
        throw new Error('Path does not exists');
    }

    const data = await response.text();
    return data;
}