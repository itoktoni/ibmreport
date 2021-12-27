<?php

namespace Modules\Report\Dao\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Modules\Report\Dao\Facades\PaymentFacades;
use Modules\Report\Dao\Facades\SoDetailFacades;
use Modules\Report\Dao\Facades\SoFacades;
use Modules\System\Dao\Facades\TeamFacades;
use Modules\System\Plugins\Helper;
use Wildside\Userstamps\Userstamps;

class Spk extends Model
{
    use Userstamps, PowerJoins, FilterQueryString;
    protected $connection= 'data';
    protected $table = 'spk';
    protected $primaryKey = 'spk_id';
    protected $primaryType = 'string';

    protected $fillable = [
        'spk_id',
        'spk_reff',
        'spk_date',
        'spk_delivery_date',
        'spk_invoice_date',
        'spk_attachment',
        'spk_note',
        'created_at',
        'updated_at',
        'created_by',
        'production_id',
        'spk_status',
        'spk_note_production',
        'spk_receive_date',
        'spk_send_date',
        'spk_prepare',
        'spk_approve',
    ];

    // public $with = ['has_detail'];

    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
        'spk_id' => 'required|min:3',
    ];

    const CREATED_AT = 'order_created_at';
    const UPDATED_AT = 'order_updated_at';
    const DELETED_AT = 'order_deleted_at';

    const CREATED_BY = 'order_created_by';
    const UPDATED_BY = 'order_updated_by';
    const DELETED_BY = 'order_deleted_by';

    public $searching = 'order_id';
    public $datatable = [
        'spk_id' => [true => 'Code'],
        'spk_date' => [true => 'Code'],
        'production_id' => [false => 'Company'],
        'spk_status' => [true => 'Status', 'width' => 50, 'class' => 'text-center', 'status' => 'status'],
    ];

    protected $filters = [
        'production_id',
        'spk_status'
    ];

    protected $casts = [
        'order_date_order' => 'datetime:Y-m-d',
        'order_created_at' => 'datetime:Y-m-d',
    ];

    public function mask_status()
    {
        return 'order_status';
    }

    public function setMaskStatusAttribute($value)
    {
        $this->attributes[$this->mask_status()] = $value;
    }

    public function getMaskStatusAttribute()
    {
        return $this->{$this->mask_status()};
    }

    public function mask_total()
    {
        return 'order_sum_total';
    }

    public function setMaskTotalAttribute($value)
    {
        $this->attributes[$this->mask_total()] = $value;
    }

    public function getMaskTotalAttribute()
    {
        return $this->{$this->mask_total()};
    }

    public function getMaskTotalFormatAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_total()});
    }

    public function mask_value()
    {
        return 'order_sum_value';
    }

    public function setMaskValueAttribute($value)
    {
        $this->attributes[$this->mask_value()] = $value;
    }

    public function getMaskValueAttribute()
    {
        return $this->{$this->mask_value()};
    }

    public function getMaskValueFormatAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_value()});
    }

    public function mask_discount()
    {
        return 'order_sum_discount';
    }

    public function setMaskDiscountAttribute($value)
    {
        $this->attributes[$this->mask_discount()] = $value;
    }

    public function getMaskDiscountAttribute()
    {
        return $this->{$this->mask_discount()};
    }

    public function getMaskDiscountFormatAttribute()
    {
        return Helper::createRupiah($this->{$this->mask_discount()});
    }

    public function mask_company_id()
    {
        return 'order_company_id';
    }

    public function setCompanyIdAttribute($value)
    {
        $this->attributes[$this->mask_company_id()] = $value;
    }

    public function getCompanyIdAttribute()
    {
        return $this->{$this->mask_company_id()};
    }

    public function mask_jo_code()
    {
        return 'order_jo_code';
    }

    public function setJoCodeAttribute($value)
    {
        $this->attributes[$this->mask_jo_code()] = $value;
    }

    public function getJoCodeAttribute()
    {
        return $this->{$this->mask_jo_code()};
    }

    public function getCompanyNameAttribute()
    {
        return $this->order_company_name;
    }
    
    public function getCompanyAddressAttribute()
    {
        return $this->order_company_address;
    }

    public function mask_created_at()
    {
        return self::CREATED_AT;
    }

    public function setMaskCreatedAtAttribute($value)
    {
        $this->attributes[$this->mask_created_at()] = $value;
    }

    public function getMaskCreatedAtAttribute()
    {
        return $this->{$this->mask_created_at()};
    }

    public function has_detail()
    {
        return $this->hasMany(SpkDetail::class, 'detail', 'spk_id');
    }

    public function has_payment()
    {
        return $this->hasMany(Payment::class, 'reference', 'spk_id');
    }

    public function has_customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }

    public function has_production()
    {
        return $this->hasOne(Production::class, 'production_id', 'production_id');
    }

    public function has_sales()
    {
        return $this->hasOne(Team::class, 'email', 'email');
    }

    public static function boot()
    {
        parent::saving(function ($model) {
            $company = $model->has_customer->has_company ?? null;
            if($company){
                $model->order_company_id = $company->company_id;
                $model->order_company_name = $company->company_name;
                $model->order_company_address = $company->company_address;
            }
        });

        parent::boot();
    }
}
