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
                    <li><a href="map.php" class="<?= $navActive == 'map' ? 'active' : '' ?>">Map</a></li>
                    <?php if(!$session->is_signed_in()): ?>
                        <li><a href="#login_modal" class="modal-trigger">Login</a></li>
                    <?php else: ?>
                        <li><a href="admin/index.php" class="modal-trigger"><?= $session->username ?></a></li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>

        <ul class="sidenav" id="mobile-links">
            <li><a href="#">Character</a></li>
            <li><a href="#">Teams</a></li>
            <li><a href="#">Tier List</a></li>
            <li><a href="#">Map</a></li>
            <li><a href="#">Farm Guide</a></li>
        </ul>
    </header>