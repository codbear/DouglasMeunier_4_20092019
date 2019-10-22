<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Models\DatabaseModel;

class BookModel extends DatabaseModel {

    public function getTableOfContent() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr
                            FROM posts
                            ORDER BY creation_date');
        return $req;
    }
    
}