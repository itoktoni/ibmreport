<?php

namespace Modules\Report\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Modules\Report\Dao\Facades\ProductFacades;
use Modules\Report\Dao\Facades\SupplierFacades;

class SoDetail extends Model
{
    use FilterQueryString;
    protected $connection= 'data';
    protected $table = 'order_detail';
    protected $primaryKey = 'detail';
    protected $keyType = 'string';

    protected $fillable = [
        'detail',
        'product',
        'price_prepare',
        'qty_prepare',
        'total_prepare',
    ];

    protected $filters = [
        'detail',
        'product'
    ];

    // public $with = ['has_product'];

    public $timestamps = false;
    public $incrementing = true;
    
    public function mask_so_code()
    {
        return 'detail';
    }

    public function setMaskSoCodeAttribute($value)
    {
        $this->attributes[$this->mask_so_code()] = $value;
    }

    public function getMaskSoCodeAttribute()
    {
        return $this->{$this->mask_so_code()};
    }    

    public function mask_product_id()
    {
        return 'product';
    }

    public function setMaskProductIdAttribute($value)
    {
        $this->attributes[$this->mask_product_id()] = $value;
    }

    public function getMaskProductIdAttribute()
    {
        return $this->{$this->mask_product_id()};
    }

    public function getMaskProductNameAttribute()
    {
        return $this->has_product->product_name;
    }

    public function mask_product_price()
    {
        return 'price_prepare';
    }

    public function setMaskProductPriceAttribute($value)
    {
        $this->attributes[$this->mask_product_price()] = $value;
    }

    public function getMaskProductPriceAttribute()
    {
        return $this->{$this->mask_product_price()};
    }

    public function mask_qty()
    {
        return 'qty_prepare';
    }

    public function setMaskQtyAttribute($value)
    {
        $this->attributes[$this->mask_qty()] = $value;
    }

    public function getMaskQtyAttribute()
    {
        return $this->{$this->mask_qty()};
    }

    public function mask_price()
    {
        return 'so_detail_price';
    }

    public function setMaskPriceAttribute($value)
    {
        $this->attributes[$this->mask_price()] = $value;
    }

    public function getMaskPriceAttribute()
    {
        return $this->{$this->mask_price()};
    }
    
    public function mask_total()
    {
        return 'total_prepare';
    }

    public function setMaskTotalAttribute($value)
    {
        $this->attributes[$this->mask_total()] = $value;
    }

    public function getMaskTotalAttribute()
    {
        return $this->{$this->mask_total()};
    }

    public function has_product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product');
    }
}
