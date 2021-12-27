<?php

namespace Modules\Report\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Plugins\Helper;

class Product extends Model
{
    protected $connection= 'data';
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'product_code',
        'product_grouping',
        'product_name',
        'product_images',
        'product_harga_beli',
        'product_harga_jual',
        'product_category',
        'product_segmentasi',
        'product_description',
        'product_unit',
        'product_size',
        'product_stock',
        'created_at',
        'updated_at',
        'product_weight',
        'product_commision',
        'product_material',
    ];

    // public $with = ['module'];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'product_name' => 'required|min:3',
        'product_sku' => 'unique:product',
        'product_buy' => 'required',
        'product_sell' => 'required',
    ];

    protected $casts = [
        'product_buy' => 'integer',
        'product_sell' => 'integer',
        'product_price' => 'integer',
        'product_tax_code' => 'string',
    ];

    public $searching = 'product_name';
    public $datatable = [
        'product_id' => [true => 'Code', 'width' => 50],
        'product_name' => [true => 'Name'],
        'product_harga_beli' => [true => 'Buy', 'width' => 100],
        'product_harga_jual' => [true => 'Sell', 'width' => 100],
        'product_description' => [false => 'Image'],
    ];

    public function mask_name()
    {
        return 'product_name';
    }

    public function setMaskNameAttribute($value)
    {
        $this->attributes[$this->mask_name()] = $value;
    }

    public function getMaskNameAttribute()
    {
        return $this->{$this->mask_name()};
    }

    public function mask_price()
    {
        return 'product_price';
    }

    public function setMaskPriceAttribute($value)
    {
        $this->attributes[$this->mask_price()] = $value;
    }

    public function getMaskPriceAttribute()
    {
        return $this->{$this->mask_price()};
    }

    public function getMaskPriceFormatAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_price()});
    }

    public function mask_buy()
    {
        return 'product_buy';
    }

    public function setMaskBuyAttribute($value)
    {
        $this->attributes[$this->mask_buy()] = $value;
    }

    public function getMaskBuyAttribute()
    {
        return $this->{$this->mask_buy()};
    }

    public function getMaskBuyFormatAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_buy()});
    }

    public function mask_sell()
    {
        return 'product_sell';
    }

    public function setMaskSellAttribute($value)
    {
        $this->attributes[$this->mask_sell()] = $value;
    }

    public function getMaskSellAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_sell()});
    }

    public function getMaskSellFormatAttribute()
    {
        return $this->{$this->mask_sell()};
    }

    public function mask_category_id()
    {
        return 'product_category_id';
    }

    public function setMaskCategoryIdAttribute($value)
    {
        $this->attributes[$this->mask_category_id()] = $value;
    }

    public function getMaskCategoryIdAttribute()
    {
        return $this->{$this->mask_category_id()};
    }

    public function mask_supplier_id()
    {
        return 'product_supplier_id';
    }

    public function setMaskSupplierIdAttribute($value)
    {
        $this->attributes[$this->mask_supplier_id()] = $value;
    }

    public function getMaskSupplierIdAttribute()
    {
        return $this->{$this->mask_supplier_id()};
    }

    public function mask_description()
    {
        return 'product_description';
    }

    public function setMaskDescriptionAttribute($value)
    {
        $this->attributes[$this->mask_description()] = $value;
    }

    public function getMaskDescriptionAttribute()
    {
        return $this->{$this->mask_description()};
    }

    public static function boot()
    {
        parent::saving(function ($model) {
            $file_name = 'file';
            if (request()->has($file_name)) {
                $file = request()->file($file_name);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->product_image = $name;
            }
            $model->product_price = $model->product_sell + (($model->product_sell * $model->product_tax_code) / 100);
        });

        parent::boot();
    }
}
