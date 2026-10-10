<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pack_id' => 'nullable|exists:packs,id',
            'product_id' => 'nullable|exists:products,id',
            'product_quantity' => 'nullable|integer|min:1|max:100',
            'quote_id' => 'nullable|exists:quotes,id',
            'customer_name' => 'required|string|max:120',
            'customer_phone' => 'required|string|max:30',
            'customer_email' => 'nullable|email',
            'cin' => 'nullable|string|max:20',
            'project_type' => 'nullable|string|max:50',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:80',
            'address' => 'nullable|string|max:255',
            'delivery_required' => 'nullable|boolean',
            'customer_message' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_phone.required' => 'Le téléphone est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être identique ou postérieure à la date de début.',
        ];
    }
}
