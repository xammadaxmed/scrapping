<div class="modal fade" id="mdlUploadMore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload More</h5>
            </div>
            <form id="frmUploadMore" action="<?= route('lists/upload') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">  

                        <div class="col-sm-12 form-group" >
                            <label for="fuDomainList"> File</label>
                            <input type="file" name="fuUploadMore" id="fuUploadMore" class="form-control form-control-sm" required>
                        </div>

                        <input type="hidden" name="txtId" value="<?=$id?>">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('#mdlUploadMore')">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

$(document).on('submit', '#frmUploadMore', function(e) {
        e.preventDefault();
        var _url = $(this).attr('action');
        var formData = new FormData(this);
        $.ajax({
            url: _url,
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                table.ajax.reload();
                $('#mdlUploadMore').modal('hide');
               showMessage(data.status,data.message);
            }
           
        });

    });

</script>