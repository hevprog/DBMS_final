<?php

class Login extends Database
{
    private $userName;
    private $password;

    //this is a constructor
    public function __construct($userName, $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }
}