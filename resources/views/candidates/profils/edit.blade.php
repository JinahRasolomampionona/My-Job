<div class="modal fade" tabindex="-1" id="editProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Editer le profil</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{ route('candidates.profils.update', $user->profil) }}">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Poste actuel</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="poste" id="poste"
                                    placeholder="Votre poste" value="{{ old('poste', $user->profil->poste) }}" required>
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
                                    placeholder="Niveau d'étude" value="{{ old('etude', $user->profil->etude) }}" required>
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
                                    placeholder="Niveau d'expérience" value="{{ old('experience', $user->profil->experience) }}" required>
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
                                <select name="civilite" class="form-select" id="edit-civilite">
                                    @foreach (["mr" => "Mr", "mme" => "Mme", "mlle" => "Mlle"] as $val => $lib)
                                        <option value="{{ $val }}" @selected(old("civilite", $user->profil->civilite) === $val)>{{ $lib }}</option>
                                    @endforeach
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
                                    placeholder="Votre nom" value="{{ old('nom', $user->profil->nom) }}" required>
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
                                    placeholder="Votre prénom" value="{{ old('prenom', $user->profil->prenom) }}" required>
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
                                <input type="text" class="form-control" name="naissance" id="naissance"
                                    placeholder="Né(e) le" value="{{ old('naissance', $user->profil->naissance) }}" required>
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
                                    placeholder="Votre adresse" value="{{ old('adresse', $user->profil->adresse) }}" required>
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
                                    placeholder="Votre email" value="{{ old('email', $user->profil->email) }}" required>
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
                                    placeholder="Votre contact" value="{{ old('contact', $user->profil->contact) }}" required>
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
                                    rows="5">{{ old('descriptionProfil', $user->profil->descriptionProfil) }}</textarea>
                                @error('descriptionProfil')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                    <a href="{{ route('candidates.profils.profil') }}" class="btn btn-success">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>