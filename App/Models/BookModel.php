<?php

namespace Codbear\Alaska\Models;

class BookModel extends Model
{
    const CHAPTER_STATUS_DRAFT = 1;
    const CHAPTER_STATUS_PUBLISHED = 2;
    const CHAPTER_STATUS_TRASH = 3;
    const CHAPTER_STATUS_DEFAULT = self::CHAPTER_STATUS_DRAFT;

    public function getTableOfContent()
    {
        $req = $this->_db->query('SELECT id, chapter_number, title, chapter_status, DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr FROM posts ORDER BY creation_date');
        return $req;
    }

    public function changeChapterStatus($chapterId, $newStatus)
    {
        return $response = $this->_db->prepare('UPDATE posts SET chapter_status = ? WHERE id = ?', [
            $newStatus,
            $chapterId
        ], false);
    }

    public function deleteChapterPermanently($chapterId)
    {
        return $response = $this->_db->prepare('DELETE FROM posts WHERE id = ?', [$chapterId], false);
    }
}
