<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Поля данных</h3>
    </div>
          <!-- /.card-header -->

    <div class="card-body">
        <div class="form-group">
          <label for="name">Название акции</label>
          {!! Form::text('name', null, array('class' => 'form-control', 'placeholder'=>'Введите название')) !!}
        </div>
        <div class="form-group">
          <label for="name">Описание</label>
          {!! Form::textarea('description', null, array('class' => 'form-control', 'placeholder'=>'Enter message')) !!}
        </div>
        <div class="form-group img-area" >
            <label>
                Изображение
            </label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-default btn-sm">
                        <span class="fileupload-new">Загрузить</span>
                        {!! Form::file('image', null, array('class' => 'form-control')) !!}
                    </span>
            </div>
            @if(isset($event->image_URL) && !empty($event->image_URL))
                <span class="fileupload-preview">
                        <a href="{{URL::to($event->image_URL)}}" target="_blank" >
                            <img src="{{URL::to($event->image_URL)}}" style="max-height: 60px" class="img-responsive" alt="Image">
                        </a>
                    </span>
                <label class="check-for-delete-file">
                    <input type="checkbox" name="delete_image"  >
                    Удалить изображение
                </label>
            @endif
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('admin.clients')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</div>
<!-- /.card -->
