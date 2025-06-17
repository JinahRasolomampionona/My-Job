<div class="modal" id="editExperience-{{ $experience->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Editer l'expérience</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{ route('candidates.experiences.update', $experience) }}">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Année de début</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="row select-annee">
                                    <div class="col-lg-6 pr-0">
                                        <select name="mois-debut" value="{{ $experience->moisDebut }}" id="">
                                            <option value="Mois">Mois</option>
                                            <option value="Janvier">Janvier</option>
                                            <option value="Fevrier">Fevrier</option>
                                            <option value="Mars">Mars</option>
                                            <option value="Avril">Avril</option>
                                            <option value="Mai">Mai</option>
                                            <option value="Juin">Juin</option>
                                            <option value="Juilet">Juilet</option>
                                            <option value="Aout">Aout</option>
                                            <option value="Septembre">Septembre</option>
                                            <option value="Octobre">Octobre</option>
                                            <option value="Novembre">Novembre</option>
                                            <option value="Decembre">Decembre</option>
                                        </select>
                                        @error('mois-debut')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 pl-0">
                                        <select name="annee-debut" value="{{ $experience->anneeDebut }}" id="">
                                            <option value="Année">Année</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                        @error('annee-debut')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Année de fin</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="row select-annee">
                                    <div class="col-lg-6 pr-0">
                                        <select name="mois-fin" value="{{ $experience->moisFin }}" id="">
                                            <option value="Mois">Mois</option>
                                            <option value="Janvier">Janvier</option>
                                            <option value="Fevrier">Fevrier</option>
                                            <option value="Mars">Mars</option>
                                            <option value="Avril">Avril</option>
                                            <option value="Mai">Mai</option>
                                            <option value="Juin">Juin</option>
                                            <option value="Juilet">Juilet</option>
                                            <option value="Aout">Aout</option>
                                            <option value="Septembre">Septembre</option>
                                            <option value="Octobre">Octobre</option>
                                            <option value="Novembre">Novembre</option>
                                            <option value="Decembre">Decembre</option>
                                        </select>
                                        @error('mois-fin')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 pl-0">
                                        <select name="annee-fin" value="{{ $experience->anneeFin }}" id="">
                                            <option value="Année">Année</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                        @error('annee-fin')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Année d'expériences</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="anneeExperience" id="titre"
                                    placeholder="ex: 1 an d'expériences" value="{{ $experience->anneeExperience }}"
                                    required>
                                @error('anneeExperience')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Société</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="societe" id="societe"
                                    placeholder="Votre ancien société" value="{{ $experience->societe }}" required>
                                @error('societe')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg-3 d-flex align-items-center">
                                <label for="" class="form-label">Poste</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="posteExperience" id="titre"
                                    placeholder="Votre poste" value="{{ $experience->posteExperience }}" required>
                                @error('posteExperience')
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
                                <textarea name="descriptionExperience" class="form-control" id="" placeholder="Description" cols="30"
                                    rows="10">{{ $experience->descriptionExperience }}</textarea>
                                @error('descriptionExperience')
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