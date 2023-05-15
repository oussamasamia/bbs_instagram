<?php

namespace App\Services;


use App\Repositories\InstagramPostRepository;

class InstagramPostService
{

    protected $instagramPostRepository;

    /**
     * @param $instagramPostRepository
     */
    public function __construct()
    {
        $this->instagramPostRepository = new InstagramPostRepository();
    }


    public function getPosts($limit = 25)
    {
        $jsonData = $this->instagramPostRepository->getInstagramPosts($limit);
        dd($jsonData);

    }


}
