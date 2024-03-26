<?php

namespace App\Controller;

class BaseController
{
    //databse connection
    protected $db;

    private $host;
    private $database;
    private $username;
    private $password;
    private $port;



    public function __construct()
    {

        $settings = require __DIR__ . '/../../src/settings.php';
        $settings = $settings['settings']['db'];

        $this->host = $settings['host'];
        $this->database = $settings['database'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->port = $settings['port'];


        //connect db with settings..




        //connect db..
        $this->db = new \PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

    }

}