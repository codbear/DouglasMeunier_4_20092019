<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Models\DatabaseModel;

class BookModel extends DatabaseModel
{

    const CHAPTER_STATUS_DRAFT = 1;
    const CHAPTER_STATUS_PUBLISHED = 2;
    const CHAPTER_STATUS_TRASH = 3;
    const CHAPTER_STATUS_DEFAULT = self::CHAPTER_STATUS_DRAFT;

    public function getTableOfContent()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, chapter_number, title, chapter_status, DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr
                            FROM posts
                            ORDER BY creation_date');
        return $req;
    }

    public function changeChapterStatus($chapterId, $newStatus)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts
                                SET chapter_status = ?
                                WHERE id = ?');
        return $req->execute(array($newStatus, $chapterId));
    }

    public function deleteChapterPermanently($chapterId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts
                                WHERE id = ?');
        return $req->execute(array($chapterId));
    }
}
