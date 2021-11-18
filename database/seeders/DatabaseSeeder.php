<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Abbonement;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin role
        $admin_role = Role::create(['name' => 'admin']);

        // Create permissions.
        $permission_create_post = Permission::create(['name' => 'create post']);

        // Give permission to role admin
        $admin_role->givePermissionTo($permission_create_post);

        //Info users
        $users = User::factory()->count(90)->create();

        // Give admin role to the user.
        $users[0]->assignRole($admin_role);
      
        //Insert posts
        $posts = Post::factory()->count(100)->make()
            ->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
            });
        

        //Insert likes
        $likes = Like::factory()->count(50)->make()
            ->each(function($like) use ($users, $posts) {
            $like->user_id = $users->random()->id;
            $like->post_id = $posts->random()->id;
            $like->save();
        });


        //Insert comments
        $comments = Comment::factory()->count(60)->make()
            ->each(function($comment) use ($users, $posts) {
            $comment->user_id = $users->random()->id;
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });

        //Insert abbonements
        $abbonements = Abbonement::factory()->count(20)->make()
            ->each(function($abbonement) use ($users) {
            $abbonement->user_id = $users->random()->id;
            $abbonement->save();
        });
    }
}
