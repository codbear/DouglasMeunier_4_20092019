<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Models\DatabaseModel;

class BookModel extends DatabaseModel {

    public function getTableOfContent() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, chapter_number, title, DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr
                            FROM posts
                            ORDER BY creation_date');
        return $req;
    }
    
}