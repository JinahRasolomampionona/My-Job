<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferFormRequest extends FormRequest
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
            'titre' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|min:5|max:50',
            'entreprise' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|min:5|max:50',
            'contrat' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|min:3|max:20',
            'localisation' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|min:5|max:50',
            'domaine' => 'required|string|min:5|max:50',
            'description' => 'required|string|min:30|max:5000',
        ];
    }

     public function messages(): array
    {
        $champs = ['titre', 'entreprise', 'contrat', 'localisation', 'domaine', 'description'];
        $messages = [];

        foreach ($champs as $champ) {
            $messages["$champ.required"] = "Veuillez remplir ce champ $champ";
            $messages["$champ.max"] = ucfirst($champ) . " trop long";
            $messages["$champ.min"] = ucfirst($champ) . " trop court, veuillez mettre un peu plus long";
            // On applique la règle regex uniquement si ce n'est PAS le champ 'description'
            if ($champ !== 'description') {
                $messages["$champ.regex"] = "Le format est invalide, veuillez entrer une chaîne de caractères";
            }
        }

        // Exception spécifique pour le champ description
        $messages['description.min'] = 'Texte trop court, veuillez mettre un peu plus long le texte';

        return $messages;
    }
}
