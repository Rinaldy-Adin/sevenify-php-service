<?php

declare(strict_types=1);

namespace router;

require_once ROOT_DIR . 'exceptions/ForbiddenException.php';
require_once ROOT_DIR . 'exceptions/NotFoundException.php';

use exceptions\NotFoundException;

define('PAGE_DIR', ROOT_DIR . 'public/views/pages');

class PageRouter
{
    private static $instance;
    // Static method to get the singleton instance
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function getViewPath(string $URL): string
    {
        $route = explode('?', $URL)[0];
        $viewPath = "$route";
        if (substr($viewPath, -1) == "/") {
            $viewPath = $viewPath . "index";
        }
        $fullViewPath = PAGE_DIR . $viewPath . '.php';

        if (!file_exists($fullViewPath)) {
            $withoutSlug = implode('/', array_slice(explode('/', $URL), 0, -1));
            $fullPathWithoutSlug = PAGE_DIR . $withoutSlug;

            if (!empty($withoutSlug) && file_exists($fullPathWithoutSlug . '/anyslug.php')) {
                $fullViewPath = $fullPathWithoutSlug . '/anyslug.php';
            } else {
                throw new NotFoundException();
            }
        }

        return $fullViewPath;
    }

    public function resolve(string $URL): string
    {
        $fullViewPath = $this->getViewPath($URL);
        ob_start();
        require $fullViewPath;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
