@extends('dashboard.layouts.main')
@php

@endphp
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users</h1>
</div>

<div class="table-responsive col-lg-10 mb-5">

  <table id="users" class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
@endsection

@section('script')
<script>
  $(function () {
      var table = $('#users').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ordering: true,
          ajax: {
              url: "{{ url()->current() }}"
          },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'name', name: 'name'},
              {data: 'username', name: 'username'},
              {data: 'email', name: 'email'},
              {data: 'role', name: 'role'},
          ]
      });
  });
</script>
@endsection