<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $active;
    private $role;

    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__ . '\WorkTime', 'user_id', array(
            'alias' => 'workTime',
            'reusable' => true
        ));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

}