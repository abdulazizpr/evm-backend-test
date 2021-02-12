<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
    */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
    */
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'qty',
    ];

    /**
     * Model relationship definition.
     * Order Item belongs to Order.
     *
     * @return BelongsTo
    */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Model relationship definition.
     * Order Item belongs to Product.
     *
     * @return BelongsTo
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Reduce stock to product
     *
     * @return void
    */
    public function reduceStockToProduct(): void
    {
        if ($this->product instanceof Product) {
            $this->product->reduceStock($this->qty);
        }
    }
}