<?php

namespace App\Http\Requests;

use App\Models\Venue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVenueRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('venue_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
            ],
            'location_id' => [
                'required',
                'integer',
            ],
            'event_types.*' => [
                'integer',
            ],
            'event_types' => [
                'array',
            ],
            'address' => [
                'string',
                'required',
            ],
            'latitude' => [
                'numeric',
            ],
            'longitude' => [
                'numeric',
            ],
            'people_minimum' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'people_maximum' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}