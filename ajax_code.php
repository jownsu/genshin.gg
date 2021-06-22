<?php

include_once('admin/includes/Class/init.php');


if(isset($_POST['comment'])){
    if($session->is_signed_in()){

        if(empty($_POST['comment'])){
            exit(false);
        }

        $comment = new Comment();
        $comment->description = trim($_POST['comment']);
        $comment->user_id = trim($_POST['author']);
        $comment->date = date('F d, Y H:i:s');
        $comment->post_id = $_POST['postId'];
        if($comment->create()){
            exit("<div class='comment'>
                    <img src='admin" . DS . $session->image_path . "' alt='" . $comment->username . "'>
                    <div class='comment-details'>
                    <p class='c-name'>" . $session->username . "</p>
                    <p>" . $comment->date . "</p>
                    <p>" . $comment->description . "</p>
                </div>
            </div>");
        }else{
            exit("<p class='red-text'>There is an Error Adding A comment</p>");
        }
    }else{
        exit("login");
    }
}

// if(isset($_POST['charId'])){
//     $character = Character::find($_POST['charId']);
//     exit("
//     <div class='modal-content'>
//     <div class='row'>
//         <div class='col l4 m12 s12 center-align'>
//             <img src='" . $character->Portrait() . "' alt='" . $character->name . "' class='character-modal-portrait'>
//         </div>

//         <div class='col l6 m12 s12 offset-l2 center-align'>
//             <div class='row'>
//                 <div class='col s12'>
//                     <h1 class='modal-charName' id='name'>" . $character->name . "</h1>
//                     <h5 class='modal-charNickname' id='nickname'>" . $character->nickname . "</h5>
//                 </div>
//                 <div class='common-info'>
//                     <div class='col s4 rarity'>
//                         <p>Rarity</p>
//                         <img src='admin/images/" . $character->rarity . ".png' alt='" . $character->rarity . "' id='rarity'>
//                     </div>
//                     <div class='col s4 weapon'>
//                         <p>Weapon</p>
//                         <img src='admin/images/Weapons/" . $character->weapon . ".png' alt='" . $character->weapon . "' id='weapon'>
//                     </div>
//                     <div class='col s4 element'>
//                         <p>Element</p>
//                         <img src='admin/images/Elements/" . $character->element . ".png' alt='" . $character->element . "' id='element'>
//                     </div>
//                 </div>

//                 <div class='col s12 main-info'>
//                     <table>
//                         <tr>
//                             <th>Sex</th>
//                             <td>" . $character->sex . "</td>
//                         </tr>
//                         <tr>
//                             <th>Birthday</th>
//                             <td>" . $character->birthday . "</td>
//                         </tr>
//                         <tr>
//                             <th>Constellation</th>
//                             <td>" . $character->constellation . "</td>
//                         </tr>
//                         <tr>
//                             <th>Nation</th>
//                             <td>" . $character->nation . "</td>
//                         </tr>
//                         <tr>
//                             <th>Affiliation</th>
//                             <td>" . $character->affiliation . "</td>
//                         </tr>
//                         <tr>
//                             <th>Release Date</th>
//                             <td id='release_date'>" . $character->release_date . "</td>
//                         </tr>
//                     </table>
//                 </div>
//             </div>
//         </div>
//     </div>
// </div><!-- end of modal content -->
//     ");
// }

if(isset($_POST['submit-login'])){

}