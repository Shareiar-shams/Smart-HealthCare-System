<div class="col-sm-6">
<h1 class="m-0">Dashboard</h1>
</div><!-- /.col -->
@php 
  $list = json_encode(['Home', 'Dashboard']);
@endphp
<x-ad-breadcrumb :list="$list"/>

      