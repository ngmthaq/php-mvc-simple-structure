<?php

abstract class Model
{
    protected $name;
    protected $db;

    public function __construct()
    {
        $_dbHost = DB_HOST;
        $_dbPort = DB_PORT;
        $_dbName = DB_NAME;
        $_dbUsername = DB_USERNAME;
        $_dbPassword = DB_PASSWORD;

        $this->name = $this->setName();
        $this->db = new PDO("mysql:host=$_dbHost;dbname=$_dbName;port=$_dbPort", $_dbUsername, $_dbPassword);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    abstract public function setName();

    final public function getter($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    final public function all()
    {
        $stm = $this->db->prepare("SELECT * FROM " . $this->name);
        $stm->execute();

        return $stm->fetchAll();
    }

    final public function first()
    {
        $stm = $this->db->prepare("SELECT * FROM " . $this->name . " LIMIT 1");
        $stm->execute();

        return $stm->fetch();
    }

    final public function last()
    {
        $stm = $this->db->prepare("SELECT * FROM " . $this->name . " ORDER BY id DESC LIMIT 1");
        $stm->execute();

        return $stm->fetch();
    }

    final public function insert()
    {
        //
    }

    final public function update()
    {
        //
    }

    final public function delete()
    {
        //
    }
}
