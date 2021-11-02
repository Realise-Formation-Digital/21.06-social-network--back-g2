<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Info users
        $users = User::factory()->count(30)->create();

      
        //Insert posts
        $posts = Post::factory()->count(10)->make()
            ->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
            });
        

        //Insert likes
        $likes = Like::factory()->count(10)->make()
            ->each(function($like) use ($users, $posts) {
            $like->user_id = $users->random()->id;
            $like->post_id = $posts->random()->id;
            $like->save();
        });


        //Insert comments
        $comments = Comment::factory()->count(10)->make()
            ->each(function($comment) use ($users, $posts) {
            $comment->user_id = $users->random()->id;
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
