<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\WishlistResource;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\send_ms;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlists = Auth::guard('user-api')->user()->wishlistPorducts()->get();
        return WishlistResource::collection($wishlists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('user-api')->user();
        $product_count = $user->wishlistPorducts()->where('product_id', $request->product_id)->count();
        if ($product_count > 0) {
            $user->wishlistPorducts()->detach($request->product_id);
            return send_ms('Product removed from wishlist', true, 200);
        } else {
            $user->wishlistPorducts()->attach($request->product_id);
            return send_ms('Product added to wishlist', true, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }
}
