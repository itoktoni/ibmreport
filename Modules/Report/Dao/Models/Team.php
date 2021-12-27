<?php

namespace Modules\Report\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Team extends Model
{
    protected $connection= 'data';
    protected $table = 'users';
    protected $primaryKey = 'nik';

    protected $fillable = [
        'nik',
        'name',
        'email',
    ];

    // public $with = ['module'];

    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
        'nik' => 'required|min:3',
    ];

    public $searching = 'name';
    public $datatable = [
        'nik' => [false => 'Code', 'width' => 50],
        'name' => [true => 'Name'],
        'email' => [true => 'Description'],
        'group_user' => [true => 'Description'],
    ];

    public function mask_name()
    {
        return 'name';
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
        return 'supplier_address';
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
