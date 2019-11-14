<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Models\ChapterModel;

class BookController extends Controller implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (isset($params['chapterId'])) {
            $chapter = ChapterModel::getChapter((int) $params['chapterId']);
            if (!$chapter || $chapter->status != ChapterModel::STATUS_PUBLISHED) {
                return $this->notFound();
            }
        return $this->renderer->render('book', [
            'title' => $chapter->title . ' | Billet simple pour l\'Alaska',
            'chapter' => $chapter,
        ]);
        } else {
            return $this->notFound();
        }
    }
}
