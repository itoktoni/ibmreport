<?php

namespace Modules\Report\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Payment extends Model
{
    protected $connection= 'data';
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'payment_id',
        'payment_name',
    ];

    // public $with = ['module'];

    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
        'payment_name' => 'required|min:3',
    ];

    public $searching = 'payment_name';
    public $datatable = [
        'payment_id' => [false => 'Code', 'width' => 50],
        'payment_name' => [true => 'Name'],
    ];

    public function mask_name()
    {
        return 'payment_name';
    }

    public function setMaskNameAttribute($value)
    {
        $this->attributes[$this->mask_name()] = $value;
    }

    public function getMaskNameAttribute()
    {
        return $this->{$this->mask_name()};
    }

    public function mask_reference()
    {
        return 'reference';
    }

    public function setMaskReferenceAttribute($value)
    {
        $this->attributes[$this->mask_reference()] = $value;
    }

    public function getMaskReferenceAttribute()
    {
        return $this->{$this->mask_reference()};
    }
}
