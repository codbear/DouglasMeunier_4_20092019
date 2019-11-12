<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Models\BookModel;
use Codbear\Alaska\Models\ChapterModel;

class BookController extends Controller implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (ChapterModel::getChapter(1)->status == ChapterModel::STATUS_PUBLISHED) {
            $enableCoverButton = true;
        } else {
            $enableCoverButton = false;
        }
        if (isset($params['chapterId'])) {
            $chapter = ChapterModel::getChapter((int) $params['chapterId']);
            if (!$chapter || $chapter->status != ChapterModel::STATUS_PUBLISHED) {
                ErrorsController::error404();
                exit();
            }
            //$title = $chapter->title . ' | Un billet pour l\'Alaska';
            $this->renderer->addGlobal('title', $chapter->title . ' | Un billet pour l\'Alaska');
            //TODO : render @book/chapter
        } else {
            //TODO : render @book/cover
            $chapter = null;
            //$title = 'Un billet pour l\'Alaska';
        }
        return $this->renderer->render('book', [
            'tableOfContent' => BookModel::getAllChapters(),
            'chapter' => $chapter,
            'enableCoverButton' => $enableCoverButton
        ]);
    }
}
