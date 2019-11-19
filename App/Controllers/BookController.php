<?php

namespace Codbear\Alaska\Controllers;

use PDOStatement;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\Tables\CommentsTable;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Models\Tables\ChaptersTable;

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

            $chapter = ChaptersTable::get($chapterId);

            if (!$chapter || $chapter->status != ChaptersTable::STATUS_PUBLISHED) {
                return $this->notFound();
            }

            $comments = CommentsTable::getAllWithChapterId($chapterId);

            foreach ($comments as $comment) {
                $reportedBy = CommentsTable::getReportsList($comment->id);
                foreach ($reportedBy as $k => $v) {
                    if (Session::get('user')['id'] === (int) $v->user_id) {
                        $comment->setReported();
                    }
                }
            }

            return $this->renderer->render('book', [
                'title' => $chapter->title . ' | Billet simple pour l\'Alaska',
                'chapter' => $chapter,
                'comments' => $comments
            ]);
        } elseif (isset($params['action'])) {
            switch ($params['action']) {
                case 'reportComment':
                    if (isset($params['commentId'])) {
                        $this->reportComment($params['commentId']);
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        } else {
            return $this->notFound();
        }
    }

    private function publishComment(int $chapterId, int $userId, string $commentContent): PDOStatement
    {
        return CommentsTable::publish((int) $chapterId, (int) $userId, (string) $commentContent);
    }

    private function reportComment(int $commentId) {
        $userId = Session::get('user')['id'];
        return CommentsTable::report((int) $userId, (int) $commentId);
    }
}
