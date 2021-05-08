<?php require_once("includes/header.php"); ?>

  <h3 style="padding: 0 1em">Dashboard</h3>
  <hr>
<div class="card-container">
  <div class="card anemo">
    <img src="images/anemo.png" alt="anemo" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('anemo') ?> </span>
      <span class="card-name">Anemo</span>
    </div>
  </div>
  <div class="card cryo">
    <img src="images/cryo.png" alt="cryo" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('cryo') ?> </span>
      <span class="card-name">Cryo</span>
    </div>
  </div>

  <div class="card dendro">
    <img src="images/dendro.png" alt="dendro" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('dendro') ?> </span>
      <span class="card-name">Dendro</span>
    </div>
  </div>

  <div class="card electro">
    <img src="images/electro.png" alt="electro" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('electro') ?> </span>
      <span class="card-name">Electro</span>
    </div>
  </div>
  
  <div class="card geo">
    <img src="images/geo.png" alt="geo" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('geo') ?> </span>
      <span class="card-name">Geo</span>
    </div>
  </div>

  <div class="card hydro">
    <img src="images/hydro.png" alt="hydro" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('hydro') ?> </span>
      <span class="card-name">Hydro</span>
    </div>
  </div>

  <div class="card pyro">
    <img src="images/pyro.png" alt="pyro" class="card-element">
    <div class="card-info">
      <span class="card-count"> <?= Character::count_by_element('pyro') ?> </span>
      <span class="card-name">Pyro</span>
    </div>
  </div>

</div>
<?php require_once("includes/footer.php"); ?>
