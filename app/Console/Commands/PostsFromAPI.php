<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InstagramPostService;
use Illuminate\Support\Facades\Log;


class PostsFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:posts-from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get Instagram posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Service:posts-from-api command executed.');
        $instagramPostService = new InstagramPostService();
        $instagramPostService->getPosts(25);
    }
}
