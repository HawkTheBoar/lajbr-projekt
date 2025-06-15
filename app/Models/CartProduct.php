<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cart $cart
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CartProduct extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    /** @return BelongsTo<Cart, CartProduct> */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /** @return BelongsTo<Product, CartProduct> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
