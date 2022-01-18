<?php

namespace App\Console\Commands;


use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


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
        $response = Http::get(config('blog.external_blogging_platform'));
        
        $results = ($response->json())['data'];

        $admin = User::where('email',config('blog.admin_mail'))->first();

        if($admin){
            foreach ($results as $res){
                Post::addExternalPost($res, $admin);
            }
        }

    }


}
