    var btnComment = document.querySelector('#btnComment');
    var frmComment = document.querySelector('.form-comment');
    var containerComment = document.querySelector('.comments-container');
    var commentInput = document.querySelector('#textarea1');
    var commentCount = document.querySelector('#commentCount');

    btnComment.addEventListener('click', e =>{
        e.preventDefault();

        //modalInstance.open();
        addComment('./ajax_code.php')
            .then(response =>{
                if(response){
                    if(response == 'login'){
                        modalLoginInstance.open();
                    }else{
                        containerComment.innerHTML += response;
                        commentInput.value = "";
                        commentCount.innerHTML++;
                    }
                }

            }).catch(err => {
                console.log(err.message);
            });

    });

    const addComment = async(path) =>{
        var formData = new FormData(frmComment);

        const response = await fetch(path, {method: 'POST', body: formData});

        if(response.status != 200){
            throw new Error('Error ' + response.status);
        }

        const data = await response.text();
        return data;
    }