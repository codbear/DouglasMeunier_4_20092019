<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Services\Database;
use PDOStatement;

abstract class CommentsModel
{
    const VIEW_MODEL = 'Codbear\\Alaska\\Models\\ViewModels\\CommentViewModel';

    public static function getAll() {
        $statement = 'SELECT c.id, c.content, c.deleted, u.username AS author, ch.number AS chapter_number, DATE_FORMAT(c.creation_date, \'%d.%m.%Y\') AS creation_date_fr
                        FROM comments AS c
                        INNER JOIN users AS u
                        ON u.id = c.author
                        INNER JOIN chapters AS ch
                        ON c.chapter_id = ch.id
                        WHERE deleted = 0
                        ORDER BY c.creation_date DESC';
        return Database::query($statement, Database::FETCH_ALL, self::VIEW_MODEL);
    }

    public static function getReporting(int $commentId) {
        $statement = 'SELECT COUNT(user_id) AS reporting
                        FROM reporting
                        WHERE comment_id = ?';
        $response = Database::prepare($statement, [$commentId], Database::FETCH_SINGLE);
        return $response->reporting;
    }

    public static function getAllWithChapterId(int $chapterId)
    {
        $statement = 'SELECT c.id, c.chapter_id, c.content, u.username AS author,
                        DATE_FORMAT(c.creation_date, \'%d.%m.%Y\') AS creation_date_fulltext
                        FROM comments AS c
                        INNER JOIN users AS u
                        ON u.id = c.author
                        WHERE c.deleted = 0 AND c.chapter_id = ? 
                        ORDER BY c.creation_date DESC';
        $datas = [$chapterId];
        return Database::prepare($statement, $datas, Database::FETCH_ALL, self::VIEW_MODEL);
    }

    public static function publish(int $chapter_id, int $user_id, string $content): PDOStatement
    {
        $statement = 'INSERT INTO comments(chapter_id, author, content)
                        VALUES (:chapter_id, :user_id, :content)';
        $datas = compact('chapter_id', 'user_id', 'content');
        return Database::prepare($statement, $datas);
    }

    public static function delete(int $commentId) {
        $statement = 'UPDATE comments
                        SET deleted = 1
                        WHERE id = ?';
        return Database::prepare($statement, [$commentId]);
    }

    public static function validate(int $comment_id) {
        $statement = 'DELETE FROM reporting WHERE comment_id = ?';
        return Database::prepare($statement, [$comment_id]);
    }

    public static function report(int $user_id, int $comment_id) {
        $statement = 'INSERT INTO reporting(user_id, comment_id)
                        VALUES (:user_id, :comment_id)';
        $datas = compact('user_id', 'comment_id');
        return Database::prepare($statement, $datas);
    }

    public static function getReportsList(int $comment_id) {
        $statement = 'SELECT user_id
                        FROM reporting
                        WHERE comment_id = ?';
        return Database::prepare($statement, [$comment_id], Database::FETCH_ALL);
    }
}
