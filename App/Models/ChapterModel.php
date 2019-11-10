<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Services\Database;
use PDOStatement;

class ChapterModel
{

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_TRASH = 3;
    const STATUS_DELETED = 4;
    const STATUS_DEFAULT = self::STATUS_DRAFT;

    public static function getChapter(int $chapterId): ChapterModel
    {
        $statement = 'SELECT id, number, number_save, title, content, excerpt, status, 
                        DATE_FORMAT(creation_date, \'%d/%m/%Y %H:%i:%s\') AS creation_date_fr
                        FROM chapters 
                        WHERE id = :id';
        $datas = ['id' => (int) $chapterId];
        return Database::prepare($statement, $datas, Database::FETCH_SINGLE, __CLASS__);
    }

    public static function setStatus(int $chapterId, int $chapterStatus): PDOStatement
    {
        if ($chapterStatus === ChapterModel::STATUS_TRASH || $chapterStatus === ChapterModel::STATUS_DELETED) {
            $statement = 'UPDATE chapters 
                        SET status = :new_status,
                        number = :new_number
                        WHERE id = :id';
            $datas = [
                'new_status' => $chapterStatus,
                'new_number' => BookModel::getMinChapterNumber() - 1,
                'id' => (int) $chapterId
            ];
        } else {
            $statement = 'UPDATE chapters 
                            SET status = :new_status
                            WHERE id = :id';
            $datas = [
                'new_status' => $chapterStatus,
                'id' => (int) $chapterId
            ];
        }
        return Database::prepare($statement, $datas, false);
    }

    public static function save(int $chapterId, string $chapterTitle, int $chapterNumber, string $chapterContent, string $chapterExcerpt, int $chapterStatus): PDOStatement
    {
        $statement = 'UPDATE chapters 
                        SET number = :new_number,
                        number_save = :new_number_save, 
                        title = :new_title, 
                        content = :new_content, 
                        excerpt = :new_excerpt, 
                        status = :new_status
                        WHERE id = :id';
        $datas = [
            'new_number' => (int) $chapterNumber,
            'new_number_save' => (int) $chapterNumber,
            'new_title' => $chapterTitle,
            'new_content' => $chapterContent,
            'new_excerpt' => $chapterExcerpt,
            'new_status' => (int) $chapterStatus,
            'id' => (int) $chapterId
        ];
        return Database::prepare($statement, $datas, false);
    }

    public function __get(string $attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    public function getUrl(): string
    {
        return '/?view=book&chapterId=' . $this->id;
    }

    public function getEditorUrl(): string
    {
        return '/?view=chapterEditor&chapterId=' . $this->id;
    }

    public function getPreviousChapterUrl()
    {
        $previousChapterId = BookModel::getChapterIdWithChapterNumber($this->number - 1);
        if ($previousChapterId) {
            return "?view=book&chapterId=" . $previousChapterId . "";
        }
    }

    public function getNextChapterUrl()
    {
        $nextChapterId = BookModel::getChapterIdWithChapterNumber($this->number + 1);
        if ($nextChapterId) {
            return "?view=book&chapterId=" . $nextChapterId . "";
        }
    }
}
