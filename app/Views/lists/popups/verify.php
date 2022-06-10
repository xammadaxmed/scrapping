<div class="modal fade" id="modalVerify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Verify Emails</h5>
            </div>
            <form action="<?= route('/lists/verify_emails') ?>" id="frmVerifyEmails" method="post">
                <div class="modal-body">
                    <input type="hidden" name="txtId" value="<?= $id ?>">
                    <div class="row">


                        <div class="form-group col-sm-12">
                            <label for="ddEmailColumns">Columns</label>
                            <select name="ddEmailColumns[]" id="ddEmailColumns" class="form-control" multiple>
                                <?php
                                foreach ($emailColumns as $column) {
                                    echo "<option selected value='$column'>$column</option>";
                                }
                                ?>
                            </select>
                            <hr>
                        </div>


                        <div class="form-group col-sm-12">
                            <button style="width:100%; margin-bottom: 20px;" id="btnVerifySubmit" class="btn btn-primary btn-block" type="submit">
                                Verify
                            </button>
                            <br>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
 



    $(document).on('submit', '#frmVerifyEmails', function(e) {
        e.preventDefault();
        // $('#btnVerifySubmit').attr('disabled',true);
        // $('#btnVerifySubmit').html('Processing <i class="fa fa-spinner fa-spin"></i>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(response, status) {
            // $('#modalVerify').modal('hide');
            showMessage(response.status, response.message);
           setTimeout(()=>{
            //    window.location.reload();
           },500);
        });
    });
</script>