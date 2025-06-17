<div class="modal" id="createProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Mon profil</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{ route('candidates.profils.store') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Poste actuel</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="poste" id="poste"
                                    placeholder="Votre poste" value="{{ old('poste') }}" required>
                                @error('poste')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Niveau d'étude actuel</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="etude" id="etude"
                                    placeholder="Niveau d'étude" value="{{ old('etude') }}" required>
                                @error('etude')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Niveau d'expérience actuel</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="experience" id="experience"
                                    placeholder="Niveau d'expérience" value="{{ old('experience') }}" required>
                                @error('experience')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Civilité</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="civilite" id="">
                                    <option value="mr">Mr</option>
                                    <option value="mme">Mme</option>
                                    <option value="mlle">Mlle</option>
                                </select>
                                @error('civilite')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Nom</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="nom" id="nom"
                                    placeholder="Votre nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Prénom</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="prenom" id="prenom"
                                    placeholder="Votre prénom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Date de naissance</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" name="naissance" id="naissance"
                                    placeholder="Né(e) le" value="{{ old('naissance') }}" required>
                                @error('naissance')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Adresse</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="adresse" id="adresse"
                                    placeholder="Votre adresse" value="{{ old('adresse') }}" required>
                                @error('adresse')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Email</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Votre email" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Contact</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" name="contact" id="contact"
                                    placeholder="Votre contact" value="{{ old('contact') }}" required>
                                @error('contact')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex">
                                <label for="" class="form-label">Description de votre profil</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="descriptionProfil" class="form-control" id="" placeholder="Description" cols="20"
                                    rows="5">{{ old('descriptionProfil') }}</textarea>
                                @error('descriptionProfil')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="inserer">Inserer</button>
                    <a href="" class="btn btn-success">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>