<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="card card-primary">
    <div class="card-header">
            <h3 class="card-title">Test Data Fields</h3>
    </div>
          <!-- /.card-header -->

    <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Enter name')) !!}
        </div>
        <div class="form-group">
          <label for="name">Message</label>
          {!! Form::text('body', null, array('class' => 'form-control', 'placeholder'=>'Enter message')) !!}
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <a href="{{ route('admin.post')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</div>
<!-- /.card -->
