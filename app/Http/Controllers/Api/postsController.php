<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\posts;
use Illuminate\Http\Request;
use Validator;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts= posts::where('users_id', auth()->user()->id)->get();
        // Flight::where('active', 1)
            //    ->orderBy('name')
            //    ->take(10)
            //    ->get();
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
        $post = posts::create(
            [
                'title'=>$request->title,
                'Body'=>$request->Body,
                'image'=>"dada",
                // 'image'=>$request->image,
                'Pinned' => $request->Pinned,
                'users_id'=> auth()->user()->id
            ]
            
        );
        return response()->json([
            'message' => 'Great success! New tag created',
            'post' => $post
        ], 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(posts $post)
    {
        if ($post->users_id==auth()->user()->id){
        return response($post);
    }
else{
    return response("no data");

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


if($post->users_id==auth()->user()->id){
    $post->update(
        [
            'title' => $request->title,
            'Body' => $request->Body,
            'image' => "jj",
            // 'image' => $img_name,
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
        $data=posts::withTrashed()->find($id)->restore();
  
        return response()->json([
            'message' => 'restore secusses',
            'data'=>$data
        ], 200);
    }  


    public function all(Request $request)
    {
        $data=posts::onlyTrashed()->get();
        return response()->json([
            'message' => 'restore secusses',
            'data'=>$data
        ], 200);
    }  


    // User::onlyTrashed()->restore();
  
}
