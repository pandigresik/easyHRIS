<?php if (!empty($wilayah)) {
    echo $this->form_builder->open_form($form_header);
}
?>
<div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th><div class="col-md-12"><div class="checkbox col-md-4"><label><input onclick="App.checkAll(this)" type="checkbox"> Pilih Semua</label></div></div></th>
        </tr>
    </thead>
    <tbody>
    <?php 
        if (!empty($wilayah)) {
            foreach ($wilayah->chunk(3) as $splice) {
                echo '<tr>';
                echo '<td><div class="col-md-12">';

                foreach ($splice as $m) {
                    $checked_wilayah = isset($roleTeritori[$m->WLKODE]) ? 'checked' : '';
                    echo '<div class="col-md-4 checkbox"><label><input '.$checked_wilayah.' value="'.$m->WLKODE.'" name="wilayah_'.$m->WLKODE.'" type="checkbox" >'.$m['WLNAMA'].'</label></div>';
                }
                echo '</div></td>';
                echo '</tr>';
            }
        }
    ?>
    </tbody>
    </table>
</div>
<?php 
    if (!empty($wilayah)) {
        echo form_submit('simpan', 'simpan', ['class' => 'btn btn-success']);
        echo form_hidden('roles_id', $referenceId);

        echo $this->form_builder->close_form();
    }
?>