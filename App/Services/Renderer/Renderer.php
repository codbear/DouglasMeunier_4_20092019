<?php

namespace Codbear\Alaska\Services\Renderer;

use Codbear\Alaska\Services\Session;

class Renderer
{
    const DEFAULT_NAMESPACE = '@__MAIN';
    const DEFAULT_SITE_TITLE = "Un billet pour l'Alaska";

    private static $_instance;
    private $paths = [];
    private $globals = [];

    public static function getInstance(string $defaultPath): Renderer
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new Renderer($defaultPath);
        }
		return self::$_instance;
	}

    public function __construct(string $defaultPath)
    {
        $this->paths[self::DEFAULT_NAMESPACE] = $defaultPath;
    }

    public function addPath(string $path, ?string $namespace = null): void
    {
        if (is_null($namespace)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $path;
        }
        $this->paths[$namespace] = $path;
    }

    public function render(string $view, array $datas = [])
    {
        if (Session::isSet('flashbag')) {
            $flashbag = Session::getFlashbag();
        } 
        extract($this->globals);
        extract($datas);
        ob_start();
        require($this->getViewPath($view));
        $content = ob_get_clean();
        require($this->getTemplatePath($view));
    }

    public function addGlobal($key, $value): void
    {
        $this->globals[$key] = $value;
    }

    private function getViewPath(string $view): string
    {
        if ($this->hasNamespace($view)) {
            return $this->replaceNamespace($view) . '.php';
        } else {
            return $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
    }

    private function getTemplatePath(string $view): string
    {
        if ($this->hasNamespace($view)) {
            $namespace = $this->getNamespace($view);
            return $this->paths[$namespace] . DIRECTORY_SEPARATOR . 'template.php';
        } else {
            return $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . 'template.php';
        }
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
