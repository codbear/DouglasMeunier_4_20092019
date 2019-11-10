<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Services\Database;
use Codbear\Alaska\Services\Session;
use PDOStatement;

abstract class BookModel
{

    public static function getAllChapters(): array
    {
        $statement = 'SELECT id, number, number_save, title, content, excerpt, status, 
                        DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr 
                        FROM chapters 
                        ORDER BY creation_date';
        return Database::query($statement, Database::FETCH_ALL, 'Codbear\Alaska\Models\ChapterModel');
    }

    public static function createNewChapter(): ChapterModel
    {
        $chapterNumber = self::getMaxChapterNumber() + 1;
        $statement = 'INSERT INTO chapters(number, title, content) 
                        VALUES (:number, :title, :content)';
        $datas = [
            'number' => $chapterNumber,
            'title' => "",
            'content' => ""
        ];
        if (Database::prepare($statement, $datas, false)) {
            return ChapterModel::getChapter(self::getChapterIdWithChapterNumber($chapterNumber));
        }
    }

    public static function getMinChapterNumber(): int
    {
        $req = Database::query('SELECT MIN(number) AS min_number 
                                FROM chapters', Database::FETCH_SINGLE);
        return $req->min_number;
    }

    private static function getMaxChapterNumber(): int
    {
        $req = Database::query('SELECT MAX(number) AS max_number 
                                FROM chapters', Database::FETCH_SINGLE);
        if ($req->max_number <= 0) {
            return 0;
        }
        return $req->max_number;
    }

    private static function getChapterIdWithChapterNumber(int $chapterNumber): int
    {
        $req = Database::prepare('SELECT id FROM chapters WHERE number = :number', ['number' => (int) $chapterNumber], Database::FETCH_SINGLE);
        return $req->id;
    }
}
