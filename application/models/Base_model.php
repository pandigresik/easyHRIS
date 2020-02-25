<?php
/** Generate by crud generator model pada 2020-02-19 08:45:04

*   Author afandi
*/

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Base_model extends MY_Model{
    protected $searchLookupColumn = 'name';
    protected $before_create = array('created_at','updated_at','generate_uuid');    
    protected $before_update = array('updated_at');    

    public function __construct(){
        parent::__construct();        
    }

    /**
     * Get the value of searchLookupColumn
     */ 
    public function getSearchLookupColumn()
    {
        return $this->searchLookupColumn;
    }

    /**
     * Set the value of searchLookupColumn
     *
     * @return  self
     */ 
    public function setSearchLookupColumn($searchLookupColumn)
    {
        $this->searchLookupColumn = $searchLookupColumn;

        return $this;
    }

    public function generate_uuid($row){
        $uuid = Uuid::uuid4()->toString();
        if (is_object($row)) {
            $row->id = $uuid;
        } else {
            $row['id'] = $uuid;
        }
        return $row;
    }
}
?>