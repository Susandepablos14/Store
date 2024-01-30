<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $brands = Brand::with('product')->filter($request)->paginate(10);
        } catch (Exception  $e) {
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  =>'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.',
                    'errors' => $e->getMessage(),
            ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $brands;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $brand = new Brand();
            $brand->name = $request->name;

            $brand->save();
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
            $brand = Brand::findOrFail($id);
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
            'response'   => $brand,
        ]); ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand){
            return response()->json([
                'errors' => [
                    'message'   => 'No se encontro esta marca',
                ]
            ], 422);
        }
        try {
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name ?? $brand->name;

            $brand->save();
            $response = Brand::find($id);
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
            $brand = Brand::findOrFail($id);
            $brand->delete();

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
        $brand = Brand::find($id);
        if ($brand){
            return response()->json([
                'errors' => [
                    'message'   => 'Esta marca no se encuentra eliminada',
                ]
            ], 422);
        }
        try {
            $brand = Brand::withTrashed()->findOrFail($id);
            $brand->restore();

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
