@extends('admin.layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Post</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $title . ' ' . $post['title'] }}</h3>
            <div class="float-right">
              <a href="{{ route('posts.edit', [$post['id']]) }}" class="btn btn-warning btn-sm"><i
                  class="fas fa-pencil-alt pr-1"></i>Edit</a>
              <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#ModalCenter{{ $post['id'] }}"><i class="fas fa-trash pr-1"></i>Delete</a>
              <!-- Modal -->
              <div class="modal fade" id="ModalCenter{{ $post['id'] }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header  bg-danger">
                      <h5 class="modal-title" id="exampleModalLongTitle">Warning</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure want to delete <b>{{ ucfirst($post['title']) }}</b> ?
                    </div>
                    <div class="modal-footer">
                      <form action="{{ route('posts.destroy', $post['id']) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="mb-4">
              <a href="#" class="btn btn-sm btn-outline-primary disabled" tabindex="-1" role="button"
                aria-disabled="true">Category: {{ $post->getCategory['name'] }}</a>
              <a href="#" class="btn btn-sm btn-outline-primary disabled" tabindex="-1" role="button"
                aria-disabled="true">Subcategory: {{ $post->getSubcategory['subname'] }}</a>
              <a href="#" class="btn btn-sm btn-outline-danger disabled" tabindex="-1" role="button"
                aria-disabled="true">By: {{ $post->getUser['name'] }}</a>
              <a href="#" class="btn btn-sm btn-outline-secondary disabled float-right" tabindex="-1" role="button"
                aria-disabled="true"><i class="far fa-calendar-alt pr-1"></i>
                @php
                $lnChar = strlen($post['created_at']) - 8;
                echo substr($post['created_at'], 0, $lnChar)
                @endphp
              </a>
            </div>
            <h3 class="text-center mb-2">{{ $post['title'] }}</h3>
            <div class="justify-contnet-center mb-2">
              <img src="{{ asset('post/' . $post['image']) }}" class="d-block w-100">
            </div>
            <article>
              {!! $post['content'] !!}
            </article>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push('addon-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
@endpush

@push('addon-script')
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/dist/js/demo.js') }}"></script>
<!-- Toaster -->
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
<!-- page script -->

@endpush