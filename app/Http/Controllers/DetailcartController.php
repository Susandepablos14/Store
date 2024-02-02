<?php

namespace App\Http\Controllers;

use App\Models\Detailcart;
use App\Http\Requests\StoreDetailcartRequest;
use App\Http\Requests\UpdateDetailcartRequest;
use App\Models\Product;
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
    public function store(Request $request)
    {
        try {
            $detailcart = new Detailcart();

            $id = $request->product_id;
            $product = Product::find($id);
            $stock =  $product->stock;

            $quantity = $request->quantity;

            if($stock<$quantity){
                return response()->json([
                    'title' => 'Está cantidad no esta disponible',
                    'message' => $quantity,
                ]);
            }else{
                $detailcart->cart_id = $request->cart_id;
                $detailcart->product_id = $id;
                $detailcart->quantity = $quantity;
                $resta = $stock-$quantity;
                $product->stock = $resta;
                $product->save();
                $detailcart->save();
            }

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
    public function show($id)
    {
        try{
        $detailcart = Detailcart::FindOrFail($id);
        }
        catch(Exception $e){
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'detailcart found',
            'message' => $detailcart,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detailcart = Detailcart::Find($id);
        if (!$detailcart){
            return response()->json([
            'message' => 'No es posible editar esté detailcart',
            ],422);
        }
        try{
            $detailcart->cart_id = $request->cart_id ?? $detailcart->cart_id;
            $detailcart->product_id =  $request->product_id ?? $detailcart->product_id;
            $detailcart->quantity = $request->quantity ?? $detailcart->quantity;
            $detailcart->save();
        }
        catch (Exception $e) {
            return response()->json([
                'data' => [
                'code' => $e -> getCode(),
                'title' => 'Ha ocurrido un error porfavor intentelo más tarde',
                'errors' => $e->getMessage(),
            ]], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'title' => 'detailcart update',
            'message' => $detailcart,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $detailcart = Detailcart::FindOrFail($id);
            $detailcart->delete();
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
            'message' => 'detailcart deleted',
        ]);
    }

    public function restore($id)
    {
        $detailcart  = Detailcart ::Find($id);
        if ($detailcart){
            return response()->json([
            'message' => 'No es posible restaurar esté detailcart ',
            ],422);
        }
        try {
            $detailcart  = detailcart ::withTrashed()->FindOrFail($id);
            $detailcart ->restore();
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
        'title' => '$detailcart  restore',
        'message' => $detailcart ,
        ]);
    }
}
