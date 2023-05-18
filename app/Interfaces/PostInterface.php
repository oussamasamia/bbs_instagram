<?php

namespace App\Interfaces;

interface PostInterface
{

    public function getAndStoreInstagramPosts($limit = 25);
    public function getPostsFromDB($limit = 25);

}
