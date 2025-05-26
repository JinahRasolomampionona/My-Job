<div class="modal" id="showFormation-{{ $formation->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Details formation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container formation-content">
                    <div class="row">
                        <div class="col-lg-5">
                            <p><strong>{{ $formation->anneeScolaire }}</strong></p>
                            <p class="">{{ $formation->etablissement }}</p>
                        </div>
                        <div class="col-lg-7">
                            <h5 class="diplome">{{ $formation->diplome }}</h5>
                            <p>{{ $formation->descriptionFormation }}</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('candidates.formations.edit', $formation) }}" class="btn btn-primary mr-1"
                            data-bs-toggle="modal" data-bs-target="#editFormation-{{ $formation->id }}">Editer</a>
                        @include('candidates.formations.edit', $formation)
                        <form action="{{ route('candidates.formations.destroy', $formation) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>