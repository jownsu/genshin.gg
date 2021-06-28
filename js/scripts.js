document.addEventListener('DOMContentLoaded', function () {

    /*****Materialize init */

    var dropdown = document.querySelector('.dropdown-trigger');
    M.Dropdown.init(dropdown, {hover: true});

    var sidenav = document.querySelector('.sidenav');
    M.Sidenav.init(sidenav);

    var tooltip = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltip);

    var modalLogin = document.querySelector('.modal.modalLogin');
    modalLoginInstance = M.Modal.init(modalLogin);

    var charInfoModal = document.querySelector('.modal.modalCharInfo');
    M.Modal.init(charInfoModal);

    var select = document.querySelectorAll('select');
    M.FormSelect.init(select);

    /*****End of Materialize init */



    /*****Nav Char filter***********/

    var charNav = document.querySelector('.charNav');
    var charPortrait = document.querySelectorAll('.character-portrait');

    var allElems = document.querySelectorAll('.elemList img');
    var allWeaps = document.querySelectorAll('.weapList img');

    if(charNav){
        charNav.addEventListener('click', e => {
        e.preventDefault();
        let navList = e.target.parentElement.className;
        let elemTarget = e.target.tagName;
        let filter = e.target.dataset.tooltip;

        let element = "";
        let weapon = "";

            if(elemTarget == 'IMG' && navList == 'elemList'){

                allElems.forEach(elem => {
                    if(elem == e.target){
                        elem.classList.toggle('active');
                    }else{
                        elem.classList.remove('active');
                    }
                });
            }

            if(elemTarget == 'IMG' && navList == 'weapList'){


                allWeaps.forEach(elem => {
                    if(elem == e.target){
                        elem.classList.toggle('active');
                    }else{
                        elem.classList.remove('active');
                    }
                });
            }

            if(elemTarget == 'IMG'){
                allElems.forEach(elem => {
                    if(elem.classList.contains('active')){
                        element = elem.dataset.tooltip;
                    }
                });

                allWeaps.forEach(weap => {
                    if(weap.classList.contains('active')){
                        weapon = weap.dataset.tooltip;
                    }
                });
                
                toggleCharacters(element, weapon);
            }
    });
}

    function toggleCharacters(elementFilter = "", weaponFilter = ""){
            if(elementFilter != "" && weaponFilter != ""){
                charPortrait.forEach(char => {
                    if(elementFilter == char.dataset.element && weaponFilter == char.dataset.weapon){
                        char.style.display = "flex";
                    }else{
                        char.style.display = "none";
                    }
                });
            }else if(elementFilter == "" && weaponFilter == ""){
                charPortrait.forEach(char => {
                        char.style.display = "flex";
                });
            }else{
                charPortrait.forEach(char => {
                    if(elementFilter == char.dataset.element || weaponFilter == char.dataset.weapon){
                        char.style.display = "flex";
                    }else{
                        char.style.display = "none";
                    }
                });
            }

    }

    /********End of nav filter**********/

    /******Login Modal***********/

    

    /*********End of Login***********/

    
});


