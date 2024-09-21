<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\Models;
use App\Models\ProcessingType;
use App\Models\Product;
use App\Models\Status;
use App\Models\statuses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'productName' => $this->product->name,
            'productBrand' => Brand::find($this->product->id)->name,
            'productModel' => Models::find($this->product->id)->name,
            'userFullName' => $this->user->fullName,
            'orderDate' => $this->order_date,
            'deliveryDate' => $this->delivery_date,
            'cost' => $this->cost,
            'quantityProduct' => $this->quantityProduct,
            'statusName' => Status::find($this->status_id)->name,
            'processingTypeName' => ProcessingType::find($this->id)->name,
        ];
    }
}
