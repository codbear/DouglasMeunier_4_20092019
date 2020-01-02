<?php

namespace Codbear\Alaska\Services\Renderer;

use Codbear\Alaska\Services\Session;

class Renderer
{
    const DEFAULT_NAMESPACE = '@__MAIN';

    private static $_instance;
    private $globals = [];
    private $viewsPath;

    public static function getInstance(string $path): Renderer
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Renderer($path);
        }
        return self::$_instance;
    }

    public function __construct(string $path)
    {
        $this->viewsPath = $path;
    }

    public function render(string $view, array $datas = [])
    {
        if (Session::isSet('flashbag')) {
            $flashbag = Session::getFlashbag();
        }
        extract($this->globals);
        extract($datas);
        ob_start();
        require($this->viewsPath . DIRECTORY_SEPARATOR . $view . '.php');
        $content = ob_get_clean();
        require($this->viewsPath . DIRECTORY_SEPARATOR . 'template.php');
    }

    public function addGlobal($key, $value): void
    {
        $this->globals[$key] = $value;
    }
}
