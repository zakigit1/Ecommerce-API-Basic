<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Location;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orders = Order::with('user')->paginate(10);
        $orders = Order
            ::with(['user'=>function($q){
                return $q->select('id','name');
            }])
            ->with(['items' , 'items.product' => function($q) {
                $q->select('id','name as product_name');
            }])
            ->get();

        
        if(!$orders){
            return Response()->json([
                'message'=>'there is no order items'
            ],200);
        }
        

        foreach($orders as $order){
            foreach($order->items() as $order_items){
                $product = Product::where('id',$order_items->product_id)->pluck('name');
                $order_items->product_name = $product[0];
            }
        }

        // return $orders;
        return Response()->json([
            'orders' => $orders
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // return Auth::id();
        try{

            $location=Location::where('user_id',Auth::id())->first();

            DB::beginTransaction();

            $order = Order::create([
                'user_id'=>Auth::id(),
                'location_id'=>$location->id,
                'total_price'=>$request->total_price,//ykon m3a akhir 
                'date_of_delivery'=>$request->date_of_delivery,
            ]);

            // return $order;

            if($order){
                
                
                $orderItems_arr=[];

                foreach($request->order_items as $order_item){
                    $orderItems_arr[]=[
                        'order_id'=>$order->id,
                        'product_id'=>$order_item['product_id'] ,
                        'price'=>$order_item['price'] ,
                        'quantity'=>$order_item['quantity'] ,
                    ];  
                }
                // echo '<pre>';
                // print_r($orderItems_arr);
                // echo '</pre>';


                ############# inserting  Maincategory with other diffrent language ###########
                $order_items = OrderItem::insert($orderItems_arr);

                #####################
                //     $product = Product::where('id',$order_item->product_id)->first();
                //     return $product;

                //     $product->quantity = $product->quantity - $order_item->quantity;
                //     $product->amount = $product->amount - $order_item->quantity;
                //     $product->quantity -= $order_items->quantity;

                //     i need here to update the product amount i think 

                // return $order_items;
            }

            DB::commit();
            return Response()->json([
                'message'=>'Order Is Added!'
            ],201);

        }catch(\Exception $ex){

            DB::rollBack();
            return Response()->Json($ex);
        }






    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){

        $order = Order::with('user')->find($id);

        if(!$order){

            return Response()->json([
                'message'=>'Order Not Found!',
            ]);
        }

        return Response()->json([
            'order' => $order
        ],200);

    }
    

    public function get_order_items(int $id){

        $orderItems =Order::where('id',$id)->with('items')->get();

        // $orderItems = OrderItem::where('id',$id)
        // ->with('order')
        // ->get();

        if(!$orderItems){

            return Response()->json([
                'message'=>'Items Not Found!',
            ]);
        }


        return Response()->json([
            'orderItems' => $orderItems
        ],200);

    }


    public function get_user_orders(int $id){

        $userOrders=  User::where('id',$id)->with(['orders'=>function($q){
            $q->orderBy('created_at','desc');
        },'orders.items'])
        ->get();


        // $orders = Order::where('user_id',$id)
        // ::with(['user' =>function ($q){
        //     $q->orderBy('created_at','desc');
        // }])->get();

        if(!$userOrders){
            return Response()->json([
                'message'=>'there is no orders '
            ],200);
        }

        // this is mine
        // foreach($orders as $order){
        //     if(!$order->items){
        //         return Response()->json([
        //             'message'=>'there is no order items'
        //         ],200);
        //     }else{
        //         foreach($order->items as $order_item){
        //             $product = Product::where('id',$order_item->product_id)->pluck('name');
        //             $order_item->product_name = $product[0];
        //         }
        //     }
             
        // }



        return Response()->json([
            'userOrders' => $userOrders
        ],200);

        
    }


    public function change_order_status($id , Request $request){

        $request->validate([
            'status' => 'required|in:Pending,Out for Deliverd,Accepted,Deliverd,Canceled',
        ]);

        $order = Order::find($id);

        if(!$order){
            return Response()->json([
                'message'=>'Order Not Found!',
            ]);
        }
        // it is mine if dont work , use update function :
        $order['status']=$request->status;
        $order->save();

        return Response()->json([
            'message'=>'Order Status Changed!',
        ],200);
        
    }



}
