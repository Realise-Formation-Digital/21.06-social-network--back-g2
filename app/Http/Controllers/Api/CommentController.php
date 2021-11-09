<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::all();
        
        $comments = Comment::paginate(10);
        
        // Return collection of posts as a resource
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //        // Get a comment post
        $comment = Comment::findOrFail($id);
        
        // Return a single comnment as a resource
        return new CommentResource($comment);    
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
            $user = User::find($id);
            $user->content = $request->content ? $request->content : $user->content;
            $user->save();
            return response()->json([
                'status_code' => 200,
                'message' => "Le content a été modifié",
                'data' => $user
            ]);
            // $user->update($request->all());
        }
        catch(Exception $e) {
            return response()->json([
                'status_code' => 400,
                'message' => "Il y a eu une erreur lors de la modification de l'utilisateur"
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
        // Get the comment
        $comment = Comment::findOrFail($id);
        
        //  Delete the comment, return as confirmation
        if ($comment->delete()) {
            return new CommentResource($comment);
        }
    }
}
