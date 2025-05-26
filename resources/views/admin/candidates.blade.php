@extends('Layout.admin')
@section('title-section')
Listes des candidats
@endsection

@section('content-section')
<div class="container liste">
    <div class="page-inner">
        <h2 class="ly-2">Listes des candidats</h2>
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
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    @php
                    $date_creation = new DateTime($user->created_at);
                    @endphp
                    <td>{{ $date_creation->format('d-m-Y') }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="#" class="icon-link"><i class="fa-solid fa-edit"></i></a>
                            <form action="{{ route('admin.recruiters.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-link" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection