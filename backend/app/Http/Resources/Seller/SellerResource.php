<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'banner' => $this->banner,
            'shop_name' => $this->shop_name,
            'products_count' => $this->whenCounted('products'),
            // 'products' => $this->when($request->slug, SellerProductResource::collection($this->products)),
            'slug' => $this->slug,
            'address' => $this->address,
        ];
    }
}
