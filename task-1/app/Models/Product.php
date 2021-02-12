<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        'sku',
        'name',
        'stock',
        'price',
    ];

    /**
     * Reduce stock
     *
     * @param int $qty
     *
     * @return void
    */
    public function reduceStock(int $qty): void
    {
        $this->stock -= $qty;
        $this->save();
    }
}