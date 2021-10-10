<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChartsService;

class DashboardApiController extends Controller
{
    public function index()
    {
        $line0 = new ChartsService([
            'title'           => 'Number of users by date',
            'chart_type'      => 'line',
            'model'           => 'App\Models\User',
            'group_by_field'  => 'created_at',
            'group_by_period' => 'day',
            'column_class'    => 'col-md-12',
        ]);

        $bar1 = new ChartsService([
            'title'           => 'Products',
            'chart_type'      => 'bar',
            'model'           => 'App\Models\Product',
            'group_by_field'  => 'name',
            'group_by_period' => 'day',
            'column_class'    => 'col-md-6',
        ]);

        $pie2 = new ChartsService([
            'title'           => 'Lessons',
            'chart_type'      => 'pie',
            'model'           => 'App\Models\Lesson',
            'group_by_field'  => 'created_at',
            'group_by_period' => 'day',
            'column_class'    => 'col-md-4',
        ]);

        $stats3 = new ChartsService([
            'title'        => 'Courses',
            'chart_type'   => 'stats',
            'model'        => 'App\Models\Course',
            'column_class' => 'col-md-3',
            'footer_icon'  => 'date_range',
            'footer_text'  => 'Lifetime total',
        ]);

        $latest4 = new ChartsService([
            'title'        => 'Questions',
            'chart_type'   => 'latest',
            'model'        => 'App\Models\FaqQuestion',
            'column_class' => 'col-md-12',
            'fields'       => ['question', 'answer', 'created_at'],
            'limit'        => 5,
        ]);

        return response()->json(compact('line0', 'bar1', 'pie2', 'stats3', 'latest4'));
    }
}
