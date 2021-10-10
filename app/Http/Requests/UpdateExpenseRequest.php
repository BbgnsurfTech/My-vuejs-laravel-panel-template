<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('expense_edit');
    }

    public function rules()
    {
        return [
            'expense_category_id' => [
                'integer',
                'exists:expense_categories,id',
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
