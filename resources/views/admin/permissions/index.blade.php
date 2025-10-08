@extends('layouts.administration.app')

@section('main_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Permissions</h3>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">Create Permission</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this permission?');">
                                    @csrf @method('delete')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $permissions->links() }}
        </div>
    </div>
</div>
@endsection
