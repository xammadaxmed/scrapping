<div class="modal fade" id="modalMerge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Merge Columns</h5>
            </div>
            <form action="<?= route('/lists/merge') ?>" id="frmMerge" method="post">
                <div class="modal-body">
                    <input type="hidden" name="txtId" value="<?= $id ?>">
                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="txtMergeName">Column Name</label>
                            <input type="text" name="txtMergeName" id="txtMergeName" class="form-control">
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="ddMergeColumns">Columns</label>
                            <select name="ddMergeColumns[]" id="ddMergeColumns" class="form-control" multiple>
                                <?php
                                foreach ($columns as $column) {
                                    echo "<option value='$column'>$column</option>";
                                }
                                ?>
                            </select>
                            <hr>
                        </div>


                        <div class="form-group col-sm-12">
                            <button style="width:100%; margin-bottom: 20px;" id="btnMergeSubmit" class="btn btn-primary btn-block" type="submit">
                                Merge
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
 



    $(document).on('submit', '#frmMerge', function(e) {
        e.preventDefault();
        $('#btnMergeSubmit').attr('disabled',true);
        $('#btnMergeSubmit').html('Processing <i class="fa fa-spinner fa-spin"></i>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(response, status) {
            $('#modalMerge').modal('hide');
            showMessage(response.status, response.message);
           setTimeout(()=>{
               window.location.reload();
           },500);
        });
    });
</script>