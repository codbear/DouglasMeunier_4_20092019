<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Models\ChapterModel;

class BookController
{ 
    public function execute(array $params, array $datas) {
        $tableOfContent = BookModel::getAllChaptersFromStatus(ChapterModel::STATUS_PUBLISHED);
        $chapter = ChapterModel::getChapter((int)$params['chapterId']);
        $title = $chapter->title . ' | Un billet pour l\'Alaska';
        require_once '../App/Views/book.php';
    }
}
