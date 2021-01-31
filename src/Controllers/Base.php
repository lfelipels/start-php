<?php

namespace App\Controllers;

use App\Core\Helpers\View;

abstract class Base
{
    protected View $view;

    public function __construct()
    {
        $this->view = View::make(__DIR__ . '/../../views');
    }
}
