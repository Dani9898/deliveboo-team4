<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Order;
use App\User;

class ChartController extends Controller
{
    public function getOrdersMonth() {
        
        $user = Auth::user();

        $janOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-01-01"), date("2022-01-31")]) 
        -> get();

        $febOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-02-01"), date("2022-02-28")]) 
        -> get();

        $marchOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-03-01"), date("2022-03-31")]) 
        -> get();

        $aprilOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-04-01"), date("2022-04-30")]) 
        -> get();

        $mayOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-05-1"), date("2022-05-31")]) 
        -> get();

        $juneOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-06-01"), date("2022-06-30")]) 
        -> get();

        $julyOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-07-01"), date("2022-07-31")]) 
        -> get();

        $augustOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-08-01"), date("2022-08-31")]) 
        -> get();

        $sepOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-09-01"), date("2022-09-30")]) 
        -> get();

        $octOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-10-01"), date("2022-10-31")]) 
        -> get();
    
        $novOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-11-01"), date("2022-11-30")]) 
        -> get();

        $decOrders = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-12-01"), date("2022-12-31")]) 
        -> get();

        $orders = [
            'ordGen' => $janOrders,
            'ordFeb' => $febOrders,
            'ordMar' => $marchOrders,
            'ordApr' => $aprilOrders,
            'ordMag' => $mayOrders,
            'ordGiu' => $juneOrders,
            'ordLug' => $julyOrders,
            'ordAgo' => $augustOrders,
            'ordSet' => $sepOrders,
            'ordOtt' => $octOrders,
            'ordNov' => $novOrders,
            'ordDic' => $decOrders,
        ];

        return json_encode($orders);

    }

    public function getOrdersYear() {
        
        $user = Auth::user();

        $orders2018 = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2018-01-01"), date("2018-12-31")]) 
        -> get();

        $orders2019 = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2019-01-01"), date("2019-12-31")]) 
        -> get();

        $orders2020 = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2020-01-01"), date("2020-12-31")]) 
        -> get();

        $orders2021 = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2021-01-01"), date("2021-12-31")]) 
        -> get();

        $orders2022 = DB::table('orders') 
        -> join('dish_order', 'orders.id', '=', 'dish_order.order_id') 
        -> join('dishes', 'dish_order.dish_id', '=', 'dishes.id') 
        -> where('dishes.user_id', $user -> id)
        -> wherebetween('orders.date', [date("2022-01-01"), date("2022-12-31")]) 
        -> get();

     
        $orders = [
            'ord2018' => $orders2018,
            'ord2019' => $orders2019,
            'ord2020' => $orders2020,
            'ord2021' => $orders2021,
            'ord2022' => $orders2022,
        ];

        return json_encode($orders);
    }

    public function statistics(){
        return view('pages.orders-statistics');
    }
}


// SELECT *
// FROM orders
// JOIN dish_order
// ON orders.id = dish_order.order_id
// JOIN dishes
// ON dish_order.dish_id = dishes.id
// WHERE dishes.user_id = 9 AND orders.created_at 
// BETWEEN '2022-03-1' AND '2022-03-31';


