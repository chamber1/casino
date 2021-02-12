@extends('admin/layouts/dashboard')

@section('header_styles')

    <link href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    
    <link  href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
@endsection


@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Покерный клуб</h1>
           
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Домашняя</a></li>
              <li class="breadcrumb-item active">Покерный клуб</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Таблица акций </h3>
                        </div>
                          <!-- /.card-header -->
                        <div class="card-body">
                            <div class="pull-right">
                                <a href="{{ URL::to('admin/pokerclub/create') }}" class="btn btn-sm btn-primary">
                                    <i class="material-icons add">Добавить</i> 
                                </a>
                            </div>
                            
                        
                            <table id="table1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                      <th>Название</th>
                                      <th>Иконка</th>
                                      <th>Бай ин</th>
                                      <th>Стек</th>
                                      <th>Уровни</th>
                                      <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                <!-- /.col -->
              </div>
            <!-- /.row -->
          </div>
        </div>  
         <!-- /.container-fluid -->
    </section>
        <!-- /.content -->
@endsection

            



{{-- test scripts --}}
@section('footer_scripts')


<!-- DataTables -->
<script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script  type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>



<script>
       
    
    $(function() {
            var table = $('#table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.pokerclub.data') !!}',
                order: [[ 1, "desc" ]],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'icon', name: 'icon',render: previewImg},
                    { data: 'by_in', name: 'by_in', },
                    { data: 'stack', name: 'stack', },
                    { data: 'levels', name: 'levels', },
                    { data: 'action', name: 'action', width:'200px', orderable: false, searchable: false },

                ]
            });
        });
        
        function previewImg(data, type, full, meta) {
           return '<img height="100px" src="'+data+'" />';
        }
        
    </script>


<div class="modal" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="blogbrand_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

<script>

@stop

 
    
   