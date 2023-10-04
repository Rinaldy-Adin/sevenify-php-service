<?php

declare(strict_types=1);

namespace router;

define('PAGE_DIR', ROOT_DIR . 'public/views/pages');

class PageRouter
{
    public ?string $errorRoute;

    function __construct(?string $errorRoute = NULL)
    {
        $this->errorRoute = $errorRoute;
    }

    public function resolve(string $URL): string
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
                if ($this->errorRoute) {
                    $fullViewPath = PAGE_DIR . $this->errorRoute . '.php';

                    ob_start();
                    require $fullViewPath;
                    $content = ob_get_contents();
                    ob_end_clean();

                    return $content;
                } else {
                    header("HTTP/1.0 404 Not Found");
                    return '';
                }
            }
        }

        ob_start();
        require $fullViewPath;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
