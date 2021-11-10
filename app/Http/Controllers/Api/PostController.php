<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => "Error authentication user",
            ]);
        }
        return response()->json([
            'status_code' => 200,
            'data' => PostResource::collection($user->posts)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $post = new Post;
        $post->content = $request->content;
        $post->title = $request->title;
        $post->date = $request->date;
        $post->img = $request->img;
        $post->user_id = $user->id;
        $post->save();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
        // Get a single post
        $post = Post::findOrFail($id);
                
        // Return a single post as a resource
        return new PostResource($post);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            $post->content = $request->content ? $request->content : $post->content;
            $post->title = $request->title ? $request->title : $post->title;
            $post->date = $request->date ? $request->date : $post->date;
            $post->img = $request->img ? $request->img : $post->img;
            $post->save();
            return response()->json([
                'status_code' => 200,
                'message' => "Le post a été modifié",
                'data' => $post
            ]);
            // $user->update($request->all());
        }
        catch(Exception $e) {
            return response()->json([
                'status_code' => 400,
                'message' => "Il y a eu une erreur lors de la modification de le post"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     // Get the post
     $post = Post::findOrFail($id);
        
     //  Delete the post, return as confirmation
     if ($post->delete()) {
         return new PostResource($post);
     }
    }
}
