@if ($errors->any())                 
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-block">
            <a type="button" class="close" data-dismiss="alert"></a> 
            <strong>{{ $error }}</strong>
        </div>
    @endforeach						                   
@endif