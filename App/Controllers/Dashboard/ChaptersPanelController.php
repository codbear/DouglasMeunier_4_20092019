<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;
use Codbear\Alaska\Models\Tables\ChaptersTable;

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
                    $this->changeChapterStatus($params['chapterId'], ChaptersTable::STATUS_TRASH);
                    break;

                case 'restoreChapterFromTrash':
                    $this->changeChapterStatus($params['chapterId'], ChaptersTable::STATUS_DRAFT);
                    break;

                case 'deleteChapterPermanently':
                    $this->changeChapterStatus($params['chapterId'], ChaptersTable::STATUS_DELETED);
                    break;

                case 'createNewChapter':
                    $this->createNewChapter();
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        } else {
            foreach (ChaptersTable::getAll() as $chapter) {
                switch ($chapter->status) {
                    case ChaptersTable::STATUS_PUBLISHED:
                        $this->published[] = $chapter;
                        break;

                    case ChaptersTable::STATUS_TRASH:
                        $this->trash[] = $chapter;
                        break;

                    case ChaptersTable::STATUS_DRAFT:
                        $this->drafts[] = $chapter;
                        break;

                    default:
                        break;
                }
            }
            $this->renderer->addGlobal('title', 'Dashboard | Chapitres');
            return $this->renderer->render('dashboard/chaptersPanel', [
                'published' => $this->published, 
                'trash' => $this->trash, 
                'drafts' => $this->drafts
                ]);
        }
    }

    private function changeChapterStatus(int $chapterId, int $newStatus = ChaptersTable::STATUS_DEFAULT)
    {
        try {
            if (ChaptersTable::setStatus((int) $chapterId, (int) $newStatus)) {
                switch ($newStatus) {
                    case ChaptersTable::STATUS_TRASH:
                        Session::setFlashbag('Le chapitre a été placé dans la corbeille', 'success');
                        break;

                    case ChaptersTable::STATUS_DRAFT:
                        Session::setFlashbag('Le chapitre a été placé dans les brouillons', 'success');
                        break;

                    case ChaptersTable::STATUS_DELETED:
                        Session::setFlashbag('Le chapitre a été supprimé', 'success');
                        break;

                    default:
                        throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.", 1);
                        break;
                }
                header('Location: /?view=chaptersPanel');
            } else {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement.", 1);
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=chaptersPanel');
        }
    }

    private function createNewChapter()
    {
        header('Location: /?view=chapterEditor');
    }
}
