<?php

namespace App\Http\Requests;

use App\Models\Income;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIncomeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('income_edit');
    }

    public function rules()
    {
        return [
            'income_category_id' => [
                'integer',
                'exists:income_categories,id',
                'nullable',
            ],
            'entry_date' => [
                'date_format:' . config('project.date_format'),
                'required',
            ],
            'amount' => [
                'numeric',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
