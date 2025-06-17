<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilesFormRequest extends FormRequest
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
            'poste' => 'required|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:400',
            'etude' => 'required|string|regex:/^[a-zA-Z0-9]+(\s[a-zA-Z0-9]+)*$/|max:100',
            'experience' => 'required|string|regex:/^[a-zA-Z0-9]+(\s[a-zA-Z0-9]+)*$/|max:100',
            'civilite' => 'required|string',
            'nom' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'prenom' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|regex:/^[0-9\s\-\+\(\)]+$/|min:8|max:20',
            'descriptionProfil' => 'required|string|min:10|max:255',
        ];
    }

     public function messages(): array
    {
        $champs = ['poste', 'etude', 'experience', 'civilite', 'nom', 'prenom', 'naissance', 'adresse', 'email', 'contact', 'descriptionProfil'];
        $messages = [];

        foreach ($champs as $champ) {
            $messages["$champ.required"] = "Veuillez remplir ce champ $champ";
            $messages["$champ.max"] = ucfirst($champ) . " trop long";
            $messages["$champ.min"] = ucfirst($champ) . " trop court, veuillez mettre un peu plus long";
            // On applique la règle regex uniquement si ce n'est PAS le champ concerné
            if ($champ !== 'adresse' && $champ !== 'contact' && $champ !== 'descriptionProfil') {
                $messages["$champ.regex"] = "Le format est invalide, veuillez entrer une chaîne de caractères";
            }
        }

        return $messages;
    }
}
