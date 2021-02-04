<div class="modal-header">
 
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

</div>
<div class="modal-body">
   Вы действительно хотите удалить эту запись ?
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
  @if(!$error)
    <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">Да</a>
  @endif
</div>
