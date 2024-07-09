<?php

namespace App\Http\Requests;

use App\Models\Products;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:products,name',
                'max:200',
                function ($attribute, $value, $fail) {
                    $normalizedValue = $this->normalizeTurkishCharacters(strtolower($value));

                    if (\App\Models\Products::whereRaw('lower(name) = ?', [$normalizedValue])->exists()) {
                        $fail('Bu isimde bir ürün zaten mevcut.');
                    }
                },
            ],
            'description' => 'required|string',
            'stock_status' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    private function normalizeTurkishCharacters($string)
    {
        $turkish = ['Ç', 'Ş', 'İ', 'Ğ', 'Ü', 'Ö', 'ç', 'ş', 'ı', 'ğ', 'ü', 'ö'];
        $english = ['C', 'S', 'I', 'G', 'U', 'O', 'c', 's', 'i', 'g', 'u', 'o'];

        return str_replace($turkish, $english, $string);
    }
}
