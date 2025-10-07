<form class="form-horizontal" action="{{route('admin.profile.update',Auth::guard('admin')->user()->id)}}" method="post">
    @csrf
    @method('put')
    <div class="form-group row">
        <x-input-label for="inputName" :value="__('Name')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputName" name="name" type="text" class="form-control" autocomplete="input-name" placeholder="Name" value="{{Auth::guard('admin')->user()->name}}" required/>
        </div>
    </div>
    <div class="form-group row">
        <x-input-label for="inputPhone" :value="__('Phone')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputPhone" name="phone" type="text" class="form-control" autocomplete="input-phone" placeholder="Phone" value="{{Auth::guard('admin')->user()->phone}}" required/>
        </div>
    </div>
    <div class="form-group row">
        <x-input-label for="inputPosition" :value="__('Position')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputPosition" name="position" type="text" class="form-control" autocomplete="input-position" placeholder="Position" value="{{Auth::guard('admin')->user()->position}}" required/>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
        </div>
    </div>
</form>