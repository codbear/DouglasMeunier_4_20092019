<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Models\ChaptersModel;
use Codbear\Alaska\Services\Renderer\Renderer;

class Controller
{
    public $renderer;

    public function __construct()
    {
        $this->renderer = Renderer::getInstance(dirname((__DIR__)) . '/Views');
        $this->renderer->addGlobal('title', 'Billet simple pour l\'Alaska');
        $this->renderer->addGlobal('tableOfContent', ChaptersModel::getAll());
    }

    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        $this->renderer->render('errors/error404', ['title' => 'Erreur 404']);
        exit;
    }

    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        $this->renderer->render('errors/error403', ['title' => 'Erreur 403']);
        exit;
    }

    public function unauthorized()
    {
        header('HTTP/1.0 401 Unauthorized');
        $this->renderer->render('errors/error401', ['title' => 'Erreur 401']);
        exit;
    }
}
