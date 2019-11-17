<?php

namespace Codbear\Alaska\Models\Entity;

class CommentEntity
{
    public $reporting = 0;
    public $reported = 0;

    public function __get($attribute)
    {
        $method = 'get' . ucfirst($attribute);
        $this->$attribute = $this->$method();
        return $this->$attribute;
    }

    public function setReporting(int $reporting)
    {
        $this->reporting = $reporting;
    }

    public function setReported() {
        $this->reported = 1;
    }

    private function getDeleteUrl() {
        return "/?view=commentsPanel&action=deleteComment&commentId=" . $this->id;
    }

    private function getReportUrl() {
        return "/?view=book&action=reportComment&commentId=" . $this->id;
    }
}
