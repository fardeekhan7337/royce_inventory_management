<div class="modal fade" id="deleteAjaxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">
              <p id="delete-msg">Are you sure you want to delete this record?</p>
              <?= getHiddenField('delete_product_url','');
              ?>
          </div>
          <div class="modal-footer">
              <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete-action-btn-txt">Delete</a>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
      </div>
  </div>
</div>
