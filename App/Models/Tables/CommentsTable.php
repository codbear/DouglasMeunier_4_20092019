<?php

namespace Codbear\Alaska\Models\Tables;

use Codbear\Alaska\Services\Database;
use PDOStatement;

abstract class CommentsTable
{
    public static function getAll(int $chapterId)
    {
        $statement = 'SELECT c.id, c.content, u.username AS author,
                        DATE_FORMAT(c.creation_date, \'%d.%m.%Y\') AS creation_date_fulltext
                        FROM comments AS c
                        INNER JOIN users AS u
                        ON u.id = c.user_id
                        WHERE c.chapter_id = ? 
                        ORDER BY c.creation_date DESC';
        $datas = [$chapterId];
        return Database::prepare($statement, $datas, Database::FETCH_ALL, 'Codbear\\Alaska\\Models\\Entity\\CommentEntity');
    }

    public static function publish(int $chapter_id, int $user_id, string $content): PDOStatement
    {
        $statement = 'INSERT INTO comments(chapter_id, user_id, content)
                        VALUES (:chapter_id, :user_id, :content)';
        $datas = compact('chapter_id', 'user_id', 'content');
        return Database::prepare($statement, $datas);
    }
}
