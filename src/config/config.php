<?php

namespace config;

class Config {
    private string $path;

    function __construct(string $path) {
        $this->path = $path;
    }

    function load(): void {
        $lines = [];

        if (file_exists($this->path) && is_readable($this->path)) {
            $fileHandle = fopen($this->path, 'r');

            if ($fileHandle) {
                while (($line = fgets($fileHandle)) !== false) {
                    $lines[] = trim($line); // Remove leading/trailing whitespace
                }

                fclose($fileHandle);
            }
        }

        foreach ($lines as $idx => $line) {
            [$name, $value] = explode('=', $line);

            if (!$value) {
                $value = '';
            }

            if (strpos($value, "\"") !== false || strpos($value, "'") !== false) {
                $value = substr($value, 0, strlen($value) - 1);
                $value = substr($value, 1, strlen($value) - 1);
            }

            $_ENV[$name] = $value;
        }
    }
}