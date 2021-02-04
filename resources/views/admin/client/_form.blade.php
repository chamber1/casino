<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Пожалуйста заполните форму</h3>
    </div>
          <!-- /.card-header -->

    <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          {!! Form::text('name', null, array('class' => 'form-control', 'placeholder'=>'Enter name')) !!}
        </div>
        <div class="form-group">
          <label for="name">Phone number</label>
          {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder'=>'Enter message')) !!}
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          {!! Form::text('password', null, array('class' => 'form-control','type'=>'password', 'placeholder'=>'Enter message')) !!}
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('admin.clients')}}" class="btn btn-danger">Назад</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>

</div>
<!-- /.card -->
