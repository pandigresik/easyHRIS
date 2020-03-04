<?php if (!empty($actions)) {
    echo $this->form_builder->open_form($form_header);
}
?>
<?php echo isset($entry_form) ? $entry_form : '' ;?>
<div class="" id="divTableJadwal">
    <?php echo $table; ?>
</div>
<?php 
    if (!empty($actions)) {
        echo form_submit($actions['text'], $actions['text'], $actions['option']);
        echo $this->form_builder->close_form();
    }
?>