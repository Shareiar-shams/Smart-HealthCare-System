<form method="post" action="{{ route('admin.password.update', Auth::guard('admin')->user()->id) }}" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group row">
        <x-input-label for="current_password" :value="__('Current Password')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="current_password" name="old_password" type="password" class="form-control" autocomplete="current-password" placeholder="Enter Old Password" required/>
        </div>
    </div>
    <div class="form-group row">
        <x-input-label for="password" :value="__('New Password')"  class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="password" name="new_password" type="password" class="form-control" autocomplete="new-password" placeholder="Enter New Password" required/>
        </div>
    </div>
    <div class="form-group row">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')"  class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="password_confirmation" name="c_password" type="password" class="form-control" autocomplete="new-password" placeholder="Retype Password" required/>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-danger">{{ __('Submit') }}</x-primary-button>
        </div>
    </div>
</form>