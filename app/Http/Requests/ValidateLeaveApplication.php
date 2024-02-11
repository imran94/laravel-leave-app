<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateLeaveApplication extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $endDateValidation = 'nullable';
        if (request()->time_period == "Full Day") {
            $endDateValidation = 'required|date';
        }

        if (request()->type == 'Sick leave (Illness or Injury)') {
            $rules = [
                'start_date' => 'required|date',
                'end_date' => $endDateValidation,
                'time_period' => 'required|string',
                'type' => 'required|string',
                'attachment' => 'required|mimes:jpg,jpeg,png,docx,pdf,doc|max:50000',
            ];
        } else {
            $rules = [
                'start_date' => 'required|date',
                'end_date' => $endDateValidation,
                'time_period' => 'required|string',
                'type' => 'required|string',
                'attachment' => 'nullable|mimes:jpg,jpeg,png,docx,pdf,doc|max:50000'
            ];
        }

        if (request()->btnSubmit != "") {
            $rules = array_merge($rules, ['btnSubmit' => 'numeric']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            //            'name.alpha' => 'Invalid Name field',
            'start_date.date' => 'Invalid start date',
            'end_date.date' => 'Invalid end date',
            'optradio.string' => 'invalid option for AM\PM\Full Day',
            'type.string' => 'invalid type',
            'btnSubmit.numeric' => 'Invalid request',
            'attachment.mimes' => 'File format should be jpg,jpeg,png,docx,doc'
        ];
    }
}
