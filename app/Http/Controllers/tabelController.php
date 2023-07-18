<?php

namespace App\Http\Controllers;

use App\Models\Tabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class tabelController extends Base
{

    public function get_all_tabel()
    {
        $tabel_true = Tabel::select('number')->where('status', 'free')->get();
        return response()->json('true');
    }
    public function checktabel(Request $request, Tabel $t)
    {
        $input = $request->all();
        $validateor = Validator::make($input, [
            'number' => 'required',
            'password' => 'required',
        ]);
        if ($validateor->fails()) {
            return $this->sendError('pleas validate error', $validateor->errors());
        }
        $tabel = Tabel::select('id')->where('number', $request->input('number'))->where('status', 'free')->value('id');
        $t_password = Tabel::select('password')->where('number', $input['number'])->value('password');

        $pass = $input['password'];
        if (($pass === $t_password) && ($tabel)) {
            $t = Tabel::find($tabel);
            $t->status = "close";
            $t->save();
            return response()->json([
                'message' => 'successfully update tabel',
                'status' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'error in update tabel',
                'status' => false,
            ]);
        }

    }
}
