<?php

namespace App\Repositories;

use PostInterface;

class InstagramPostRepository implements PostInterface
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }


}
