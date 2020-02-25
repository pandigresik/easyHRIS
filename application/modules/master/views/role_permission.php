<?php if(!empty($menus)){
    echo $this->form_builder->open_form($form_header);
}    
?>
<div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th><input onclick="App.checkAll(this)" type="checkbox"></th>
            <th>Nama</th>
            <th>Route</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        if(!empty($menus)){
            foreach($menus as $m){
                $checked_menu = isset($rolemenus[$m['id']]) ? 'checked' : '';
                echo '<tr>
                    <td><input '.$checked_menu.' value="'.$m['id'].'" name="menu_'.$m['id'].'" type="checkbox" class="menu" data-menu_id="'.$m['id'].'"></td>
                    <td>'.$m['name'].'</td>
                    <td>'.$m['route'].'</td>
                    <td>'.$m['descriptions'].'</td>
                </tr>';
                if(!empty($m['permissions'])){
                    foreach($m['permissions'] as $mp){
                        $checked_permission = isset($rolePermissions[$mp['id']]) ? 'checked' : '';
                        echo '<tr>
                            <td><input '.$checked_permission.' onclick="App.setDependency(this)" value="'.$mp['id'].'" name="permissions_'.$mp['id'].'" type="checkbox" class="permissions" data-dependency=\''.json_encode(['menu_id' => $mp['menus_id']]).'\'></td>
                            <td style="padding-left:30px">'.$mp['name'].'</td>
                            <td>'.$mp['route'].'</td>
                            <td></td>
                        </tr>';
                    }    
                }
            }
        }
    ?>
    </tbody>
    </table>
</div>
<?php 
    if(!empty($menus)){
        echo form_submit('simpan', 'simpan',['class' => 'btn btn-success']);
        echo form_hidden('roles_id', $referenceId);
        
        echo $this->form_builder->close_form();
    }
?>