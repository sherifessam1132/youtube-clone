<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChannelUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $channel_id=auth()->user()->channel->first()->id;
        return [
            'name'=>['required','max:255',
                    Rule::unique('channels','name')->ignore($channel_id)],
            'slug'=>['required','max:255',
                    Rule::unique('channels','slug')->ignore($channel_id)
                    ,'alpha_num'],
            'description'=> ['max:1000'],
            'image'=>['nullable','image','mimes:jpg,jpeg,png']

        ];
    }
}
