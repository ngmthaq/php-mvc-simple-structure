<?php

importModel();

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setName()
    {
        return "users";
    }
}
