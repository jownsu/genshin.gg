<?php require_once("Class/init.php"); ?>
<?php 

if(!$session->is_signed_in()){
    header("location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin</title>
</head>
<body class="blue-grey darken-4 white-text">
    <header>
            <nav class="nav-wrapper blue-grey darken-3 hide-on-large-only">
                    <a href="#" class="brand-logo hide-on-large-only">
                        <img class="genshin-logo" src="images/genshin-logo.svg" alt="logo">
                        <span class="brand-name">GENSHIN.GG</span>
                    </a>
                    <a href="#" class="sidenav-trigger" data-target="mobile-links">
                        <i class="material-icons">menu</i>
                    </a>   
                </div>
            </nav>
    </header>
    <ul id="mobile-links" class="sidenav sidenav-fixed blue-grey darken-3 z-depth-0">
        <li class="sidenav-brand"><a href="../index.php"><img class="genshin-logo" src="images/genshin-logo.svg" alt="logo"><span class="brand-name">GENSHIN.GG</span></a></li>
        <li><a href="index.php"><i class="material-icons white-text">assessment</i>Dashboard</a></li>
        <li><a href="characters.php"><i class="material-icons white-text">portrait</i>Character</a></li>
        <li><a href="my_posts.php"><i class="material-icons white-text">add_to_photos</i>My Posts</a></li>

        <?php if($session->role == 'Admin'): ?>
        <?php $inactive_count = User::count_inactive(); ?>
            <li><a href="all_posts.php"><i class="material-icons white-text">add_to_photos</i> All Posts</a></li>
            <li><a href="users.php"><i class="material-icons white-text <?= $inactive_count != 0 ? 'notif' : ''?>">account_box</i>User</a></li>
        <?php endif ?>

        <li><a href="account-settings.php?id=<?= $session->id ?>"><i class="material-icons white-text">settings</i>Account Settings</a></li>
        <li><a href="logout.php" class="logout"><i class="material-icons red-text">exit_to_app</i>Logout</a></li>
    </ul>
<main>


