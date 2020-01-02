<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChaptersModel;
use Codbear\Alaska\Models\CommentsModel;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Services\Security;
use Exception;

class BookController extends Controller implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (isset($params['chapterId'])) {
            $chapterId = (int) $params['chapterId'];
            $chapter = ChaptersModel::get($chapterId);

            if (isset($params['action'])) {
                switch ($params['action']) {
                    case 'publishComment':
                        $userId = Session::get('user')['id'];
                        $commentContent = $datas['comment-content'];
                        $this->publishComment($chapter->id, $userId, $commentContent);
                        header('Location: /?view=book&chapterId=' . $chapter->id . '#comment-editor');
                        break;

                    case 'reportComment':
                        if (isset($params['commentId'])) {
                            $userId = Session::get('user')['id'];
                            $commentId = $params['commentId'];
                            $this->reportComment($commentId, $userId);
                            header('Location: /?view=book&chapterId=' . $chapter->id . '#comment-id-' . $commentId);
                        } else {
                            return $this->notFound();
                        }
                        break;

                    default:
                        return $this->notFound();
                        break;
                }
                exit;
            }

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
        } else {
            return $this->notFound();
        }
    }

    private function publishComment(int $chapterId, int $userId, string $commentContent)
    {
        try {
            if (empty($commentContent)) {
                throw new Exception('Impossible de publier un commentaire sans contenu');
            }

            $published = CommentsModel::publish((int) $chapterId, (int) $userId, Security::protectString($commentContent));
            
            if (!$published) {
                throw new Exception('Une erreur est survenue, merci de réessayer ultérieurement');
            }

            Session::setFlashbag('Votre commentaire a été publié', 'success');
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }

    private function reportComment(int $commentId, int $userId)
    {
        try {
            $reported = CommentsModel::report((int) $userId, (int) $commentId);
            
            if (!$reported) {
                throw new Exception('Une erreur est survenue, merci de réessayer ultérieurement');
            }

            Session::setFlashbag('Le commentaire a été signalé');
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }
}
