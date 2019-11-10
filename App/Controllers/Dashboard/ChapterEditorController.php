<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\ChapterModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class ChapterEditorController extends DashboardController implements ControllerInterface
{
    private $chapter = null;

    public function execute(array $params, array $datas)
    {
        $this->chapter = ChapterModel::getChapter((int) $params['chapterId']);
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'saveChapter':
                    $this->saveChapter($datas, $this->chapter->status);
                    break;

                case 'publishChapter':
                    $this->saveChapter($datas, ChapterModel::STATUS_PUBLISHED);
                    header('Location: /?view=chaptersPanel');
                    exit();
                    break;

                default:
                    ErrorsController::error404();
                    break;
            }
            header('Location: ' . $this->chapter->editorUrl . '');
        } else {
            $this->render('chapterEditor', 'Editeur', ['chapter' => $this->chapter]);
        }
    }

    private function saveChapter(array $datas, $chapterStatus)
    {
        $this->chapter->title = $datas['chapter-title'];
        $this->chapter->number = $datas['chapter-number'];
        $this->chapter->content = $datas['chapter-content'];
        if (empty($datas['chapter-excerpt'])) {
            $this->chapter->excerpt = substr($this->chapter->content, 0, 252) . '...';
        } else {
            $this->chapter->excerpt = $datas['chapter-excerpt'];
        }
        if (ChapterModel::save(
            $this->chapter->id,
            $this->chapter->title,
            $this->chapter->number,
            $this->chapter->content,
            $this->chapter->excerpt,
            $chapterStatus
        )) {
            if ($chapterStatus === ChapterModel::STATUS_PUBLISHED) {
                Session::setFlash('Le chapitre a bien été publié', 'success');
            } else {
                Session::setFlash('Le chapitre a bien été enregistré', 'success');
            }
        } else {
            Session::setFlash('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.', 'error');
        }
    }
}
