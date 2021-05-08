<?php require_once("includes/header.php"); ?>

<?php 
$navActive = "teams";
require_once("includes/navigation.php"); ?>

    <main>
        <?php
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
        ?>
    
    </main>
    
<?php require_once("includes/footer.php"); ?>

 