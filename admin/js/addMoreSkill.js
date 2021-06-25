let btnAddSkill = document.querySelector("#addSkill");
let btnAddPassive = document.querySelector("#addPassive");
let skillContainer = document.querySelector(".skill-talents");
let passiveContainer = document.querySelector(".passive-talents");
// let removeExtraSkill = document.querySelector("#removeExtraSkill");


let skillCount = 0;
btnAddSkill.addEventListener('click', e =>{
    e.preventDefault();

    let newSkill = document.createElement('div');
    newSkill.classList.add("extraskill"); 
    newSkill.classList.add("col"); 
    newSkill.classList.add("l12");
    
    newSkill.innerHTML = `
        <div class="col s12 m12 l12 right-align">
            <a href="#"><i class="material-icons red-text text-lighten-1" id="removeExtraSkill">close</i></a>
        </div>
        <div class="input-field col l3">
            <input type="text" name="skill_talents[${skillCount}][name]" id="name">
            <label for="name">Name</label>
        </div>
        <div class="input-field col l3">
            <input type="text" name="skill_talents[${skillCount}][unlock]" id="unlock" value="">
            <label for="unlock">Unlock</label>
        </div>
        <div class="input-field col l12">
            <textarea class="materialize-textarea" name="skill_talents[${skillCount}][description]" id="description" cols="30" rows="10"></textarea>
            <label for="description">Description</label>
        </div>`;

        skillContainer.appendChild(newSkill);
        skillCount++;
});

skillContainer.addEventListener('click', e =>{
    e.preventDefault();

    let target = e.target.parentElement.parentElement.parentElement;

    if(e.target.id == "removeExtraSkill"){
        target.remove();
        skillCount--;
    }
    
});

/***********************/
let passiveCount = 0;
btnAddPassive.addEventListener('click', e =>{
    e.preventDefault();

    let newPassive = document.createElement('div');
    newPassive.classList.add("extraPassive"); 
    newPassive.classList.add("col"); 
    newPassive.classList.add("l12");

    newPassive.innerHTML = `
        <div class="col s12 m12 l12 right-align">
        <a href="#"><i class="material-icons red-text text-lighten-1" id="removeExtraPassive">close</i></a>
        </div>
        <div class="input-field col l3">
            <input type="text" name="passive_talents[${passiveCount}][name]" id="name">
            <label for="name">Name</label>
        </div>
        <div class="input-field col l3">
            <input type="text" name="passive_talents[${passiveCount}][unlock]" id="unlock" value="">
            <label for="unlock">Unlock</label>
        </div>
        <div class="input-field col l12">
            <textarea class="materialize-textarea" name="passive_talents[${passiveCount}][description]" id="description" cols="30" rows="10"></textarea>
            <label for="description">Description</label>
        </div>
    `;

    passiveContainer.appendChild(newPassive);
    passiveCount++;
});

passiveContainer.addEventListener('click', e =>{
    e.preventDefault();

    let target = e.target.parentElement.parentElement.parentElement;

    if(e.target.id == "removeExtraPassive"){
        target.remove();
        passiveCount--;
    }
    
});

