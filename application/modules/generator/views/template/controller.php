<?php
$text = <<<HTML
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada {$created_at}
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class {$controller} extends MY_Controller {
    public \$title = '{$title}';

    function __construct(){
        parent::__construct();
        \$this->load->model('{$model}','{$alias}');
        \$this->model = \$this->{$alias};
    }
}

HTML;

echo $text;
?>

