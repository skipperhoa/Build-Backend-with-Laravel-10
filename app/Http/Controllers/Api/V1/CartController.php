<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;
class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->middleware('auth:api');
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //api/v1/carts
        $carts = $this->cartService->getCarts_v2();
        return response()->json([
            'status' => 200,
            'data' => $carts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //api/v1/carts metho POST (thêm)
        return $this->cartService->add_cart_v2($request->id, $request->quantity ?? 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        // xoa 1 san pham trong gio hang
        return $this->cartService->remove($id);
    }
}
