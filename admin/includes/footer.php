
<div class="modal" id="delete-modal">
    <div class="modal-content">
        <h5 class="black-text">Are you sure to delete?</h5>
    </div>
    <div class="modal-footer">
        <button class="red btn-small modal-close btnModalDelete">Delete</button>
        <button class="blue btn-small modal-close">Cancel</button>
    </div>
</div>

</main>
<script src="js/deleteModal.js"></script>
<script src="js/material-inits.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>

<?php 
    if(!empty($session->message) && count($session->message) > 0):
        foreach($session->message as $msg):
?>
    <script>
        M.toast({html: "<?= $msg ?>", classes: 'white rounded'})
    </script>
<?php
        endforeach;
    endif;
 ?>
</body>
</html>