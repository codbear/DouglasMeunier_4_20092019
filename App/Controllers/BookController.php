<?php

namespace Codbear\Alaska\Controllers;

use PDOStatement;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChapterModel;
use Codbear\Alaska\Models\Tables\CommentsTable;
use Codbear\Alaska\Interfaces\ControllerInterface;

class BookController extends Controller implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (isset($params['chapterId'])) {
            $chapterId = (int) $params['chapterId'];
            if (isset($params['action']) && $params['action'] === 'publishComment') {
                $this->publishComment($chapterId, Session::get('user')['id'], $datas['comment-content']);
                header('Location: /?view=book&chapterId=' . $chapterId);
            }
            $chapter = ChapterModel::getChapter($chapterId);
            if (!$chapter || $chapter->status != ChapterModel::STATUS_PUBLISHED) {
                return $this->notFound();
            }
            $comments = CommentsTable::getAll($chapterId);
            return $this->renderer->render('book', [
                'title' => $chapter->title . ' | Billet simple pour l\'Alaska',
                'chapter' => $chapter,
                'comments' => $comments
            ]);
        } else {
            return $this->notFound();
        }
    }

    private function publishComment(int $chapterId, int $userId, string $commentContent): PDOStatement
    {
        return CommentsTable::publish((int) $chapterId, (int) $userId, (string) $commentContent);
    }
}
