<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestAnswer extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'test_answers';

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $filterable = [
        'id',
        'test_result.score',
        'question.question_text',
        'option.option_text',
    ];

    protected $orderable = [
        'id',
        'test_result.score',
        'question.question_text',
        'option.option_text',
        'is_correct',
    ];

    protected $fillable = [
        'test_result_id',
        'question_id',
        'option_id',
        'is_correct',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function testResult()
    {
        return $this->belongsTo(TestResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(QuestionOption::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
