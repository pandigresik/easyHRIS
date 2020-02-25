<?php

class User_model extends Base_model
{
    protected $_table = 'users';
    private $withRole = FALSE;
    protected $columnTableData = ['users.id as id', 'username', 'username as name', 'email', 'roles.role_name', 'users.status as status'];
    protected $headerTableData = [
        [ ['data' => 'Username'], ['data' => 'Nama'], ['data' => 'Email'], ['data' => 'Role / Peran'], ['data' => 'Status']],
    ];

    protected $before_get = array('joinRole');

    
    public function joinRole()
    {
        if($this->getWithRole()){
            $this->_database->join('user_roles', 'user_roles.user_id = users.id','left');
            $this->_database->join('roles', 'user_roles.role_id = roles.id','left');
        }
    }

    /**
     * Get the value of withRole
     */ 
    public function getWithRole()
    {
        return $this->withRole;
    }

    /**
     * Set the value of withRole
     *
     * @return  self
     */ 
    public function setWithRole($withRole)
    {
        $this->withRole = $withRole;
        return $this;
    }
}
