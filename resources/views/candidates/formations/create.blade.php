<div class="modal" id="createFormation">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Formations</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{ route('candidates.formations.store') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Année scolaire</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="annee-scolaire" id="">
                                    <option value="2021 - 2022">2021 - 2022</option>
                                    <option value="2022 - 2023">2022 - 2023</option>
                                    <option value="2023 - 2024">2023 - 2024</option>
                                    <option value="2024 - 2025">2024 - 2025</option>
                                </select>
                                @error('annee-scolaire')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Diplôme</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="diplome" id="diplome"
                                    placeholder="Votre diplôme" value="{{ old('diplome') }}" required>
                                @error('diplome')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Intitulé</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="etablissement" id="etablissement"
                                    placeholder="Etablissement" value="{{ old('etablissement') }}" required>
                                @error('etalissement')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Description</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="descriptionFormation" class="form-control" id="" placeholder="Description" cols="30"
                                    rows="10">{{ old('descriptionFormation') }}</textarea>
                                @error('descriptionFormation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="inserer">Inserer</button>
                    <a href="{{ route('candidates.profils.profil') }}" class="btn btn-success">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>