<form method="post" action="{{ route('password.update') }}" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group row">
        <x-input-label for="current_password" :value="__('Current Password')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" placeholder="Enter Old Password" required/>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>
    <div class="form-group row">
        <x-input-label for="update_password_password" :value="__('New Password')"  class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" placeholder="Enter New Password" required/>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>
    <div class="form-group row">
        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')"  class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" placeholder="Retype Password" required/>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-danger">{{ __('Submit') }}</x-primary-button>
        </div>
    </div>
</form>