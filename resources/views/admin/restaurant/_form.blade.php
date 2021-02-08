<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Пожалуйста заполните форму</h3>
    </div>
          <!-- /.card-header -->

    <div class="card-body">
        <div class="form-group">
          <label for="name">Название меню</label>
          {!! Form::text('name', null, array('class' => 'form-control', 'placeholder'=>'Введите название')) !!}
        </div>
        <div class="form-group img-area" >
            <label>
                Главное изображение
            </label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-default btn-sm">
                        <span class="fileupload-new">Загрузить</span>
                        {!! Form::file('main_image_URL', null, array('class' => 'form-control')) !!}
                    </span>
            </div>
           
            @if(isset($restaurant->main_image_URL) && !empty($restaurant->main_image_URL))
                <span class="fileupload-preview">
                        <a href="{{URL::to($restaurant->main_image_URL)}}" target="_blank" >
                            <img src="{{URL::to($restaurant->main_image_URL)}}" style="max-height: 60px" class="img-responsive" alt="Image">
                        </a>
                    </span>
                
            @endif
        </div>
        <div class="form-group img-area" >
            <label>
                Изображение меню
            </label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-default btn-sm">
                        <span class="fileupload-new">Загрузить</span>
                     <!--   {!! Form::file('menu_image_URL[]', null, array('class' => 'form-control','multiple'=>true,'accept'=>'image/*')) !!} -->
                        
                        {{ Form::file('images[]', ['multiple']) }}
                    </span>
            </div>
           
            @if(isset($restaurant->menu_image_URL) && !empty($restaurant->menu_image_URL))
                <span class="fileupload-preview">
                        <a href="{{URL::to($restaurant->menu_image_URL)}}" target="_blank" >
                            <img src="{{URL::to($restaurant->menu_image_URL)}}" style="max-height: 60px" class="img-responsive" alt="Image">
                        </a>
                    </span>
                
            @endif
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('admin.restaurant')}}" class="btn btn-danger">Отмена</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>

</div>
<!-- /.card -->
