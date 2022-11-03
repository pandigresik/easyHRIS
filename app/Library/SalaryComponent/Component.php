<?php
namespace App\Library\SalaryComponent;
abstract class Component {
    protected $code;
    protected $fixed;
    protected $state;

    abstract function calculate();
}