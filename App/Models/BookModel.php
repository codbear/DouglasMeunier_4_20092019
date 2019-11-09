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
        return Database::query('SELECT id, chapter_number, prev_chapter_number, title, excerpt, chapter_status, 
                                DATE_FORMAT(creation_date, \'%d/%m/%Y - %H:%i:%s\') AS creation_date_fr 
                                FROM posts 
                                ORDER BY creation_date', Database::FETCH_ALL);
    }

    public function getChapter(int $chapterId)
    {
        return Database::prepare('SELECT id, chapter_number, prev_chapter_number, title, content, excerpt, chapter_status, 
                                    DATE_FORMAT(creation_date, \'%d/%m/%Y %H:%i:%s\') AS creation_date_fr
                                    FROM posts 
                                    WHERE id = ?', [$chapterId]);
    }

    public function getLastChapterId()
    {
        $req = Database::query('SELECT MAX(id) AS last_chapter_id 
                                FROM posts', Database::FETCH_SINGLE);
        return $req->last_chapter_id;
    }

    public function getChapterStatus(int $chapterId)
    {
        $req = Database::prepare('SELECT chapter_status
                                FROM posts
                                WHERE id = :id', [
            'id' => $chapterId
        ]);
        return $req->chapter_status;
    }

    public function createNewChapter()
    {
        return Database::prepare('INSERT INTO posts(chapter_number, title, content) 
                                    VALUES (?, ?, ?)', [
            $this->getMaxChapterNumber() + 1,
            "",
            "",
        ], false);
    }

    public function saveChapter(int $chapterId, string $chapterTitle, int $chapterNumber, string $chapterContent, string $chapterExcerpt, int $chapterStatus)
    {
        return Database::prepare('UPDATE posts 
                                    SET chapter_number = :new_chapter_number, 
                                        title = :new_title, 
                                        content = :new_content, 
                                        excerpt = :new_excerpt, 
                                        chapter_status = :new_chapter_status
                                    WHERE id = :id', [
            'new_chapter_number' => $chapterNumber,
            'new_title' => $chapterTitle,
            'new_content' => $chapterContent,
            'new_excerpt' => $chapterExcerpt,
            'new_chapter_status' => $chapterStatus,
            'id' => $chapterId
        ], false);
    }

    public function changeChapterStatus(int $chapterId, int $newStatus)
    {
        if ($newStatus === self::CHAPTER_STATUS_TRASH || $newStatus === self::CHAPTER_STATUS_DELETED) {
            if ($newStatus === self::CHAPTER_STATUS_TRASH) {
                $this->setPrevChapterNumber($chapterId);
            }
            if (!$this->setNegativeChapterNumber($chapterId)) {
                return false;
            }
        }
        return Database::prepare('UPDATE posts 
                                    SET chapter_status = ? 
                                    WHERE id = ?', [
            $newStatus,
            $chapterId
        ], false);
    }

    private function setNegativeChapterNumber(int $chapterId)
    {
        return Database::prepare('UPDATE posts 
                                    SET chapter_number = :new_chapter_number 
                                    WHERE id = :id', [
            'new_chapter_number' => $this->getMinChapterNumber() - 1,
            'id' => $chapterId
        ], false);
    }

    private function getMaxChapterNumber()
    {
        $req = Database::query('SELECT MAX(chapter_number) AS max_chapter_number 
                                FROM posts', Database::FETCH_SINGLE);
        return $req->max_chapter_number;
    }

    private function getMinChapterNumber()
    {
        $req = Database::query('SELECT MIN(chapter_number) AS min_chapter_number 
                                FROM posts', Database::FETCH_SINGLE);
        return $req->min_chapter_number;
    }

    private function setPrevChapterNumber(int $chapterId)
    {
        return Database::prepare('UPDATE posts 
                                    SET prev_chapter_number = :chapter_number 
                                    WHERE id = :id', [
            'chapter_number' => $this->getChapterNumber($chapterId),
            'id' => $chapterId
        ], false);
    }

    private function getChapterNumber(int $chapterId): int
    {
        $req = Database::query('SELECT chapter_number 
                                FROM posts 
                                WHERE id = ' . $chapterId . '', Database::FETCH_SINGLE);
        return $req->chapter_number;
    }
}
