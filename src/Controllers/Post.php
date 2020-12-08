<?php

namespace App\Controllers;

use App\Controllers\Base;

class Post extends Base
{
    public function index()
    {
        $this->view->render('post.index');
    }
}
