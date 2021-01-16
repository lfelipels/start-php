<?php

namespace App\Repositories;

use App\Core\Collection\Colletion;

trait WithModelMapper
{

    /**
     * Mapper Category Entity
     *
     * @param array $categoryList
     * @return array
     */
    protected abstract function mapModel($model);
    
    protected function mapFromArray(array $list)
    {
        $list = (new Colletion($list))->map(fn($data) => $this->mapModel($data));
        return $list;
    }
}
