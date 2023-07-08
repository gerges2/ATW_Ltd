<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\posts;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function stat()
     {
        $conutOfUser= User::all()->count();
        $postcount= posts::all()->count();
        $usersWithPosts = User::doesntHave('posts')->count();
        // $usersWithPosts = User::has('posts')->count();
    return ['number of user'=> $conutOfUser ,'number of posts'=> $postcount,'umber of user have 0 post'=>$usersWithPosts];
     }
    public function index()
    {
        //
        $posts= posts::where('user_id', auth()->user()->id)->orderBy('Pinned','desc')->get();
        return response($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'Body' => 'required|string',
            'image' => 'required|image',
            'Pinned' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            $destination_path = 'public/images/posts';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path, $image_name);
            // $book['Image'] = $image_name;
        }
        $post = posts::create(
            [
                'title'=>$request->title,
                'Body'=>$request->Body,
                'image'=> $image_name,
                // 'image'=>$request->image,
                'Pinned' => $request->Pinned,
                'user_id'=> auth()->user()->id
            ]
            
        );
        return response()->json([
            'message' => 'Great success! New tag created',
            'post' => $post
            // 'post' =>
        ], 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(posts $post)
    {
        if ($post->user_id==auth()->user()->id){
        return response($post);
    }
else{
    return response("thies post no belong for you");

}
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,posts $post)
    {
        //

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'Body' => 'required|string',
            'image' => 'image',
            'Pinned' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 400);
        }


if($post->user_id==auth()->user()->id){
    if ($request->hasFile('image')) {
        $destination_path = 'public/images/posts';
        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('image')->storeAs($destination_path, $image_name);
        // $book['Image'] = $image_name;
    }else{
        $image_name=$post->	image;
    }
    $post->update(
        [
            'title' => $request->title,
            'Body' => $request->Body,
            'image' =>  $image_name,
            'Pinned' => $request->Pinned,
        ]
    );
    $post->save();

    return response()->json([
        'message' => 'post updated',
        'post' => $post
    ], 200);
}else{
    return response()->json([
        'message' => 'not allowed to update',
    ], 200);
}
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data= posts::find($id)->delete();
        return response()->json([
            'message' => 'deleted secusses',
            'data'=>$data
        ], 200);
    }





    public function restore($id)
    {
        $data=posts::withTrashed()->find($id)->where('user_id',auth()->user()->id)->restore();
        // $data=posts::withTrashed()->find($id)->restore();
  
        return response()->json([
            'message' => 'restore secusses',
            'data'=>$data
        ], 200);
    }  


    public function all(Request $request)
    {
        $data=posts::onlyTrashed()->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'message' => 'restore secusses',
            'data'=>$data
        ], 200);
    }  


    // User::onlyTrashed()->restore();
  
}
