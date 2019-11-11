<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Models\ChapterModel;

class BookController
{ 
    public function execute(array $params, array $datas) {
        $tableOfContent = BookModel::getAllChapters();
        $enableCoverButton = false;
        if (ChapterModel::getChapter(1)->status == ChapterModel::STATUS_PUBLISHED) {
            $enableCoverButton = true;
        }
        if (isset($params['chapterId'])) {
            $chapter = ChapterModel::getChapter((int)$params['chapterId']);
            if (!$chapter || $chapter->status != ChapterModel::STATUS_PUBLISHED) {
                ErrorsController::error404();
                exit();
            }
            $title = $chapter->title . ' | Un billet pour l\'Alaska';
        } else {
            $chapter = null;
            $title = 'Un billet pour l\'Alaska';
        }
        require_once '../App/Views/book.php';
    }
}
