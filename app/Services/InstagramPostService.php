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
        $jsonData = $this->instagramPostRepository->getAndStoreInstagramPosts($limit);
    }

    public function getPostsFromDB($limit = 25)
    {
        $posts = $this->instagramPostRepository->getPostsFromDB($limit);


        foreach ($posts as $post) {
            $images = [];


            if ($post->media_type === 'CAROUSEL_ALBUM') {


                foreach ($post->images as $image) {
                    $images[] = $image->media_url;
                }


                $post->image_urls = $images;

            } else {

                $images[] = $post->media_url;
                $post->image_urls = $images;

            }
        }

        return $posts;

    }
}
