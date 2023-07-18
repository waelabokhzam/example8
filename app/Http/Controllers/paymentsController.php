<?php

namespace App\Http\Controllers;

use App\Models\Invoce;
use App\Models\Order_Meal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class paymentsController extends Controller
{
    public function cash_monye()
    {
        $user_id = Auth::id();
        $email = User::select('email')->where('id', $user_id)->value('email');
        $payment = 60;
        $invoic = new Invoce();
        $invoic->user_id = $user_id;
        $invoic->email = $email;
        $invoic->total_price = $payment;
        $invoic->status_payment = 'waiting';
        $invoic->save();

        return response()->json([
            'status' => true,
            'message' => 'go to admin for give him the monye',
        ]);

    }

    public function check_admin_payment()
    {
        $user_id = Auth::id();
        $role = User::select('role')->where('id', $user_id)->value('role');
        if ($role == 1) {
            $invoic = Invoce::select('*')->where('status_payment', 'waiting')->get();
            return response()->json([
                'status' => true,
                'data' => $invoic,
            ]);
        }
    }

    public function payment_id($id)
    {
        $user_id = Auth::id();
        $role = User::select('role')->where('id', $user_id)->value('role');
        if ($role == 1) {
            $pay_id = Invoce::find($id);
            $pay_id->status_payment = 'ok';
            $pay_id->save();

            $order_id = Order_Meal::select('id')->where('user_id', $pay_id->user_id)->update(['status'=>1]);

        }
    }
}
