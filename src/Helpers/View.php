<?php

namespace App\Helpers;

class View
{
    private string $basePath;
    private string $extension;

    public function __construct(string $basePath = '', string $extension = 'php')
    {
        $this->basePath = $basePath;
        $this->extension = $extension;
    }

    public static function make(string $basePath = '', string $extension = 'php')
    {
        return new static($basePath, $extension);
    }


    public function render(string $view, array $data = [])
    {
        $pathView = $this->resolveView($view);
        if (!empty($data)) {
            extract($data);
        }
        return include $pathView;
    }


    private function resolveView(string $view): string
    {
        $viewOriginal = $view;

        if (strpos('.', $view) == false) {
            $view = str_replace('.', '/', $view);
        }

        $fileView = $this->basePath . "/" . $view . '.' . $this->extension;

        if (!file_exists($fileView)) {
            throw new \Exception("View {$viewOriginal} not found");
        }

        return $fileView;
    }
}
