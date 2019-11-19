<?php

namespace Codbear\Alaska\Models\Entity;

use Codbear\Alaska\Models\Tables\ChaptersTable;

class ChapterEntity
{
    public function __get(string $attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    private function getUrl(): string
    {
        return '/?view=book&chapterId=' . $this->id;
    }

    private function getEditorUrl(): string
    {
        return '/?view=chapterEditor&chapterId=' . $this->id;
    }

    private function getPreviousChapterUrl()
    {
        if ($previousChapter = ChaptersTable::getWithNumber($this->number - 1)) {
            if ($previousChapter->status == ChaptersTable::STATUS_PUBLISHED) {
                return $previousChapter->url;
            }
        }
    }

    private function getNextChapterUrl()
    {
        if ($nextChapter = ChaptersTable::getWithNumber($this->number + 1)) {
            if ($nextChapter->status == ChaptersTable::STATUS_PUBLISHED) {
                return $nextChapter->url;
            }
        }
    }
}
