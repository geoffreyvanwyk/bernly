<?php namespace Bernly\Http\Requests;

use Bernly\Models\Url,
    Bernly\Http\Requests\Request;

class ShortenUrlRequest extends Request {

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
