<?php 
$text = <<<HTML
<?php
/** Generate by crud generator model pada {$created_at}
*   Author afandi
*/
class {$namaModel} extends Base_model{
    protected \$_table = '{$namaTable}';
    
    protected \$primary_key = '{$primaryKey}';
    protected \$columnTableData = [{$heading}];
    protected \$headerTableData = [{$headerTable}];

    protected \$form = [{$formElement}];

    /** uncomment function ini untuk memberikan nilai default form,
      * misalkan mengisi data pilihan dropdown dari database dll
    protected function setOptionDataForm(\$where = array()){
        \$parentMenu = \$this->active()->get(['id','name'])->lists('name','id');
        \$parentMenu[0] = 'Menu Utama';
        ksort(\$parentMenu);
        \$this->form['parent_id']['options'] = \$parentMenu;
    }
    */
}
?>
HTML;
echo $text;
?>