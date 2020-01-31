@extends('layouts.backend.masterback')

@section('title','All_Authors')

@push('extra_css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset ('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />

@endpush


@section('content')
    

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            
            <a class="btn btn-info waves-effect" href="{{ route('admin.category.create') }}"><i class="material-icons">add</i> <span style="font-size: 14px;">Add New</span> </a>
            
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL AUTHORS
                            <span class="badge bg-orange">{{ $authors->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Posts</th>
                                        <th>Comments</th>
                                        <th>Favourite Posts</th>                                        
                                        <th>Created At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                       <th>ID</th>
                                        <th>Name</th>
                                        <th>Posts</th>
                                        <th>Comments</th>
                                        <th>Favourite Posts</th>                                        
                                        <th>Created At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($authors as $key=>$author)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $author->name }}</td>
                                            <td>{{ $author->posts_count }}</td>
                                            <td>{{ $author->favourite_posts_count }}</td>
                                            <td>{{ $author->comments_count }}</td>
                                            <td>{{ $author->created_at->toDateString() }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm waves-effect" onclick="deleteAuthors({{ $author->id }})">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="delete-{{ $author->id }}" action="{{ route('admin.author.destroy',$author->id) }}" method="POST" style="display: none">
                                                    @csrf
                                                    @method('DELETE')
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
        function deleteAuthors(id)
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
                document.getElementById('delete-'+id).submit();
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
