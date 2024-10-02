<?php

namespace App\Http\Controllers;
use App\Models\Goods;
use App\Models\User;
use App\Models\LogedUsers;
use App\Models\Requests;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Termwind\Components\Raw;

class GoodsController extends Controller
{
    //

    public function index()
    {
        $users=Goods::all();
        $logeedUser = LogedUsers::where('role', session()->get('role'))->get();
        if (session()->has('user_id')) {
            if(session()->get('role') == 'user'){
                return redirect('/user-requests');
            }elseif(session()->get('role') == 'manager'){
                return view('index', compact('users'))->with('loggedUser', $logeedUser);
            }
            elseif(session()->get('role') == 'storageman'){
                return view('index', compact('users'))->with('loggedUser', $logeedUser);
            }
        }else{
            return view('login');
        }
       
    }

    
    public function addtype(Request $request)
    {
        $user = new Goods();
        $user->name = $request->input('type');
        $user->quantity = 0;
        $status = $user->quantity >= 0 ? 'add' : 'take';
        $user->save();
        Transaction::create([
            'goods_id' => $user->id,
            'quantity_change' => abs($user->quantity),
            'status' => $status,
        ]);
        return redirect()->back()->with('status', 'Item Added Successfully');
    }
    
    public function add(Request $request)
    {
        $find_id=$request->items;
        // $user=Goods::find($request->items);
        $user = Goods::where('id',$find_id)->first();
        // dd($user->quantity);
        $data= $request->except('_token', 'items');
        $status = $request->quantity >= 0 ? 'add' : 'take';
        $user->quantity += $request->quantity;
        $user->update($data);
        Transaction::create([
            // dd($request->user_id),
            'goods_id' => ($user->id),
            'quantity_change' => abs($user->quantity),
            'status' => $status,
        ]);
        return redirect()->back()->with('status', 'Item Added Successfully');
    }

    public function show(Request $request)
    {
        $user = Goods::find($request->user_id);
        $arr = [
            'user_id' => $user->id,
            'name_change' => $user->name,
            'quantity_change' => $user->quantity,
        ];
        return ($arr);
    }

    public function show2(Request $request)
    {
        $user = Goods::find($request->user_id);
        $arr = [
            'usert_id' => $user->id,
            'name_change' => $user->name,
            'quantity_change' => $user->quantity,
        ];
        return ($arr);
    }

    public function additem(Request $request)
    {
        $user_id = $request->user_id;
        $goods = Goods::where('id',$user_id)->first();
        
        $data= $request->except('_token','user_id');
        $quantityChange = $request-> quantity_change;
        $status = 'add' ;

        // Update the goods quantity
        // dd($request);
        $goods->quantity += $quantityChange;
        // $goods->save();
        $goods->update($data);

        // Create a transaction record
        Transaction::create([
            'goods_id' => $goods->id,
            'quantity_change' => abs($quantityChange),
            'status' => $status,
        ]);

        return response()->json(['success' => true, 'new_quantity' => $goods->quantity]);
    }

    public function takeitem(Request $request)
    {
        $user_id = $request->usert_id;
        $goods = Goods::where('id',$user_id)->first();
        
        $data= $request->except('_token','usert_id');
        // dd($request);
        $quantityChangetake =  $request-> quantity_change;
        $status = 'take';
        // dd($request);


        // Update the goods quantity
        $goods->quantity -= $quantityChangetake;
        // dd($goods->quantity);
        // $goods->save();
        $goods->update($data);
        // Create a transaction record
        Transaction::create([
            'goods_id' => $goods->id,
            'quantity_change' => abs($quantityChangetake),
            'status' => $status,
        ]);


        return response()->json(['success' => true, 'new_quantity' => $goods->quantity]);
    }

    public function destory($id)
    {
        $user = Goods::where('id', $id);
        $transaction = Transaction::where('goods_id', $id);

        if ($user && $transaction) {
            $user->delete($id);
            $transaction->delete($id);
            return redirect()->back()->with('status', 'item deleted Successfully');
        }
        
        
        return redirect()->back()->with('status', 'Error: item not found');
    }


    // public function add(Request $request)
    // {
    //     $user = new Goods();
    //     $user->name = $request->input('name');
    //     $user->quantity = $request->input('quantity');
    //     $status = $user->quantity > 0 ? 'add' : 'take';
    //     $user->save();
    //     Transaction::create([
    //         'goods_id' => $user->id,
    //         'quantity_change' => abs($user->quantity),
    //         'status' => $status,
    //     ]);
    //     return redirect()->back()->with('status', 'Item Added Successfully');
    // }

    // public function show(Request $request)
    // {
    //     $user = Goods::find($request->user_id);
    //     $arr = [
    //         'user_id' => $user->id,
    //         'name_change' => $user->name,
    //         'quantity_change' => $user->quantity,
    //     ];
    //     return ($arr);
    // }

    // public function show2(Request $request)
    // {
    //     $user = Goods::find($request->user_id);
    //     $arr = [
    //         'usera_id' => $user->id,
    //         'name_change' => $user->name,
    //         'quantity_change' => $user->quantity,
    //     ];
    //     return ($arr);
    // }

    // public function show3(Request $request)
    // {
    //     $user = Goods::find($request->user_id);
    //     $arr = [
    //         'usert_id' => $user->id,
    //         'name_change' => $user->name,
    //         'quantity_change' => $user->quantity,
    //     ];
    //     return ($arr);
    // }

    // public function edit(Request $request)
    // {
    //     $user_id = $request->user_id;
    //     $goods = Goods::where('id',$user_id);
        
    //     $data= $request->except('_token','user_id');
    //     $quantityChange = $request-> quantity_change;
    //     $status = $quantityChange > 0 ? 'add' : 'take';
    //     $quantityChange = $status == 'add' ? abs($quantityChange) : -abs($quantityChange);

    //     // Update the goods quantity
    //     // dd($request);
    //     $goods->quantity = $quantityChange;
    //     // $goods->save();
    //     $goods->update($data);

    //     // Create a transaction record
    //     Transaction::create([
    //         'goods_id' => $goods->id,
    //         'quantity_change' => abs($quantityChange),
    //         'status' => $status,
    //     ]);

    //     return response()->json(['success' => true, 'new_quantity' => $goods->quantity]);
    // }

    // public function additem(Request $request)
    // {
    //     $user_id = $request->usera_id;
    //     $goods = Goods::where('id',$user_id)->first();
        
    //     $data= $request->except('_token','usera_id');
    //     $quantityChange = $request-> quantity_change;
    //     $status = 'add' ;

    //     // Update the goods quantity
    //     // dd($request);
    //     $goods->quantity += $quantityChange;
    //     // $goods->save();
    //     $goods->update($data);

    //     // Create a transaction record
    //     Transaction::create([
    //         'goods_id' => $goods->id,
    //         'quantity_change' => abs($quantityChange),
    //         'status' => $status,
    //     ]);

    //     return response()->json(['success' => true, 'new_quantity' => $goods->quantity]);
    // }

    // public function takeitem(Request $request)
    // {
    //     $user_id = $request->usert_id;
    //     $goods = Goods::where('id',$user_id)->first();
        
    //     $data= $request->except('_token','usert_id');
    //     // dd($request);
    //     $quantityChangetake =  $request-> quantity_change;
    //     $status = 'take';
    //     // dd($request);


    //     // Update the goods quantity
    //     $goods->quantity -= $quantityChangetake;
    //     // $goods->save();
    //     $goods->update($data);

    //     // Create a transaction record
    //     Transaction::create([
    //         'goods_id' => $goods->id,
    //         'quantity_change' => abs($quantityChangetake),
    //         'status' => $status,
    //     ]);

    //     return response()->json(['success' => true, 'new_quantity' => $goods->quantity]);
    // }

    // public function destory($id)
    // {
    //     $user = Goods::where('id', $id);
    //     $transaction = Transaction::where('goods_id', $id);

    //     if ($user && $transaction) {
    //         $user->delete($id);
    //         $transaction->delete($id);
    //         return redirect()->back()->with('status', 'item deleted Successfully');
    //     }
        
        
    //     return redirect()->back()->with('status', 'Error: item not found');
    // }


}
