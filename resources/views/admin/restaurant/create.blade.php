@extends('admin/layouts/dashboard')

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>
           Создание меню ресторана
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
                    {!! Form::open(array( 'url'=>'admin/restaurant/store', 'method' => 'post', 'files' => true)) !!}
                        @include('admin.restaurant._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>  
         <!-- /.container-fluid-->
    </section>
    
   
@stop
