<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $products = Product::with('brand', 'clothe')->filter($request)->paginate(10);
        } catch (Exception  $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->brand_id = $request->brand_id;

            $product->save();
        }  catch (Exception $e) {
                return response()->json([
                    'data' => [
                        'code'   => $e->getCode(),
                        'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                        'errors' => $e->getMessage(),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        return response()->json([
            'message'    => 'Registrado exitosamente',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = product::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Hola',
            'response'   => $product,
        ]); ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product){
            return response()->json([
                'errors' => [
                    'message'   => 'No se encontro esta marca',
                ]
            ], 422);
        }
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name ?? $product->name;
            $product->description = $request->description ?? $product->description;
            $product->price = $request->price ?? $product->price;
            $product->stock = $request->stock ?? $product->stock;
            $product->brand_id = $request->brand_id ?? $product->brand_id;

            $product->save();
            $response = Product::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Registro Actualizado exitosamente',
            'response'   => $response,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'message'    => 'Registro Borrado exitosamente',
        ]);
    }

    public function restore($id)
    {
        $product = product::find($id);
        if ($product){
            return response()->json([
                'errors' => [
                    'message'   => 'Esta marca no se encuentra eliminada',
                ]
            ], 422);
        }
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();

        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };

        return response()->json([
            'message'    => 'Restaurado exitosamente',
        ]);
    }
}
