<?php

namespace App\Console\Commands;


use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ImportPostsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto import the posts created there and add them to our new blogging platform';

    /**
     * ImportPostsCron constructor.
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://sq1-api-test.herokuapp.com/posts');
        
        $results = ($response->json())['data'];

        $admin = User::where('email','customer@test.com')->first();

        foreach ($results as $res){
            $newPost = new Post;
            $newPost->title = $res['title'];
            $newPost->slug = $res['title'];
            $newPost->description = $res['description'];
            $newPost->created_at = $res['publication_date'];
            $newPost->user_id = $admin->id;
            $newPost->save();
        }
    }


}
