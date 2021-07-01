<?php


define("RARITY", ['4 Star', '5 Star']);
define("SEX", ['Male', 'Female']);
define("WEAPONS", ['Bow', 'Catalyst', 'Claymore', 'Polearm', 'Sword']);
define("ELEMENTS", ['Anemo', 'Cryo', 'Dendro', 'Electro', 'Geo', 'Hydro', 'Pyro']);
define("TAGS", ['Guides', 'Tips', 'Wallpaper', 'Fanart']);
define("POST_STATUS", ['Published', 'Draft']);
define("TIERS", ['S', 'A', 'B', 'C', 'D']);

define("MONTHS", ['January', 'February', 'March', 'April', 'May', 'June',
                 'July', 'August', 'September', 'October', 'November', 'December']);
define("DAYS", [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]);
define("YEARS", [2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030]);

$current_year = date("Y");
$b_years = array();
for ($i=$current_year; $i >= $current_year-100 ; $i--) { 
    $b_years[] = $i;
}

define("B_YEARS", $b_years);

define("SECURTY_QUESTIONS", ["What's your favorite color?", "Who's your first love?",
                             "What's the title of your favorite song?", "Your Secret word"]);

define("WEAPON_LOCATIONS", ['Chest', 'Crafting', 'BP Bounty', 'Gacha', 'Starglitter Exchange', 'Event']);

define("CONSUMABLE_TYPES" , ['Potion', 'Oil', 'Stats Boost', 'Heal Food', 'Revive Food', 'Stamina Food']);

function get_all_thumbnails(){
    return glob("images" . DS . "Characters" . DS . "*.{png,jpg}", GLOB_BRACE);
}

function get_all_portraits(){
    return glob("images" . DS . "Portraits" . DS . "*.{png,jpg}", GLOB_BRACE);
}

function get_all_user_images(){
    return glob("images" . DS . "Users" . DS . "*.{png,jpg}", GLOB_BRACE);
}
