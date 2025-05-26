@extends("Layout.layout")
@section("title-section")
Modifier offres
@endsection

@section("content-section")
<div class="container-fluid">
    <div class="page-offre">
        <div class="row">
            <div class="col-md-6">
                <h1>Modifier offres</h1>
                <form method="post" action="{{ route('offres.update', $offresView->id) }}">
                    @csrf
                    @method('PUT') <!-- Ajout de la méthode PUT -->
                    <div class="mb-3">
                        <label for="" class="form-label">Titre</label>
                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre" value="{{ $offresView->titre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Entreprise</label>
                        <input type="text" class="form-control" name="entreprise" id="entreprise" placeholder="Entreprise" value="{{ $offresView->entreprise }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Contrat</label>
                        <input type="text" class="form-control" name="contrat" id="contrat" placeholder="Contrat" value="{{ $offresView->contrat }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Localisation</label>
                        <input type="text" class="form-control" name="localisation" id="localisation" placeholder="Localisation" value="{{ $offresView->localisation }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Domaine</label>
                        <input type="text" class="form-control" name="domaine" id="domaine" placeholder="Domaine" value="{{ $offresView->domaine }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div id="editor"></div> <!-- Éditeur Quill -->
                        <input type="hidden" name="description" id="hidden-description" value="{{ old('description', $offresView->description) }}"> <!-- Stocke le HTML -->
                    </div>
                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                    <a href="{{ route('offres.index') }}" class="btn btn-success">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection