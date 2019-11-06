<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Services\Database;

class Model
{

    protected $_db;

    public function __construct()
    {
        $this->_db = new Database(dirname(dirname(__DIR__)) . '/config.json');
    }
}
