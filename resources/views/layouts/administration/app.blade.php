<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Meta Starts --}}
    @include('layouts.administration.partials_.metas')
    {{-- Meta Ends --}}
    <title>
      @section('title_content')
        @show
    </title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset(config('app.favicon')) }}" />
    @include('layouts.administration.partials_.admin-css')
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      @include('layouts.administration.navigation')
      <!-- /.navbar -->

      @include('layouts.administration.partials_.main-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      @section('content_header')
                        @show
                      {{-- @include('layouts.administration.partials_.content-header') --}}
                      
                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
              @section('main_content')
                  @show
            
          </section>
          <!-- /.content -->
      </div>
      @include('layouts.administration.partials_.footer')
      

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('layouts.administration.partials_.admin-js')

    @include('layouts.administration.partials_.confirm-delete')
    
</body>
</html>
