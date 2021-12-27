<?php

namespace Modules\Report\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Production extends Model
{
    protected $connection= 'data';
    protected $table = 'productions';
    protected $primaryKey = 'production_id';

    protected $fillable = [
        'production_id',
        'production_name',
        'production_description',
    ];

    // public $with = ['module'];

    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
        'production_name' => 'required|min:3',
    ];

    public $searching = 'production_name';
    public $datatable = [
        'production_id' => [false => 'Code', 'width' => 50],
        'production_name' => [true => 'Name'],
        'production_description' => [true => 'Description'],
    ];

    public function mask_name()
    {
        return 'production_name';
    }

    public function setMaskNameAttribute($value)
    {
        $this->attributes[$this->mask_name()] = $value;
    }

    public function getMaskNameAttribute()
    {
        return $this->{$this->mask_name()};
    }

    public function mask_address()
    {
        return 'production_address';
    }

    public function setMaskAddressAttribute($value)
    {
        $this->attributes[$this->mask_address()] = $value;
    }

    public function getMaskAddressAttribute()
    {
        return $this->{$this->mask_address()};
    }
}
