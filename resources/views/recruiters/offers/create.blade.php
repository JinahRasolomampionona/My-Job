@extends('Layout.recruiter')
@section('title-section')
Creation offres
@endsection


@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="w-85">
            <h1>Inserer des offres</h1>
            <form method="post" action="{{ route('recruiters.offers.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Titre</label>
                    <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre" value="{{ old('titre') }}" required>
                    @error('titre')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Entreprise</label>
                    <input type="text" class="form-control" name="entreprise" id="entreprise"
                        placeholder="Entreprise" value="{{ old('entreprise') }}" required>
                    @error('entreprise')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contrat</label>
                    <input type="text" class="form-control" name="contrat" id="contrat" placeholder="Contrat"
                        value="{{ old('contrat') }}" required>
                    @error('contrat')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Localisation</label>
                    <input type="text" class="form-control" name="localisation" id="localisation"
                        placeholder="Localisation" value="{{ old('localisation') }}" required>
                    @error('localisation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Domaine</label>
                    <input type="text" class="form-control" name="domaine" id="domaine" placeholder="Domaine"
                    value="{{ old('domaine') }}" required>
                    @error('domaine')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <div id="editor"></div> <!-- Éditeur Quill -->
                    <input type="hidden" name="description" id="hidden-description" required> <!-- Stocke le HTML -->
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <label class="d-block mb-2">
                    <input type="checkbox" name="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}> Marquer comme urgent
                </label>                
                <button type="submit" class="btn btn-primary" name="inserer">Inserer</button>
                <a href="{{ route('recruiters.offers.index') }}" class="btn btn-success">Annuler</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Inject old value if exists
        @if(old('description'))
            quill.root.innerHTML = {!! json_encode(old('description')) !!};
            document.getElementById('hidden-description').value = {!! json_encode(old('description')) !!};
        @endif

        // Sync content on submit
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('hidden-description').value = quill.root.innerHTML;
        });
    });
</script>
@endsection