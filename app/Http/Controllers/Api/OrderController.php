<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Получить список заказов текущего пользователя",
     *     tags={"Orders"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="total_price", type="number", format="float", example="1999.00"),
     *                 @OA\Property(property="comment", type="string", example="Позвонить за час"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="product_id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Карбонад"),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="price", type="number", format="float", example=799.00),
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getUserOrders(auth()->user());

        $response = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'total_price' => $order->total_price,
                'comment' => $order->comment,
                'created_at' => $order->created_at,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'name' => $item->product->name ?? null,
                        'quantity' => $item->quantity,
                        'price' => $item->price_at_order,
                    ];
                }),
            ];
        });

        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Создать заказ",
     *     tags={"Orders"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             ),
     *             @OA\Property(property="comment", type="string", example="Острый соус отдельно")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Заказ создан",
     *         @OA\JsonContent(
     *             @OA\Property(property="order_id", type="integer", example=12),
     *             @OA\Property(property="status", type="string", example="created")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Неавторизован")
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder(
            $request->user(),
            collect($request->validated()['products']),
            $request->validated()['comment'] ?? null
        );

        return response()->json([
            'order_id' => $order->id,
            'status' => 'created',
        ], 201);
    }
}
