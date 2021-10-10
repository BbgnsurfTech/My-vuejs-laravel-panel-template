<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'incomes';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'income_category.name',
        'entry_date',
        'amount',
        'description',
    ];

    protected $filterable = [
        'id',
        'income_category.name',
        'entry_date',
        'amount',
        'description',
    ];

    protected $fillable = [
        'income_category_id',
        'entry_date',
        'amount',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.date_format')) : null;
    }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('project.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
