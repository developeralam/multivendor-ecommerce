<?php

namespace App\Http\Controllers\Api;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\SellerResource;

use function App\Helpers\send_ms;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $sellers = Seller::verified()->withCount('products')->paginate($request->limit);
        return SellerResource::collection($sellers);
    }
    public function sellerProducts(Seller $slug, Request $request)
    {
        try {
            if ($request->sort == 'default') {
                $products = $slug->products()->paginate($request->show);
            } else {
                $products = $slug->products()->conditions($request->sort)->paginate($request->show);
            }
            return (new SellerResource($slug))
                ->additional(['products' => $products]);
        } catch (\Throwable $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
}
