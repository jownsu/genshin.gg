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
    
    skillString = `
        <div class="col s12 m12 l12 right-align">
            <a href="#"><i class="material-icons red-text text-lighten-1" id="removeExtraSkill">close</i></a>
        </div>
        <div class="input-field col l3">
            <input type="text" name="skill_talents[${skillCount}][name]" id="name" value="` + escapeHtml(`<?= isset($_POST['skill_talents[${skillCount}][name]']) ? $_POST['skill_talents[${skillCount}][name]'] : '' ?>`) + `" class="<?= ( empty($_POST['skill_talents[${skillCount}][name]']) && isset($empty_err) ) ? 'invalid' : '' ?>">
            <label for="name">Name</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>
        <div class="input-field col l3">
            <input type="text" name="skill_talents[${skillCount}][unlock]" id="unlock" value="<?= isset($_POST['skill_talents[${skillCount}][unlock]']) ? $_POST['skill_talents[${skillCount}][unlock]'] : '' ?>" class="<?= ( empty($_POST['skill_talents[${skillCount}][unlock]']) && isset($empty_err) ) ? 'invalid' : '' ?>">
            <label for="unlock">Unlock</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>
        <div class="input-field col l12">
            <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents[${skillCount}][description]']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="skill_talents[${skillCount}][description]" id="description" cols="30" rows="10"> <?= isset($_POST['skill_talents[${skillCount}][description]']) ? $_POST['skill_talents[${skillCount}][description]'] : '' ?></textarea>
            <label for="description">Description</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>`;

        newSkill.innerHTML = skillString;

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
            <input type="text" name="passive_talents[${passiveCount}][name]" id="name" value="" class="<?= ( empty($_POST['passive_talents[${passiveCount}][name]']) && isset($empty_err) ) ? 'invalid' : '' ?>">
            <label for="name">Name</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>
        <div class="input-field col l3">
            <input type="text" name="passive_talents[${passiveCount}][unlock]" id="unlock" value="" class="<?= ( empty($_POST['passive_talents[${passiveCount}][unlock]']) && isset($empty_err) ) ? 'invalid' : '' ?>">
            <label for="unlock">Unlock</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>
        <div class="input-field col l12">
            <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents[${passiveCount}][description]']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="passive_talents[${passiveCount}][description]" id="description" cols="30" rows="10">  </textarea>
            <label for="description">Description</label>
            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
        </div>
    `;
    // <?= isset($_POST['passive_talents[${passiveCount}][name]']) ? $_POST['passive_talents[${passiveCount}][name]'] : '' ?>
    // <?= isset($_POST['passive_talents[${passiveCount}][unlock]']) ? $_POST['passive_talents[${passiveCount}][unlock]'] : '' ?>
//<?= isset($_POST['passive_talents[${passiveCount}][description]']) ? $_POST['passive_talents[${passiveCount}][description]'] : '' ?>
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

function escapeHtml(str) {
    return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

