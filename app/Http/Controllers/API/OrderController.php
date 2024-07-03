<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaOrder' => 'string|max:255',
            'layanan' => 'string|max:255',
            'jumlah' => 'numeric',
            'harga' => 'numeric',
            'customers_id' => [
                'nullable',
                Rule::exists(Customer::class, 'id')->where(function ($query) use ($request) {
                    $query->where('nama', $request->nama);
                })
            ]
        ]);
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'namaOrder' => 'string|max:255',
            'layanan' => 'string|max:255',
            'jumlah' => 'numeric',
            'harga' => 'numeric',
            'customer_id' => [
                'nullable',
                Rule::exists(Customer::class, 'id')->where(function ($query) use ($request) {
                    $query->where('nama', $request->nama);
                })
            ]
        ]);

        $order->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }


    /**
     * Remove the specified order from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ], 204);
    }

}
