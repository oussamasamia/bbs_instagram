<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Ramsey\Uuid\Type\Integer;

class InstagramPostRepository implements PostInterface
{


    public function getInstagramPosts($limit = 25)
    {

        //retrieve max 25 posts

        $client = new Client();
        $request = new Request('GET', 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink&limit=' . $limit . '&access_token=' . env('FACEBOOK_LONG_TOKEN', ''));
        $response = $client->send($request);
        $jsonData = json_decode($response->getBody(), true);

        return $jsonData;
    }
}
