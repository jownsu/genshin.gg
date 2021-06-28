<header>
        <nav class="nav-wrapper blue-grey darken-3">
            <div class="container">
                <a href="index.php" class="brand-logo"><img class="genshin-logo" src="admin/images/genshin-logo.svg" alt="logo"><span>GENSHIN.GG</span></a>
                <a href="#" class="sidenav-trigger" data-target="mobile-links">
                    <i class="material-icons">menu</i>
                </a>   
                <ul class="right hide-on-med-and-down">
                    <li><a href="characters.php" class="<?= $navActive == 'characters' ? 'active' : '' ?>">Character</a></li>
                    <li><a href="tierlist.php" class="<?= $navActive == 'tierlist' ? 'active' : '' ?>">Tier List</a></li>
                    <li><a href="weapons.php" class="<?= $navActive == 'weapons' ? 'active' : '' ?>">Weapon</a></li>
                    <li><a href="artifacts.php" class="<?= $navActive == 'artifacts' ? 'active' : '' ?>">Artifact</a></li>
                    <li><a href="alchemy.php" class="<?= $navActive == 'alchemies' ? 'active' : '' ?>">Alchemy</a></li>
                    <li><a href="foods.php" class="<?= $navActive == 'foods' ? 'active' : '' ?>">Food</a></li>
                    <?php if(!$session->is_signed_in()): ?>
                        <li><a href="#login_modal" class="modal-trigger">Login</a></li>
                    <?php else: ?>
                        <li><a href="admin/index.php" class="modal-trigger"><?= $session->username ?></a></li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>

        <ul class="sidenav blue-grey darken-3 z-depth-1 blue-text" id="mobile-links">
            <li><a href="characters.php">Character</a></li>
            <li><a href="tierlist.php">Tier List</a></li>
            <li><a href="weapons.php">Weapon</a></li>
            <li><a href="artifact.php">Artifact</a></li>
            <li><a href="alchemy.php">Alchemy</a></li>
            <li><a href="foods.php">Food</a></li>
        </ul>
    </header>