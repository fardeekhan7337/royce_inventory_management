<div class="modal fade modal_select_sale_status" id="SaleStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">
              <h2>Change Sale Status</h2>

              <div class="row">

                <div class="col-sm-6 mt-3">

                    <?= getHiddenField('sale_status_id',0)  ?>
                    <label for="Customer" class="form-label">Status</label>

                    <select class="form-select form-select-sm" data-width="100%"
                        name="status" id="update_sale_status" required>

                        <option value="">select</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <!-- <option value="credit">Credit</option> -->

                    </select>

                </div>

              </div>
          </div>
          <div class="modal-footer">
              <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="sale-status-action-btn-txt" style="text-transform:capitalize!important">Deactive User</a>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
      </div>
  </div>
</div>
