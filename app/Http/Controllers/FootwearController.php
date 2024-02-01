<?php

namespace App\Http\Controllers;

use App\Models\Footwear;
use App\Http\Requests\StoreFootwearRequest;
use App\Http\Requests\UpdateFootwearRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FootwearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
        $Footwears = Footwear::Filter($request)->paginate(10);
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
            'title' => 'Footwear found',
            'message' => $Footwears,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $Footwear = new Footwear();
            $Footwear->type = $request->type;
            $Footwear->size =  $request->size;
            $Footwear->color = $request->color;
            $Footwear->material = $request->material;
            $Footwear->url = $request->url;
            $Footwear-> product_id = $request->product_id;

        if ($request->file){
            $path = Storage::putFile('public', $request->file);
            $link = env('APP_URL') . Storage::url($path);
            $Footwear['url'] = $link;
        }

            $Footwear->save();
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
            'message' => $Footwear,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
        $Footwear = Footwear::FindOrFail($id);
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
            'title' => 'Footwear found',
            'message' => $Footwear,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Footwear = Footwear::Find($id);
        if (!$Footwear){
            return response()->json([
            'message' => 'No es posible editar esté Footwear',
            ],422);
        }
        try{
            $Footwear->type = $request->type ?? $Footwear->type;
            $Footwear->size =  $request->size ?? $Footwear->size;
            $Footwear->color = $request->color ?? $Footwear->color;
            $Footwear->material = $request->material ?? $Footwear->material;
            $Footwear->url = $request->url ?? $Footwear->url;
            $Footwear-> product_id = $request->product_id ?? $Footwear-> product_id;
            $Footwear->save();
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
            'title' => 'Footwear update',
            'message' => $Footwear,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Footwear = Footwear::FindOrFail($id);
            $Footwear->delete();
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
            'message' => 'Footwear deleted',
        ]);
    }

    public function restore($id)
    {
        $Footwear = Footwear::Find($id);
        if ($Footwear){
            return response()->json([
            'message' => 'No es posible restaurar esté Footwear',
            ],422);
        }
        try {
            $Footwear = Footwear::withTrashed()->FindOrFail($id);
            $Footwear->restore();
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
        'title' => 'Footwear restore',
        'message' => $Footwear,
        ]);
    }
}
