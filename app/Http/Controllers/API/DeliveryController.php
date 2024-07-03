<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::all();
        return response()->json(['data' => $deliveries], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'orders_id' => 'required|exists:orders,id',
            'opsi' => 'required|string',
            'tgl_msk' => 'required|date',
            'tgl_klr' => 'required|date',
        ]);

        $delivery = Delivery::create([
            'orders_id' => $request->orders_id,
            'opsi' => $request->opsi,
            'tgl_msk' => $request->tgl_msk,
            'tgl_klr' => $request->tgl_klr,
        ]);

        return response()->json(['data' => $delivery], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        return response()->json(['data' => $delivery], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'orders_id' => 'required|exists:orders,id',
            'opsi' => 'required|string',
            'tgl_msk' => 'required|date',
            'tgl_klr' => 'required|date',
        ]);

        $delivery->update([
            'orders_id' => $request->orders_id,
            'opsi' => $request->opsi,
            'tgl_msk' => $request->tgl_msk,
            'tgl_klr' => $request->tgl_klr,
        ]);

        return response()->json(['data' => $delivery], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return response()->json(['message' => 'Delivery deleted successfully'], 200);
    }
}
