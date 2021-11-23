<?php
namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResource;
use App\Services\ValidatorService;
use Exception;
use Illuminate\Http\Request;

class PostService {

    private $validatorService;

    public function __construct(ValidatorService $validatorService) {
        $this->validatorService = $validatorService;
    }

    public function getPosts() {
        try {
            $user = Auth::user();
            return $user->posts;
        }
        catch(\Exception $e) {
            throw($e);
        }
    }


    public function creatPost(Request $request) {

        try {
            // Validating fields.
            $this->validatorService->validateFields($request->all(), $this->validatePost());

            // Get authenticated user.
            $user = Auth::user();

            // Create post.
            $post = new Post;
            $post->content = $request->input('content');
            $post->title = $request->input('title');
            $post->date = $request->input('date');
            $post->img = $request->input('img');
            $post->user_id = $user->id;
            $post->save();

            // Return the new post
            return $post;
        }
        catch(\Exception $e) {
            throw($e);
        }

    }

    public function findPost ($id) {

        try {
            // Get a single post
            $post = Post::findOrFail($id);

            // Return a single post as a resource
            return $post;
        }

        catch(\Exception $e) {
            throw($e);
        }
    }

    public function modifPost (Request $request,$id ) {

        try {
            // Validating fields.
            $this->validatorService->validateFields($request->all(), $this->validatePost());

            // Update post.
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
        catch(\Exception $e) {
            return response()->json([
                'status_code' => 400,
                'message' => "Il y a eu une erreur lors de la modification de le post"
            ]);
        }
    }

    public function delPost ($id) {
        try{
        // Get the post
        $post = Post::findOrFail($id);

        //  Delete the post, return as confirmation
        $post->delete();
            return response()->json([
                'message' => "Il y a eu une erreur lors de la suppression du post"
            ]);

        } catch(Exception $e) {
            throw new ApiException("Il y a eu un problème lors de la suppression du post");
        }
    }



    //Validation fields posts
    /**
     *
     * @param  bool $update
     * @return array
     */
    public function validatePost($update = false)
    {
      // Validating fields.
      $validatorRules = [
        'title' => 'required|string|max:128',
        'content' => 'required|string|max:128',
        'img' => 'required|string|max:128',
        'date' => 'required|date',
      ];

      // Check id when account is updated.
      if ($update) {
        $validatorRules['id'] = 'required|integer|digits_between:1,20';
      }
      return $validatorRules;
    }

}
