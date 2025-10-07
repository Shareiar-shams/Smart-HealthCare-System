<div class="tab-pane" id="preferences">
    <form class="form-horizontal" method="post" action="">
        @csrf
        @method('put')
        <div class="form-group row">
            <x-input-label for="theme" :value="__('Theme')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <select id="theme" name="theme" class="form-control">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="language" :value="__('Language')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <select id="language" name="language" class="form-control">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="notifications" :value="__('Notifications')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <input type="checkbox" id="notifications" name="notifications" checked>
                <label for="notifications">Enable notifications</label>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <x-primary-button class="btn btn-info">{{ __('Save Preferences') }}</x-primary-button>
            </div>
        </div>
    </form>
</div>