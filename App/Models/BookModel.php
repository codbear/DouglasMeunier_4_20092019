<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Services\Database;

class BookModel
{
    const CHAPTER_STATUS_DRAFT = 1;
    const CHAPTER_STATUS_PUBLISHED = 2;
    const CHAPTER_STATUS_TRASH = 3;
    const CHAPTER_STATUS_DELETED = 4;
    const CHAPTER_STATUS_DEFAULT = self::CHAPTER_STATUS_DRAFT;

    public function getTableOfContent()
    {
        return Database::query('SELECT id, chapter_number, title, chapter_status, DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr FROM posts ORDER BY creation_date');
    }

    public function changeChapterStatus($chapterId, $newStatus)
    {
        return Database::prepare('UPDATE posts SET chapter_status = ? WHERE id = ?', [
            $newStatus,
            $chapterId
        ], false);
    }

    public function deleteChapterPermanently($chapterId)
    {
        return Database::prepare('DELETE FROM posts WHERE id = ?', [$chapterId], false);
    }

    public function getChapter(int $chapterId) {
        return Database::prepare('SELECT * FROM posts WHERE id = ?', [$chapterId]);
    }
}
