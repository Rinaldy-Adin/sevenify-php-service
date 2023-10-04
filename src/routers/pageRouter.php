<?php

declare(strict_types=1);

namespace router;

define('PAGE_DIR', ROOT_DIR . 'public/views/pages');

class PageRouter
{
    public string $errorRoute;
    public array $unauthenticatedRoutes;

    function __construct(string $errorRoute, array $unauthenticatedRoutes)
    {
        $this->errorRoute = $errorRoute;
        $this->unauthenticatedRoutes = $unauthenticatedRoutes;
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
                return PAGE_DIR . $this->errorRoute . '.php';;
            }
        }

        if (!isset($_SESSION["user_id"]) && !in_array($route, $this->unauthenticatedRoutes)) {
            header("Location: " . $this->unauthenticatedRoutes[0]);
            return '';
        }

        if (isset($_SESSION["user_id"]) && in_array($route, $this->unauthenticatedRoutes)) {
            header("Location: /");
            return '';
        }

        return $fullViewPath;
    }

    public function resolve(string $URL): string
    {
        $fullViewPath = $this->getViewPath($URL);

        if ($fullViewPath != '') {
            ob_start();
            require $fullViewPath;
            $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }

        return '';
    }
}
