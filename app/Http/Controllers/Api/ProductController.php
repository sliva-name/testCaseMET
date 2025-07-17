<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Получить список товаров",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Список товаров",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Карбонад"),
     *                 @OA\Property(property="description", type="string", example="Свежее мясо высшего сорта"),
     *                 @OA\Property(property="price", type="number", format="float", example=799.00),
     *                 @OA\Property(property="category", type="string", example="Свинина"),
     *                 @OA\Property(property="in_stock", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $products = Product::select('id', 'name', 'description', 'price', 'category', 'in_stock')->get();
        return response()->json($products);
    }
}
