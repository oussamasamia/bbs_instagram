<?php

namespace App\Http\Controllers;

use App\Services\InstagramPostService;
use Illuminate\Http\Request;

use Instagram\FacebookLogin\FacebookLogin;


class InstagramPostController extends Controller
{


    public function getInstagramPosts(Request $request)
    {

        $instagramPostService = new InstagramPostService();

        $posts = $instagramPostService->getPostsFromDB(25);


        return view('welcome',
            [
                'posts' => $posts
            ]
        );


    }


}
