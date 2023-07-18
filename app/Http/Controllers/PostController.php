<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostRecource;
use App\Models\Catogry;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Meal;
use App\Models\Post;
use App\Models\Tabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Base
{

    public function index()
    {
        $post = Post::all();
        return $this->sendResponse($post, 'return post successfully');
    }
    public function userpost($id)
    {
        $post = Post::where('user_id', $id)->get();
        return $this->sendResponse($post, 'return post for user  successfully');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validateor = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validateor->fails()) {
            return $this->sendError('pleas validate error', $validateor->errors());
        }
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $post = Post::create($input);
        return $this->sendResponse(new PostRecource($post), 'Prodect created Successfully');
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('Post not found');
        }
        return $this->sendResponse(new PostRecource($post), 'Post found Successfully');
    }

    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('please validatation error', $validator->errors());
        }

        if ($post->user_id != Auth::id()) {
            return $this->sendError('you dont have permission denied to tjis post');
        }
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();
        return $this->sendResponse(new PostRecource($post), 'Post updated Successfully');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return $this->sendError('you dont have permission denied to this post');
        }
        $post->delete();
        return $this->sendResponse(new PostRecource($post), 'Post deleted Successfully');
    }

    public function image()
    {
        $cat = Catogry::with(['image_catagory' => function ($q) {
            $q->select('image', 'catagory_id');
        }])->find(1);
        return response()->json($cat);
    }

    public function r_image()
    {
        $cat = Image::find(2);
        $cat->makeVisible(['catagory_id']);
        $cat->catagory;
        return response()->json($cat);
    }

    public function manycatagory()
    {
        $ca = Tabel::with('catagory_table')->find(1);
        $catname = $ca->catagory_table;

        /*  foreach ($catname as $cat) {
        echo $cat->name . '<br>';
        }*/
        //return response()->json($catname);
        $namecatagory = Catogry::find(1);
        return $namecatagory->table->number;
    }
    public function meal_inventory()
    {
        $meal = Meal::find(1);
        $meal = $meal->meal_inventory_has_many;
        foreach ($meal as $m) {
            echo $m->name . '  ';

        }
        // $meal->meal_inventory_has_many;
    }
    public function inventory_meal()
    {
        return $inv = Inventory::with('inventory_meal_has_many')->find(1);
    }
}
