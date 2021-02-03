@extends('admin/layouts/dashboard')

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>
            Edit Record # {{$eventModel->id}}
        </h1>
    </section>
    <!--section ends-->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                {!! Form::model($eventModel, array( 'url'=>'admin/event/'.$eventModel->id.'/update', 'method' => 'post')) !!}
                    @include('admin.event._form')
                {!! Form::close() !!}
                </div>
            </div>
        </div>  
         <!-- /.container-fluid 'url' => URL::to('admin/test/' . $testModel->id), -->
    </section>
    
   
@stop
