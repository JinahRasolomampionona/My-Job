{{-- Champs communs des formulaires d'offre. Variable optionnelle : $offre (édition) --}}
@php $offre = $offre ?? null; @endphp

<div class="row">
    @foreach ([
        'titre' => ['Titre du poste', 'fa-briefcase', 'Ex : Développeur Laravel'],
        'entreprise' => ['Entreprise', 'fa-building', 'Nom de l\'entreprise'],
        'contrat' => ['Contrat', 'fa-file-contract', 'CDI, CDD, Stage...'],
        'localisation' => ['Localisation', 'fa-map-marker-alt', 'Ville'],
        'domaine' => ['Domaine', 'fa-layer-group', 'Informatique, Finance...'],
    ] as $champ => [$label, $icone, $placeholder])
        <div class="{{ $champ === 'titre' ? 'col-12' : 'col-md-6' }} mb-3">
            <label for="{{ $champ }}" class="form-label"><i class="fas {{ $icone }} me-1 text-primary"></i>{{ $label }}</label>
            <input type="text" class="form-control @error($champ) is-invalid @enderror" name="{{ $champ }}" id="{{ $champ }}"
                placeholder="{{ $placeholder }}" value="{{ old($champ, $offre?->$champ) }}" required>
            @error($champ)
                <small class="invalid-feedback d-block">{{ $message }}</small>
            @enderror
        </div>
    @endforeach
</div>

<div class="mb-3">
    <div class="editor-head">
        <label for="editor" class="form-label mb-0"><i class="fas fa-align-left me-1 text-primary"></i>Description</label>
        <div class="editor-modes" role="tablist" aria-label="Mode d'édition">
            <button type="button" class="active" data-editor-mode="visual" role="tab" aria-selected="true">
                <i class="fas fa-eye me-1"></i>Visuel
            </button>
            <button type="button" data-editor-mode="code" role="tab" aria-selected="false">
                <i class="fas fa-code me-1"></i>Code
            </button>
        </div>
    </div>
    <div class="editor-visual">
        <div id="editor"></div> <!-- Éditeur Quill (initialisé dans app.js) -->
    </div>
    <textarea id="editor-code" class="form-control editor-code d-none" spellcheck="false"
        aria-label="Code HTML de la description"></textarea>
    <input type="hidden" name="description" id="hidden-description" value="{{ old('description', $offre?->description) }}">
    @error('description')
        <small class="invalid-feedback d-block">{{ $message }}</small>
    @enderror
</div>

<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" role="switch" name="is_urgent" value="1" id="is_urgent"
        {{ old('is_urgent', $offre?->is_urgent) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_urgent"><i class="fas fa-bolt text-danger me-1"></i>Marquer comme urgent</label>
</div>
