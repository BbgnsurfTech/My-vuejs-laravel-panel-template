<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmNote extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'crm_notes';

    protected $orderable = [
        'id',
        'customer.first_name',
        'note',
    ];

    protected $filterable = [
        'id',
        'customer.first_name',
        'note',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
