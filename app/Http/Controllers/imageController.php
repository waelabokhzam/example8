<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class imageController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg',
        ]);
        if ($validate) {
            //$requestDecode = json_decode($request->date, true);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = time() . '.' . $extension;
            $file->move('image', $file_name);
            Image::create([
                'image' => $file_name,
            ]);
            return response()->json(['alert' => 'Success'], 200);
        }
        return response()->json(['alert' => 'Error'], 404);
    }
    public function allimage()
    {
        $image = Image::all();
        return view('all', compact('image'));
    }
}
