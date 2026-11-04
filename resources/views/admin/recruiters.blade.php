@extends('Layout.admin')
@section('title-section')
Listes des recruteurs
@endsection

@section('content-section')
<div class="container liste">
    <div class="page-inner">
        <h2 class="ly-2">Listes des recruteurs</h2>
        <div class="table-responsive" data-aos="fade-up">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-primary text-capitalize">{{ $user->role }}</span></td>
                    <td>{{ $user->created_at?->format("d-m-Y") }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <form action="{{ route('admin.recruiters.destroy', $user->id) }}" method="POST" data-confirm="Supprimer cet utilisateur et toutes ses données ?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-link">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

    </div>
</div>
@endsection