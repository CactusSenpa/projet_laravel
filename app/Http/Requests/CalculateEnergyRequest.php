<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateEnergyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $items = collect($this->input('items', []))->map(function ($item) {
            if (($item['appliance_id'] ?? '') === '') {
                $item['appliance_id'] = null;
            }
            $item['has_startup_surge'] = filter_var($item['has_startup_surge'] ?? false, FILTER_VALIDATE_BOOLEAN);

            return $item;
        })->all();

        $this->merge(['items' => $items]);
    }

    public function rules(): array
    {
        return [
            'project_type' => 'required|in:evenement,chantier,stand,autre',
            'battery_type' => 'nullable|in:lithium,lead',
            'items' => 'required|array|min:1',
            'items.*.appliance_id' => 'nullable|exists:appliances,id',
            'items.*.name' => 'required|string|max:120',
            'items.*.power_w' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.duration_hours' => 'required|numeric|min:0.1',
            'items.*.usage_period' => 'required|in:jour,nuit,mixte',
            'items.*.has_startup_surge' => 'nullable|boolean',
            'items.*.startup_factor' => 'nullable|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Veuillez ajouter au moins un appareil.',
            'items.min' => 'Veuillez ajouter au moins un appareil.',
            'items.*.quantity.min' => 'La quantité doit être supérieure à 0.',
            'items.*.duration_hours.min' => 'La durée doit être supérieure à 0.',
            'items.*.power_w.min' => 'La puissance doit être supérieure à 0.',
        ];
    }
}
