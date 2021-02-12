<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Пожалуйста заполните форму</h3>
    </div>
          <!-- /.card-header -->

    <div class="card-body">
        <div class="form-group">
          <label for="name">Название</label>
          {!! Form::text('name', null, array('class' => 'form-control', 'placeholder'=>'Введите название')) !!}
        </div>
        <div class="form-group img-area" >
            <label>
                Иконка
            </label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-default btn-sm">
                        <span class="fileupload-new">Загрузить</span>
                        {!! Form::file('icon', null, array('class' => 'form-control')) !!}
                    </span>
            </div>
           
            @if(isset($pokerclub->icon) && !empty($pokerclub->icon))
                <span class="fileupload-preview">
                        <a href="{{URL::to($pokerclub->icon)}}" target="_blank" >
                            <img src="{{URL::to($pokerclub->icon)}}" style="max-height: 60px" class="img-responsive" alt="Image">
                        </a>
                    </span>
                
            @endif
        </div>
        <div class="form-group">
          <label for="name">Бай Ин</label>
          {!! Form::text('by_in', null, array('class' => 'form-control', 'placeholder'=>'')) !!}
        </div>
        <div class="form-group">
          <label for="name">Стек</label>
          {!! Form::text('stack', null, array('class' => 'form-control', 'placeholder'=>'')) !!}
        </div>
        <div class="form-group">
          <label for="name">Уровни</label>
          {!! Form::text('levels', null, array('class' => 'form-control', 'placeholder'=>'')) !!}
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('admin.pokerclub')}}" class="btn btn-danger">Отмена</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>

</div>
<!-- /.card -->
