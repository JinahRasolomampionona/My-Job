<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormationFormRequest extends FormRequest
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
            'annee-scolaire' => 'required|string|min:4|max:20',
            'diplome' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:100',
            'etablissement' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:150',
            'descriptionFormation' => 'required|string|min:10|max:900',
        ];
    }

    public function messages(): array
    {
        $champs = ['annee-scolaire', 'diplome', 'etablissement', 'descriptionFormation'];
        $messages = [];

        foreach ($champs as $champ) {
            $messages["$champ.required"] = "Veuillez remplir ce champ $champ";
            $messages["$champ.max"] = ucfirst($champ) . " trop long";
            $messages["$champ.min"] = ucfirst($champ) . " trop court, veuillez mettre un peu plus long";
            // On applique la règle regex uniquement si ce n'est PAS le champ concerné
            if ($champ !== 'annee-scolaire' && $champ !== 'descriptionFormation') {
                $messages["$champ.regex"] = "Le format est invalide, veuillez entrer une chaîne de caractères";
            }
        }

        return $messages;
    }
}
