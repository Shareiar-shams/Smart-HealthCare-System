<div class="tab-pane" id="delete_account">
    <div class="form-group row">
        <div class="col-sm-12">
            <p class="text-danger">Warning: Deleting your account is permanent and cannot be undone.</p>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-admin')"
                class="btn btn-danger"
            >{{ __('Delete Account') }}</x-danger-button>
        </div>
    </div>

    <x-modal name="confirm-user-deletion-admin" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            @csrf
            @method('delete')

            <h4 class="mb-2">{{ __('Are you sure you want to delete your account?') }}</h4>

            <p class="text-sm text-muted mb-3">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full form-control"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="d-flex justify-content-end">
                <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>

                <x-danger-button class="ms-3 btn btn-danger">{{ __('Delete Account') }}</x-danger-button>
            </div>
        </form>
    </x-modal>
</div>