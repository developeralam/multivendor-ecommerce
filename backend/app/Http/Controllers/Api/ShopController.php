<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->show;
        $condition = $request->sort;
        $brandIds = $request->brand;
        $catIds = $request->category;
        $price_range = $request->price_range;

        $products = Product::latest()
            ->when($condition != 'default', function ($query) use ($condition) {
                return $query->conditions($condition);
            })
            ->when($brandIds, function ($query) use ($brandIds) {
                return $query->whereIn('brand_id', $brandIds);
            })
            ->when($catIds, function ($query) use ($catIds) {
                return $query->whereIn('category_id', $catIds);
            })
            ->when($price_range, function ($query) use ($price_range) {
                $min_price = $price_range[0];
                $max_price = $price_range[1];
                return $query->whereBetween('price', [$min_price, $max_price]);
            })
            ->paginate($limit);

        // if ($request->sort == 'default') {
        //     $products = Product::latest()->paginate($request->show);
        // } else {
        //     $products = Product::latest()->conditions($request->sort)->paginate($request->show);
        // }
        return new ShopResource($products);
    }
    public function sidebar()
    {
        $min_price = Product::min('price');
        $max_price = Product::max('price');
        $brands = Brand::withCount('products')->status('active')->get();
        $category = Category::withCount('products')->status('active')->get();
        return new ShopResource([
            'brands' => $brands,
            'category' => $category,
            'price' => [
                'min_price' => $min_price,
                'max_price' => $max_price,
            ],
        ]);
    }
}
