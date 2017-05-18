<?php

namespace ETM\AppBundle\Types;

class Security extends BaseType
{

    protected $Username;
    protected $Password;
    protected $HashKey;

    public function __construct($username, $password, $hashkey)
    {
        $this->Username = $username;
        $this->Password = $password;
        $this->HashKey = $hashkey;
    }

}