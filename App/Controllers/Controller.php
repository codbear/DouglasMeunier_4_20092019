<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Services\Renderer\Renderer;

class Controller
{

    protected $renderer;

    public function __construct(Renderer $renderer)
    { 
        $this->renderer = $renderer;
    }
}
