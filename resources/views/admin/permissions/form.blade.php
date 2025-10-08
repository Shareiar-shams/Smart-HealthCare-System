@extends('layouts.administration.app')

@section('main_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $permission->exists ? 'Edit' : 'Create' }} Permission</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{ $permission->exists ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}">
                @csrf
                @if($permission->exists) @method('put') @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required />
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
