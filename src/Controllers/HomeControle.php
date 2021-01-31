<?php

namespace App\Controllers;

use App\Controllers\Base;

class HomeControle extends Base
{
    public function index()
    {
        return $this->view->render('home', [
            'title' => 'Home Page'
        ]);
    }
}
