<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;
use App\Models\Image;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class InstagramPostRepository implements PostInterface
{
    public function getAndStoreInstagramPosts($limit = 25)
    {
        $client = new Client();
        $request = new Request('GET', 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,username,likes_count,comments_count,location,tags&limit=' . $limit . '&access_token=' . env('FACEBOOK_LONG_TOKEN', ''));
        $response = $client->send($request);
        $jsonData = json_decode($response->getBody(), true);

        // Store the posts in the DB
        foreach ($jsonData['data'] as $postData) {


            $post = Post::updateOrCreate(['post_id' => $postData['id']], [
                'media_type' => $postData['media_type'],
                'media_url' => $postData['media_url'],
                'permalink' => $postData['permalink'],
                'timestamp' => Carbon::parse($postData['timestamp'])->format('Y-m-d H:i:s'),
                'username' => $postData['username'],
            ]);

            //dd($post->id);

            // Retrieve and store images for the post
            $imagesData = $this->getPostsImages($postData['id']);

            foreach ($imagesData['data'] as $imageData) {
                Image::updateOrCreate(['image_id' => $imageData['id']], [
                    'media_type' => $imageData['media_type'],
                    'media_url' => $imageData['media_url'],
                    'permalink' => $imageData['permalink'],
                    'post_id' => $post->id ?: 100,
                ]);
            }
        }

        return $jsonData;
    }

    public function getPostsImages($postId)
    {
        $client = new Client();
        $request = new Request('GET', "https://graph.instagram.com/{$postId}/children?fields=id,media_type,media_url,permalink&access_token=" . env('FACEBOOK_LONG_TOKEN', ''));
        $response = $client->send($request);
        $jsonData = json_decode($response->getBody(), true);

        return $jsonData;
    }
}
