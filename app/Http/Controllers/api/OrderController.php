<?php

namespace App\Http\Controllers\api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\ConsumeOrderJob;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            $userId = $payload->get('sub');
            $orders = Order::with('product')->where('user_id', $userId)->get();

            return[
                "status" => 200,
                "message" => "Success get data",
                "data" => $orders
            ];
        } catch(\Exception $e){
            
            return[
               "status" => 400,
               "message" => "error",
               "data" => $e
           ];
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $order = Order::where('user_id', $id)->with('product')->get();
            
            return[
               "status" => 200,
               "message" => "Success get data",
               "data" => $order
           ];
        } catch(\Exception $e){
            
            return[
               "status" => 400,
               "message" => "error",
               "data" => $e
           ];
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
