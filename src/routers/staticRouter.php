<?php
namespace router;

class StaticRouter
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

    public function resolve(string $URL)
    {
        $filepath = substr($URL, 7);
        $files = glob(realpath(__DIR__ . '/../../storage') . $filepath . '.*');
        $file = isset($files[0]) ? $files[0] : null;

        if ($file != null && file_exists($file) && !is_dir($file)) {
            header('Content-Type: ' . mime_content_type($file));
            header('Content-Length: ' . filesize($file));

            readfile($file);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "File not found.";
        }
    }
}