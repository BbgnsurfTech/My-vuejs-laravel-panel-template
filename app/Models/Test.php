<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @internal
 * @coversNothing
 */
class Test extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'tests';

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $filterable = [
        'id',
        'course.title',
        'lesson.title',
        'title',
        'description',
    ];

    protected $orderable = [
        'id',
        'course.title',
        'lesson.title',
        'title',
        'description',
        'is_published',
    ];

    protected $fillable = [
        'course_id',
        'lesson_id',
        'title',
        'description',
        'is_published',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
