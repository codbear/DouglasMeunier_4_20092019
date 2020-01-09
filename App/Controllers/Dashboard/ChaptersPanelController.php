<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChaptersModel;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;

class ChaptersPanelController extends DashboardController implements ControllerInterface
{
    private $published = [];
    private $drafts = [];
    private $trash = [];

    public function execute(array $params, array $datas)
    {
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'moveChapterToTrash':
                    $this->changeChapterStatus($params['chapterId'], ChaptersModel::STATUS_TRASH);
                    break;

                case 'restoreChapterFromTrash':
                    $this->changeChapterStatus($params['chapterId'], ChaptersModel::STATUS_DRAFT);
                    break;

                case 'deleteChapterPermanently':
                    $this->changeChapterStatus($params['chapterId'], ChaptersModel::STATUS_DELETED);
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        } else {
            foreach (ChaptersModel::getAll() as $chapter) {
                switch ($chapter->status) {
                    case ChaptersModel::STATUS_PUBLISHED:
                        $this->published[] = $chapter;
                        break;

                    case ChaptersModel::STATUS_TRASH:
                        $this->trash[] = $chapter;
                        break;

                    case ChaptersModel::STATUS_DRAFT:
                        $this->drafts[] = $chapter;
                        break;

                    default:
                        break;
                }
            }

            return $this->renderer->render('dashboard/chaptersPanel', [
                'title' => 'Chapitres | Dashboard',
                'published' => $this->published,
                'trash' => $this->trash,
                'drafts' => $this->drafts
            ]);
        }
    }

    private function changeChapterStatus(int $chapterId, int $newStatus = ChaptersModel::STATUS_DEFAULT)
    {
        try {
            if (ChaptersModel::setStatus((int) $chapterId, (int) $newStatus)) {
                switch ($newStatus) {
                    case ChaptersModel::STATUS_TRASH:
                        Session::setFlashbag('Le chapitre a été placé dans la corbeille', 'success');
                        break;

                    case ChaptersModel::STATUS_DRAFT:
                        Session::setFlashbag('Le chapitre a été placé dans les brouillons', 'success');
                        break;

                    case ChaptersModel::STATUS_DELETED:
                        Session::setFlashbag('Le chapitre a été supprimé', 'success');
                        break;

                    default:
                        throw new Exception('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.');
                        break;
                }

                header('Location: /?view=chaptersPanel');
            } else {
                throw new Exception('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.');
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=chaptersPanel');
        }
    }
}
