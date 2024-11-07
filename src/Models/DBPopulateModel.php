<?php

namespace App\Models;
use PDO;
class DBPopulateModel
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function postBooks($data)
    {
        
    }
}