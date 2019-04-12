<?php

namespace App\Http\Controllers;

use App\Mail\OrderCloseMail;
use App\Order;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with("products")->get();

        return view("orders.list", compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $partners = Partner::all();
        $statuses = config("statuses");
        return view("orders.edit", compact("order", 'partners', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'client_email' => 'required|email',
            'status' => 'required|in:0,10,20',
            'partner_id'=>"required|exists:partners,id"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                'errors'=>$validator->errors()
            ]);
        }
        $order->client_email = $request->client_email;
        $order->status = $request->status;
        $order->partner_id = $request->partner_id;
        $order->save();

        if($order->status=="20")
        {

            $partner = $order->partner?$order->partner->email:null;
            $vendors = $order->products->map(function ($p){

                return $p->vendor?$p->vendor->email:null;
            });

            $users = $vendors->push($partner)->filter();

            Mail::to($users)->send(new OrderCloseMail($order));
        }

        return back()->with("success", "Order has been saved");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
