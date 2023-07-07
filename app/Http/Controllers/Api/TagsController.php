<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tags;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // name
        //
        $tags= tags::all();
        return response($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30|min:3|unique:tags,name',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $tag = tags::create(
            [
                'name' => $request->name,
                'user_id'=> auth()->user()->id
            ]
            
        );
        return response()->json([
            'message' => 'Great success! New tag created',
            'tag' => $tag
        ], 201);

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tags $tag)
    {return response()->json($tag, 200);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,tags $tag)
    {
        $request->validate([
            'name' => ['required','max:30', Rule::unique('tags')->ignore($tag->name, 'name')],
        ]);
        $tag->update($request->all());
        $tag->save();
        return response($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tags $tag)
    {
        $tag->delete();
        return response()->json(['message' =>"delete successfully"]);   //
        //
    }
}
