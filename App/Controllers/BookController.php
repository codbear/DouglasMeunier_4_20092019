<?php

namespace Codbear\Alaska\Controllers;

use PDOStatement;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChaptersModel;
use Codbear\Alaska\Models\CommentsModel;
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
                exit;
            }
            
            $chapter = ChaptersModel::get($chapterId);
            
            if (!$chapter || $chapter->status != ChaptersModel::STATUS_PUBLISHED) {
                return $this->notFound();
            }
            
            $comments = CommentsModel::getAllWithChapterId($chapterId);
            
            foreach ($comments as $comment) {
                $reportedBy = CommentsModel::getReportsList($comment->id);
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

    private function publishComment(int $chapterId, int $userId, string $commentContent)
    {
        if(CommentsModel::publish((int) $chapterId, (int) $userId, self::protectString($commentContent))) {
            Session::setFlashbag('Votre commentaire a été publié', 'success');
        } else {
            Session::setFlashbag('Une erreur est survenue, merci de réessayer plus tard', 'error');
        }
    }

    private function reportComment(int $commentId) {
        $userId = Session::get('user')['id'];
        return CommentsModel::report((int) $userId, (int) $commentId);
    }
}
