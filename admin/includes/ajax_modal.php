<div class="modal modal-fixed-footer" id="modalPhotos">
        <div class="modal-content">
            
        </div>

        <div class="modal-footer">
            <button id="modal-update" class="modal-close btn green disabled">Update</button>
        </div>
</div>

<script>

    var modalPhotos = document.querySelector(".modal-content");
    var btnUpdate = document.querySelector("#modal-update");
    var id = document.querySelector("#targetId").value;

    var modalForms = document.querySelectorAll('.btnModalImg');

    var imageName;
    var imageCategory;
    var targetImage;

    modalPhotos.addEventListener('click', e => {
        e.preventDefault();
        var target = e.target;
        if(target.tagName == "IMG"){
            removeActive();
            var path = target.src.split('/');
            imageName = path[path.length - 1];
            imageCategory = path[path.length - 2];
            target.classList.toggle("active");
            btnUpdate.classList.remove("disabled");
        }
    });

    modalForms.forEach(modalForm => {
        modalForm.addEventListener('click', e => {
        e.preventDefault();
        let target = e.target.className;
        targetImage = e.target;
            modalPhotos.innerHTML = "";
            let targetImg = e.target.dataset.test;
            switch (targetImg) {
                case "thumbnail":
                        var thumbnails = <?= json_encode(get_all_thumbnails()) ?>;
                        thumbnails.forEach(thumbnail => {
                            modalPhotos.innerHTML += "<img class='edit-thumbnail modal-image' src='"+ thumbnail +"'>";
                        })
                    break;
                case "portrait":
                        var portraits = <?= json_encode(get_all_portraits()) ?>;
                        portraits.forEach(portrait => {
                            modalPhotos.innerHTML += "<img class='edit-portrait modal-image' src='"+ portrait +"'>";
                        })
                    break;
                case "user":
                    var users = <?= json_encode(get_all_user_images()) ?>;
                        users.forEach(user => {
                            modalPhotos.innerHTML += "<img class='edit-thumbnail modal-image' src='"+ user +"'>";
                        })
                    break;
                default:
                    console.log("There is an error loading the photos");
                    break;
            }
            btnUpdate.classList.add("disabled");
    }) 
    });



    btnUpdate.addEventListener('click', e => {

    updateImage('includes/ajax_functions.php', id, imageCategory, imageName)
        .then(response => {
            switch (imageCategory) {
                case 'Characters':
                    targetImage.src = response.imgLocation;
                    break;
                case 'Portraits':
                    targetImage.src = response.imgLocation;
                    break;
                case 'Users':
                    targetImage.src = response.imgLocation;
                    break;
                default:
                    break;
            }
        })
        .catch(err => {
            console.log(err);
        });


    });

    function removeActive(){
        var images = document.querySelectorAll(".modal-image");

        images.forEach(m => {
        if(m.classList.contains("active")){
                m.classList.remove("active");
        }
        })
    }

    const updateImage = async (path, id, imageCategory, imageName) =>{
        const formData = new FormData();
        formData.append('target_id', id);
        formData.append('image_category', imageCategory);
        formData.append('image_name', imageName);

       const response = await fetch(path, {method: 'POST', body: formData} );

       if(response.status !== 200){
            throw new Error("THe path does not exists");
       }

       const data = await response.json();
       return data;
    }
</script>