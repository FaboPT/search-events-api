<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /* @OA\Property(format="string", default="", description="term", property="term"), */
    /* @OA\Property(format="date", default="", description="date", property="date"), */

    public function rules(): array
    {
        return [
            'term' => 'nullable | string',
            'date' => 'nullable | date'
        ];
    }
}
