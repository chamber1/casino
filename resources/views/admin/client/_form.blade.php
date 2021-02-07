<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Данные клиента</h3>
    </div>
        <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
          <label for="name">Имя</label>
          {!! Form::text('name', null, array('class' => 'form-control', 'placeholder'=>'')) !!}
        </div>
        <div class="form-group">
          <label for="name">Номер телефона</label>
          {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder'=>'')) !!}
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a href="{{ route('admin.clients')}}" class="btn btn-danger">Назад</a>
        <!-- <button type="submit" class="btn btn-primary">Сохранить</button> -->
    </div>
</div>
<!-- /.card -->
