<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mois-debut' => 'required|string|max:20',
            'annee-debut' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'mois-fin' => 'nullable|string|max:20',
            'annee-fin' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'anneeExperience' => 'nullable|string|max:50',
            'societe' => 'required|string|max:150',
            'posteExperience' => 'required|string|max:100',
            'descriptionExperience' => 'nullable|string|min:10|max:255',
        ];
    }

     public function messages(): array
    {
        return [
            'mois-debut.required' => 'Le mois de début est obligatoire.',
            'annee-debut.required' => 'L\'année de début est obligatoire.',
            'societe.required' => 'Le nom de la société est requis.',
            'posteExperience.required' => 'Le poste est obligatoire.',
            'descriptionExperience.min' => 'La description doit contenir au moins 10 caractères.',
        ];
    }
}
