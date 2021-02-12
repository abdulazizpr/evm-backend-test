<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    /**
     * Status Enum
    */
    const CHECKOUT_STATUS = 'checkout';
    const PAID_STATUS = 'paid';

    /**
     * Collection status
     *
    */
    const STATUSES = [
        self::CHECKOUT_STATUS,
        self::PAID_STATUS,
    ];

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
        'order_number',
        'total_quantities',
        'total',
        'status',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
    */
    public static function boot(): void
    {
        parent::boot();
        static::generateOrderNumber();
    }

    /**
     * Model relationship definition.
     * Order has many OrderItems.
     *
     * @return HasMany
    */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Set checkout status
     *
     * @return void
    */
    public function setCheckout(): void
    {
        $this->status = self::CHECKOUT_STATUS;
        $this->save();
    }

    /**
     * Set paid status
     *
     * @return void
    */
    public function setPaid(): void
    {
        $this->status = self::PAID_STATUS;
        $this->save();
    }

    /**
     * Status is checkout
     *
     * @return bool
    */
    public function isCheckout(): bool
    {
        return $this->status === self::CHECKOUT_STATUS;
    }

    /**
     * Status is paid
     *
     * @return bool
    */
    public function isPaid(): bool
    {
        return $this->status === self::PAID_STATUS;
    }

    /**
     * Reduce all stock product from order items
     *
     * @return void
    */
    public function reduceAllProductStocks(): void
    {
        foreach ($this->orderItems as $orderItem) {
            if ($orderItem instanceof OrderItem) {
                $orderItem->reduceStockToProduct();
            }
        }
    }

    /**
     * Proccess checkout
     *
     * @return void
    */
    public function proccessCheckout()
    {
        $this->total_quantities = $this->orderItems->sum('qty');
        $this->total = $this->orderItems->sum('subtotal');

        $this->setCheckout();
    }

    /**
     * Method static for generate order number.
     *
     * @return void
    */
    protected static function generateOrderNumber(): void
    {
        self::creating(function ($model) {
            $model->order_number = Carbon::now()->format('ymdHis').Str::upper(Str::random(6));
        });
    }
}