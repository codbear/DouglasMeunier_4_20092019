<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Models\Entity\ChapterEntity;
use Codbear\Alaska\Models\Tables\ChaptersTable;
use Exception;

class ChapterEditorController extends DashboardController implements ControllerInterface
{
    private $chapter;

    public function execute(array $params, array $datas)
    {
        if (isset($params['chapterId'])) {
            $this->chapter = ChaptersTable::get((int) $params['chapterId']);
        } else {
            $this->chapter = new ChapterEntity();
        }
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'saveChapter':
                    $this->save($datas);
                    break;

                case 'publishChapter':
                    $this->save($datas, true);
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        }
        if (!isset($this->chapter->number) || $this->chapter->number < 1) {
            $this->chapter->number = ChaptersTable::getMaxChapterNumber() + 1;
        }
        $this->renderer->addGlobal('title', 'Dashboard | Editeur');
        return $this->renderer->render('dashboard/chapterEditor', [
            'chapter' => $this->chapter
        ]);
    }

    private function save(array $datas, bool $publish = false)
    {
        $this->chapter->title = $datas['chapter-title'];
        $this->chapter->number = $this->chapter->number_save = $datas['chapter-number'];
        $this->chapter->content = $datas['chapter-content'];
        if (empty($datas['chapter-excerpt'])) {
            $this->chapter->excerpt = substr($this->chapter->content, 0, 252) . '...';
        } else {
            $this->chapter->excerpt = $datas['chapter-excerpt'];
        }
        if ($publish) {
            $this->chapter->status = ChaptersTable::STATUS_PUBLISHED;
        } elseif (!isset($this->chapter->status)) {
            $this->chapter->status = ChaptersTable::STATUS_DRAFT;
        }
        try {
            if (empty($this->chapter->title)) {
                throw new Exception("Vous devez saisir un titre pour votre chapitre");
            }
            if (empty($this->chapter->number)) {
                throw new Exception("Vous devez saisir un numéro de chapitre");
            }
            if ($this->chapter->number < 1) {
                throw new Exception("Vous ne pouvez pas saisir un numéro de chapitre négatif");
            }
            if ($this->chapter->status === ChaptersTable::STATUS_PUBLISHED) {
                if (empty($this->chapter->content)) {
                    throw new Exception('Impossible de publier un chapitre sans contenu');
                }
            }
            if (ChaptersTable::save($this->chapter)) {
                if ($this->chapter->status === ChaptersTable::STATUS_PUBLISHED) {
                    Session::setFlashbag('Le chapitre a bien été publié', 'success');
                } else {
                    if (empty($this->chapter->content)) {
                        Session::setFlashbag('Le chapitre a bien été enregistré, mais son contenu est vide');
                    } else {
                        Session::setFlashbag('Le chapitre a bien été enregistré', 'success');
                    }
                }
                header('Location: /?view=chaptersPanel');
            } else {
                throw new Exception('Une erreur inatendue est survenue. Merci de réessayer ultérieurement.');
            }
        } catch (Exception $e) {
            if ($publish) {
                $this->chapter->status = ChaptersTable::STATUS_DRAFT;
            }
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }
}
