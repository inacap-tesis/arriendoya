<!-- Modal -->
<div class="modal fade" id="ventanaModal" @if ($static) data-backdrop="static" data-keyboard="false" @endif tabindex="-1" aria-labelledby="ventanaModalLabel" aria-hidden="true">
  <div class="modal-dialog {{ $size }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="titleModal" class="modal-title" id="ventanaModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="bodyModal" class="modal-body">
      </div>
      <div id="footerModal" class="modal-footer">
      </div>
    </div>
  </div>
</div>