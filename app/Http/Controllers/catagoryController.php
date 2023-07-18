<?php

namespace App\Http\Controllers;

use App\Models\Catogry;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class catagoryController extends Base
{
    public function get_catagory()
    {
        $catagory = Catogry::with(['image_catagory' => function ($q) {
            $q->select('image', 'catagory_id');
        }])->get();
        return response()->json([
            'status' => true,
            'catagory' => $catagory]);
    }

    public function category_id($name)
    {
        // $cat_id = Catogry::select('id')->where('name', $name)->value('id');
        $category = Catogry::with('image_catagory')->find($name);
        if ($category) {
            return response()->json([
                'status' => true,
                'category' => $category,
            ]);
        } else {
            return response()->json(['status' => false,
                'error' => 'Error In Request']);
        }
    }
    public function addcategory(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'It`s Must Be Required']);
        }
        $cat = new Catogry;
        $cat->name = $input['name'];
        $cat->save();
        $cat_id = Catogry::select('id')->where('name', $input['name'])->value('id');
        $image = new Image;
        $image->image = $input['file'];
        $image->catagory_id = $cat_id;
        $image->save();

        return response()->json(['status' => true]);
    }
    public function editcategory(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'It`s Must Be Required']);
        }
        $cat = Catogry::find($id);
        $cat->name = $input['name'];
        $cat->save();
        $image_id = Image::select('id')->where('catagory_id', $id)->value('id');
        $image = Image::find($image_id);
        $image->image = $input['file'];
        $image->save();
        return response()->json(['status' => true]);
    }
}
