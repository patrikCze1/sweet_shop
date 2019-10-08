<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Sweet;
use Illuminate\Support\Facades\DB;

class AdministrativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $date = date("Y-m-d");

        $orders = DB::table('orders')
        ->whereDate('order_date', $date) 
        ->orderBy('active', 'desc')
        ->get();
  
        $availableSweet = $this->getAvailableSweet(); 

        $sweets = DB::table('sweets')->get();

        return view('admin.index', ['orders' => $orders, 'sweets' => $sweets, 'availableSweet' => $availableSweet]);
    }

    public function detail($id)
    {
        $order = Order::find($id);

        $date = date("Y-m-d");

        $items = DB::table('order_items')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->join('sweets', 'sweets.id', '=', 'order_items.sweet_id')
        ->select('sweets.name AS sweet', 'order_items.count AS count', 'orders.name AS name', 'orders.phone AS phone', 'orders.price AS price')
        ->whereDate('orders.order_date', $date) 
        ->where('orders.id', $id)
        ->orderBy('order_items.order_id')
        ->get();

        return view('admin.detail', ['order' => $order, 'items' => $items]);
    }

    public function deactivate(Request $request)
    {
        $order = Order::find($request->id);
        $order->active = 0;
        $order->save();

        return redirect('/administrace')->with('success', 'Objednávka byla změněna');
    }

    public function buy(Request $request)
    {/*
        $today = date("Y-m-d");

        $sweets = DB::table('sweets')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

        $i = 1;
        $totalPrice = 0;
        foreach($sweets => $s) {
            if ($s->id == $request->$i) {
                $totalPrice += $row['price'] * $row['quantity'];
            }
            
            $i++;
        }

        // store new order
        $o = new Order; 
        $o->name = 'Admin';
        $o->phone = '123456789';
        $o->order_date = $today;
        $o->price = $totalPrice;
        $o->save();*/
    }

    public function getAvailableSweet()
    {
        $today = date("Y-m-d");

        $orders = DB::table('order_items')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->join('sweets', 'sweets.id', '=', 'order_items.sweet_id')
        ->select('sweets.id', 'sweets.name', 'sweets.price', DB::raw('SUM(order_items.count) as count'))
        ->whereDate('orders.order_date', $today) 
        ->groupBy('order_items.sweet_id')
        ->orderBy('sweets.id')
        ->get();

        $s = DB::table('sweets')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

        for($i = 0; $i < count($s); $i++) { //count amount of sweets
            foreach ($orders as $o) {
                if($o->id == $s[$i]->id) {
                    $s[$i]->count -= $o->count; 
                }
            }
        }

        return $s;
    }
}
