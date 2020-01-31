@extends('layouts.backend.masterback')

@section('title','Favourite')

@push('extra_css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset ('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />

@endpush
    
@section('content')
    <div class="container-fluid">
        
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL FAVOURITE POSTS
                            <span class="badge bg-orange">{{ $posts->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">favorite</i></th>
                                        {{-- <th><i class="material-icons">comment</i></th> --}}
                                        <th><i class="material-icons">visibility</i></th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                       <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">favorite</i></th>
                                        {{-- <th><i class="material-icons">comment</i></th> --}}
                                        <th><i class="material-icons">visibility</i></th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($posts as $key=>$post)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ str_limit($post->title,'10') }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>{{ $post->favourite_to_users->count() }}</td>
                                            <td>{{ $post->view_count }}</td>
                                            
                                            <td class="text-center">
                                              <a href="{{ route('admin.post.show',$post->id) }}" class="btn btn-success btn-sm waves-effect">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm waves-effect" onclick="removePost({{ $post->id }})">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="remove-{{ $post->id }}" action="{{ route('post.favourite',$post->id) }}" method="POST" style="display: none">
                                                    @csrf
                                                    
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- #END# Exportable Table -->
    </div>


@push('extra_js')

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{ asset ('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset ('public/assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        function removePost(id)
        {
             const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                event.preventDefault();
                document.getElementById('remove-'+id).submit();
              } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                )
              }
            })
        }   
    </script>
    
@endpush


@endsection
