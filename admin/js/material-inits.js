document.addEventListener('DOMContentLoaded', function(){

    var dropdown = document.querySelector('.dropdown-trigger');
    M.Dropdown.init(dropdown,{coverTrigger: false, constrainWidth: false, alignment: 'right'});

    var sidenav = document.querySelector('.sidenav');
    M.Sidenav.init(sidenav);

    var select = document.querySelectorAll('select');
    M.FormSelect.init(select);
    
    var modal = document.querySelectorAll(".modal");
    M.Modal.init(modal,{
        onCloseEnd: () =>{
          let modalPhotos = document.querySelector("#modalPhotos .modal-content") !== null;
          if(modalPhotos){
            modalPhotos.innerHTML = "";
          }
        }
    });



    var tooltip = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltip);
    
});

