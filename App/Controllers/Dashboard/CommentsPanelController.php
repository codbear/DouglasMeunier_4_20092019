<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Models\Tables\CommentsTable;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;

class CommentsPanelController extends DashboardController implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'deleteComment':
                    if (isset($params['commentId'])) {
                        $this->deleteComment((int) $params['commentId']);
                    }
                    break;
                
                default:
                    return $this->notFound();
                    break;
            }
        }
        $comments = CommentsTable::getAll();
        $signaled = [];
        foreach ($comments as $comment) {
            $comment->setReporting(CommentsTable::getReporting($comment->id));
            if ($comment->reporting > 0) {
                $signaled[] = $comment;
            }
        }
        return $this->renderer->render('dashboard/commentsPanel', compact('comments', 'signaled'));
    }

    private function deleteComment(int $commentId) {
        try {
            if(!CommentsTable::delete($commentId)) {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.");
            }
            header('Location: /?view=commentsPanel');
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=commentsPanel');
        }
    }
}
