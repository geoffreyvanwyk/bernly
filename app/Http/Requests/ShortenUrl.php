<?php namespace Bernly\Http\Requests;

use Bernly\Http\Requests\Request,
    Bernly\Models\Url;

class ShortenUrl extends Request {

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
        return Url::VALIDATION_RULES;
    }

}
