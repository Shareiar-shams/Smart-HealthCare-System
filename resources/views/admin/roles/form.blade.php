@extends('layouts.administration.app')

@section('main_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $role->exists ? 'Edit' : 'Create' }} Role</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
                @csrf
                @if($role->exists) @method('put') @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" class="form-control" value="{{ old('name', $role->name) }}" required />
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group mt-3">
                    <label>Permissions</label>
                    <div class="row">
                        @foreach($permissions as $p)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $p->name }}" id="perm_{{ $p->id }}" {{ in_array($p->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $p->id }}">{{ $p->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
