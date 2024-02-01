<?php

namespace App\Http\Controllers;

use App\Models\Detailcart;
use App\Http\Requests\StoreDetailcartRequest;
use App\Http\Requests\UpdateDetailcartRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DetailcartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
        $detailcarts = Detailcart::Filter($request)->paginate(10);
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'clients found',
            'message' => $detailcarts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailcartRequest $request)
    {
        try {
            $detailcart = new Detailcart();
            $detailcart->cart_id = $request->cart_id;
            $detailcart->product_id =  $request->product_id;
            $detailcart->quantity = $request->quantity;

            $detailcart->save();
        }
        catch(exception $e){
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'Successful registration',
            'message' => $detailcart,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Detailcart $detailcart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailcartRequest $request, Detailcart $detailcart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detailcart $detailcart)
    {
        //
    }
}
