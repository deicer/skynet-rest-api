<?php

namespace App\Models;

use App\Db;

abstract class Model
{
    protected \PDO $db;

    /**
     * Model constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->db = Db::get()->connection;
    }
}
