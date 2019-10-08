<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Sweet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOrder;
use Auth;

class OrderController extends Controller
{
    public function index()
    {   //session()->flush('order');
        $date = date("Y-m-d");

        if (date('D') == 'Sun') { // controll if is sunday
            $date = date("Y-m-d", strtotime("+1 days"));
        }

        return view('objednat', ['today' => $date]);
    }

    public function prepare(Request $request)
    {
        $yesterday = date('d.m.Y', strtotime("-1 days"));
        
        $request->validate([
            'date' => 'required|after:' . $yesterday, // >= today
            'name' => 'required',
            'phone' => 'required',
        ]);

        if (date('w', strtotime($request->date)) == 0) {
            return redirect('/objednat')->with('error', 'Datum nesmí být neděle.');
        }
        
        $order = [
            'name' => $request->name,
            'phone' => $request->phone,
            'date' => $request->date,
            ];
        $request->session()->put('order', $order);  
        $request->session()->put('cart', []);
        
        return redirect()->action('OrderController@cart');
    }

    public function cart()
    {
        $orderSession = session()->get('order');
        if (!$orderSession) {// kontrola session uziv
            session()->flash('error', 'Vyplňte všechny informace.');
            return redirect()->action('OrderController@index');
        }
        $date = date("Y-m-d");

        /* sql
        SELECT sum(oi.count), s.id 
        FROM order_items oi
        INNER JOIN orders o ON oi.order_id = o.id
        INNER JOIN sweets s ON s.id = oi.sweet_id
        WHERE 1
        GROUP BY oi.sweet_id
        */
        /*
        $orders = DB::table('order_items')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->join('sweets', 'sweets.id', '=', 'order_items.sweet_id')
        ->select('sweets.id', 'sweets.name', DB::raw('SUM(order_items.count) as count'))
        ->whereDate('orders.order_date', $orderSession['date']) 
        ->groupBy('order_items.sweet_id')
        ->orderBy('sweets.id')
        ->get();  */
        $orders = $this->getOrders();  

        $s = DB::table('sweets')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

        for ($i = 0; $i < count($s); $i++) { //count amount of sweets
            foreach ($orders as $o) {
                if ($o->id == $s[$i]->id) {
                    $s[$i]->count -= $o->count; 
                }
            }
        }

        return view('objednavka', ['sweets' => $s]);
    }

    public function order() // -- polozky jsou v session kontrola poctu
    {
        $today = date("Y-m-d");
        $cart = session()->get('cart');
        $orderSession = session()->get('order');

        // kontrola...
        if (!$this->control()) { // nedostatek zakusku
            session()->forget('order');
            session()->forget('cart');
            
            return redirect('/objednat')->with('error', 'Objednávka se nezdařila. Zkuste to znovu.');
        }

        $totalPrice = 0;
        foreach(session('cart') as $id => $row) {
            $totalPrice += $row['price'] * $row['quantity'];
        }

        // store new order
        $o = new Order; 
        $o->name = $orderSession['name'];
        $o->phone = $orderSession['phone'];
        $o->order_date = $orderSession['date'];
        $o->price = $totalPrice;
        if (Auth::user()) {
            $o->active = 0;
        }
        $o->save();

        //find id of new order
        $newOrderId = DB::table('orders')
        ->select('id')
        ->where([
            ['name', $orderSession['name']],
            ['phone', $orderSession['phone']],
            ['order_date', $orderSession['date']],
            ['price', $totalPrice],
        ])
        ->whereDate('created_at', $today)
        ->get();      

        if (!$newOrderId) {
            //objednavka neexistuje
            return redirect('/objednat')->with('error', 'Objednávka se neuložila. Zkuste to znovu.');
        }
            Mail::to('test@seznam.cz')->send(new SendOrder($newOrderId[0]->id, $orderSession['name'], $orderSession['phone'], $orderSession['date']));
        
        //transaction
        DB::beginTransaction(); 

        try {
            foreach(session('cart') as $c) {
                DB::insert('insert into order_items (sweet_id, order_id, count) values (?, ?, ?)', [$c['id'], $newOrderId[0]->id, $c['quantity']]);
            } 
            
            DB::commit();
                        
            session()->flash('success', 'Objednávka uložena.');
            // mail
            
        } catch (\Throwable $th) {
            DB::rollBack();

            session()->forget('order');
            session()->forget('cart');

            //return redirect('/objednat')->with('error', 'Objednávka se neuložila. Zkuste to znovu.');
        }
        // ?? bude potreba u brany
        session()->forget('order');
        session()->forget('cart');
        // potvrzeni objednavky, faktura
        // obchodní podmínky
        // pokud registrace - Úřadu pro ochranu osobních údajů
        // cookies je třeba uchovávat

        if (Auth::user()) {
            return redirect('/administrace')->with('success', 'Objednávka byla přijata.');
        } else {
            return redirect('/home')->with('success', 'Objednávka byla přijata.'); //brana
        }
    }

    public function addToCart(Request $request, $id) // add sweet into cart
    {
        $sweet = DB::table('sweets')->where('id', $id)->get();
        $cart = session()->get('cart');

        if (!$cart) { // cart is empty
            $cart = [
                $sweet[0]->id => [
                    'id' => $sweet[0]->id,
                    'name' => $sweet[0]->name,
                    'quantity' => $request->number,
                    'price' => $sweet[0]->price,
                    ]
                ];
            $request->session()->flash('success', 'Přidáno do košíku.');
            $request->session()->put('cart', $cart);
            
        } else {

            if (isset($cart[$sweet[0]->id])) { // sweet exists in cart
                $cart[$id]['quantity'] += $request->number; 
                session()->put('cart', $cart);
                $request->session()->flash('success', 'Přidáno do košíku.');
                return redirect()->action('OrderController@cart');
                //return response()->json(['success' => 'Přidáno do košíku.']);
            }

            $cart[$id] = [ // add sweet to cart
                'id' => $sweet[0]->id,
                'name' => $sweet[0]->name,
                'quantity' => $request->number,
                'price' => $sweet[0]->price,
            ];
     
            session()->put('cart', $cart);
            session()->flash('success', 'Přidáno do košíku.');
        }
        //return response()->json(['success' => 'Přidáno do košíku.']);
        return redirect()->action('OrderController@cart');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->put('cart', $cart);
        
        return redirect()->action('OrderController@cart')->with('success', 'Zboží odebráno.');
    }

    public function getOrders()
    {
        $orderSession = session()->get('order');

        return DB::table('order_items')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->join('sweets', 'sweets.id', '=', 'order_items.sweet_id')
        ->select('sweets.id', 'sweets.name', DB::raw('SUM(order_items.count) as count'))
        ->whereDate('orders.order_date', $orderSession['date']) 
        ->groupBy('order_items.sweet_id')
        ->orderBy('sweets.id')
        ->get();
    }

    public function control() // todo test
    {
        $cart = session()->get('cart');
        $orders = $this->getOrders();  
        echo 'orders: ';
        print_r ($orders);

        echo '<br><br>cart: ';
        print_r ($cart); // array
        $sweets = DB::table('sweets')
        ->where('active', 1)
        ->orderBy('id')
        ->get();
        
        foreach($sweets as $s) {
            if (count($orders) > 0) {
                foreach ($orders as $o) {
                    if($o->id == $s->id) { // - orderred + in cart
                        $s->count -= $o->count;
                        if (isset($cart[$s->id])) {
                            $s->count -= $cart[$s->id]['quantity'];
                            if ($s->count < 0) {
                                return false;
                            }
                        }
                    }
                }
            } else {
                if (isset($cart[$s->id])) {
                    $s->count -= $cart[$s->id]['quantity'];
                    if ($s->count < 0) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}
