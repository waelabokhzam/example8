<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Image;
use App\Models\Meal;
use App\Models\Order_Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class mealController extends Base
{
    public function get_meal($id)
    {

        $meal = Meal::with(['image_meal' => function ($q) {
            $q->select('image', 'meal_id');
        }])->select('*')->where('catagory_id', $id)->get();
        return response()->json([
            'status' => true,
            'meal' => $meal,
            'message' => 'welcom meal',
        ]);
    }

    public function get_meal_id($name)
    {
        $id_meal = Meal::select('id')->where('name', $name)->get();
        $meal = Meal::with(['image_meal' => function ($q) {
            $q->select('image', 'meal_id');
        }])->find($id_meal);
        return response()->json([
            'status' => true,
            'message' => 'successfully',
            'meal' => $meal,
        ]);
    }

    public function choise_count_of_meal(Request $request, $name)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'count' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Count  Must Be Required']);
        }
        $meal_id = Meal::select('id')->where('name', $name)->value('id');
        $m = Meal::select('count')->where('name', $name)->value('count');

        if ($m >= $input['count']) {
            $meal = Meal::find($meal_id);
            $meal->count = $meal->count - $input['count'];
            $meal->save();

            $user_id = Auth::id();
            $order_meal = new Order_Meal;
            $order_meal->meal_id = $meal_id;
            $order_meal->user_id = $user_id;
            $order_meal->count = $input['count'];
            $order_meal->save();
            return response()->json(['message' => 'successfully',
                'status' => true]);
        } else {
            return response()->json(['message' => 'error in a count']);
        }
    }

    public function get_card()
    {
        $user_id = Auth::id();

        $order_meal = Order_Meal::select('meal_id')->where('user_id', $user_id)->where('status', 0)->value('meal_id');
        // return response()->json(['meal_id' => $order_meal]);
        //$username = User::select('name')->where('id', $user_id)->get();

        $cart = DB::table('meal')->select('name', 'price', 'order_meal.count')->join('order_meal', 'order_meal.meal_id', '=', 'meal.id')->where('order_meal.user_id', $user_id)->get();

        return response()->json([
            'cart' => $cart,
            'status' => true]);
    }

    public function addmeal(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'count' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'catagory_id' => 'required',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'All Must Be Required']);
        }
        $meal = new Meal;
        $meal->name = $input['name'];
        $meal->count = $input['count'];
        $meal->price = $input['price'];
        $meal->description = $input['description'];
        $meal->catagory_id = $input['catagory_id'];
        $meal->save();
        $meal_id = Meal::select('id')->where('name', $input['name'])->value('id');
        $image = new Image;
        $image->image = $input['file'];
        $image->meal_id = $meal_id;
        $image->save();

        return response()->json(['status' => true]);
    }

    public function editmeal(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'count' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'catagory_id' => 'required',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'All Must Be Required']);
        }
        $meal = Meal::find($id);
        $meal->name = $input['name'];
        $meal->count = $input['count'];
        $meal->price = $input['price'];
        $meal->description = $input['description'];
        $meal->catagory_id = $input['catagory_id'];
        $meal->save();
        $image_id = Image::select('id')->where('meal_id', $id)->value('id');
        $image = Image::find($image_id);
        $image->image = $input['file'];
        $image->save();
        return response()->json(['status' => true]);
    }
    public function edit_count_meal(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'count' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'All Must Be Required']);
        }
        $order_id_count = Order_Meal::select('count')->where('id', $id)->value('count');
        $order_id_meal = Order_Meal::select('meal_id')->where('id', $id)->value('meal_id');

        $meal_id = Meal::select('count')->where('id', $order_id_meal)->value('count');
        // $m = Meal::select('count')->where('id', $id)->value('count');
        $m = $input['count'] - $order_id_count;
        if ($m >= 0) {
            $m_c = Meal::select('count')->where('id', $order_id_meal)->value('count');
            if ($m_c >= $m) {
                $meal = Meal::find($order_id_meal);
                $meal->count = $meal->count - $m;
                $meal->save();
                $order = Order_Meal::find($id);
                $order->count += $m;
                $order->save();
                return response()->json([
                    'message' => 'seccessfully updated ',
                    'status' => true,
                ]);
            }
            return response()->json([
                'message' => 'the quantity is not available',
                'status' => false,
            ]);
        }
        if ($m < 0) {
            $order = Order_Meal::find($id);
            $order->count += $m;
            $order->save();
            $meal = Meal::find($order_id_meal);
            $meal->count = $meal->count + abs($m);
            $meal->save();
            return response()->json([
                'message' => 'seccessfully updated ',
                'status' => true,
            ]);
        }
    }
    public function all_member()
    {
        $about = About::with(['image_about' => function ($q) {
            $q->select('image', 'about_id');
        }])->get();
        return response()->json([
            'status' => true,
            'about us' => $about,
            'message' => 'welcom ',
        ]);
    }

}
