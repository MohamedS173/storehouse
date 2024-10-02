<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Requests;
use App\Models\LogedUsers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showRequests(Request $request)
    {
        $goods = Goods::all(); // Fetch all goods
        $userRequests = Requests::all(); // Fetch all goods
        $logeedUser = LogedUsers::where('role', session()->get('role'))->get();
        if (session()->has('user_id')) {
            if(session()->get('role') == 'user'){
                return view('users', compact('goods', 'userRequests'))->with('loggedUser', $logeedUser);
            }elseif(session()->get('role') == 'manager'){
                return view('users', compact('goods', 'userRequests'))->with('loggedUser', $logeedUser);
            }
            elseif(session()->get('role') == 'storageman'){
                return redirect('/index');
            }
        }else{
            return view('login');
        }
    }

    public function getrequest(Request $request)
    {
        $goods = Goods::where('id', $request->goods_id)->first();
        // $userRequests = Requests::where('id', $request-> goods_id)->get();
        $arr = [
            'goods_id' => $goods->id,
            'item' => $goods->name
        ];
        return ($arr);
    }

    // Submit user request via AJAX
    public function submitRequest(Request $request)
    {
        $request->validate([
            'goods_id' => 'required|exists:goods,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $goods = Goods::where('id', $request-> goods_id)->first();

        $goodsid = $request->goods_id;
        if ($request->quantity > $goods->quantity) {
            return response()->json([
                'error' => 'Quantity is greater than available quantity'
            ]);
        } else {
            $user = new Requests;
            $user->goods_id = $goodsid;
            $user->quantity = $request->quantity;
            $user->status = 'pending';

            $user->save();
        

            return response()->json([
                'success' => 'Request submitted successfully',
               
            ]);
        }
    }
}
