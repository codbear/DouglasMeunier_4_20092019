<?php

namespace Codbear\Alaska\Models\Tables;

use PDOStatement;
use Codbear\Alaska\Services\Database;
use Codbear\Alaska\Models\Entity\ChapterEntity;

class ChaptersTable
{
    const CHAPTER_ENTITY_CLASS = 'Codbear\\Alaska\\Models\\Entity\\ChapterEntity';
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_TRASH = 3;
    const STATUS_DELETED = 4;
    const STATUS_DEFAULT = self::STATUS_DRAFT;

    public static function getAll(): array
    {
        $statement = 'SELECT id, number, number_save, title, content, excerpt, status, 
                        DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr 
                        FROM chapters 
                        ORDER BY number';
        return Database::query($statement, Database::FETCH_ALL, self::CHAPTER_ENTITY_CLASS);
    }

    public static function get(int $id): ChapterEntity
    {
        $statement = 'SELECT id, number, number_save, title, content, excerpt, status, 
                        DATE_FORMAT(creation_date, \'%d/%m/%Y %H:%i:%s\') AS creation_date_fr
                        FROM chapters 
                        WHERE id = ?';
        return Database::prepare($statement, [$id], Database::FETCH_SINGLE, self::CHAPTER_ENTITY_CLASS);
    }

    public static function getWithNumber(int $number)
    {
        $statement = 'SELECT id, number, number_save, title, content, excerpt, status, 
                        DATE_FORMAT(creation_date, \'%d/%m/%Y %H:%i:%s\') AS creation_date_fr
                        FROM chapters 
                        WHERE number = ?';
        return Database::prepare($statement, [$number], Database::FETCH_SINGLE, self::CHAPTER_ENTITY_CLASS);
    }

    public static function setStatus(int $id, int $status): PDOStatement
    {
        $datas = [
            'id' => $id,
            'status' => $status
        ];
        if ($status === self::STATUS_TRASH || $status === self::STATUS_DELETED) {
            $statement = 'UPDATE chapters 
                        SET status = :status,
                        number = :number
                        WHERE id = :id';
            $datas['number']= self::getMinChapterNumber() - 1;
        } else {
            $statement = 'UPDATE chapters 
                            SET status = :status
                            WHERE id = :id';
        }
        return Database::prepare($statement, $datas, false);
    }

    public static function save(ChapterEntity $chapter): PDOStatement
    {
        $datas = [
            'number' => (int) $chapter->number,
            'number_save' => (int) $chapter->number,
            'title' => $chapter->title,
            'content' => $chapter->content,
            'excerpt' => $chapter->excerpt,
            'status' => (int) $chapter->status
        ];
        if (!isset($chapter->id)) {
            $statement = 'INSERT INTO chapters(number, number_save, title, content, excerpt, status)
                            VALUES (:number, :number_save, :title, :content, :excerpt, :status)';
        } else {
            $statement = 'UPDATE chapters 
                            SET number = :number,
                            number_save = :number_save, 
                            title = :title, 
                            content = :content, 
                            excerpt = :excerpt, 
                            status = :status
                            WHERE id = :id';
            $datas['id'] = (int) $chapter->id;
        }
        return Database::prepare($statement, $datas, false);
    }

    public static function getMaxChapterNumber(): int
    {
        $req = Database::query('SELECT MAX(number) AS max_number FROM chapters', Database::FETCH_SINGLE);
        if ($req->max_number < 0) {
            return 0;
        }
        return $req->max_number;
    }

    private static function getMinChapterNumber(): int
    {
        $req = Database::query('SELECT MIN(number) AS min_number FROM chapters', Database::FETCH_SINGLE);
        return $req->min_number;
    }
}
