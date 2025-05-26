<div class="modal" id="showExperience-{{ $experience->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Details experiences</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container experience-content">
                    <div class="row">
                        <div class="col-lg-5">
                            <p>{{ $experience->moisDebut }} {{ $experience->anneeDebut }} -
                                {{ $experience->moisFin }} {{ $experience->anneeFin }}
                            </p>
                            <p>{{ $experience->anneeExperience }} d'expérience(s)</p>
                        </div>
                        <div class="col-lg-7">
                            <h5 class="diplome">{{ $experience->societe }} - {{ $experience->posteExperience }}</h5>
                            <p>{{ $experience->descriptionExperience }}</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('candidates.experiences.edit', $experience) }}" class="btn btn-primary mr-1"
                            data-bs-toggle="modal" data-bs-target="#editExperience-{{ $experience->id }}">Editer</a>
                        @include('candidates.experiences.edit', $experience)
                        <form action="{{ route('candidates.experiences.destroy', $experience) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>