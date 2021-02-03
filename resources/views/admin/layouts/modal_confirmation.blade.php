<div class="modal-header">
 
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

</div>
<div class="modal-body">
   Do you really want to delete this record?
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
  @if(!$error)
    <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">Yes</a>
  @endif
</div>
