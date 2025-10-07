<div class="tab-pane" id="delete_account">
    <form method="post" action="" class="form-horizontal" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        @csrf
        @method('delete')
        <div class="form-group row">
            <div class="col-sm-12">
                <p class="text-danger">Warning: Deleting your account is permanent and cannot be undone.</p>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <x-primary-button class="btn btn-danger">{{ __('Delete Account') }}</x-primary-button>
            </div>
        </div>
    </form>
</div>