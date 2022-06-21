<style>
    .radio-label {
        display: inline-block;
        margin-right: 50px;
    }

    #contactsContainer {
        display: none;
    }
</style>


<div class="modal fade" id="modalEnrich" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-danger"> <strong id="lblEnrich"> <?= $totalRows ?> Records will be sent for Enrichment</strong> </label>
            </div>
            <form action="<?= route('/lists/enrich') ?>" id="frmEnrich" method="post">
                <div class="modal-body">
                    <input type="hidden" name="txtId" value="<?= $id ?>">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <div class="form-check">
                                <label for="rbExcel" class="radio-label">
                                    <input class="form-check-input rb-enrich-type" type="radio" name="rbType" id="rbExcel" value="COMPANY" checked /> Company
                                </label>


                                <label for="rbText" class="radio-label">
                                    <input class="form-check-input rb-enrich-type" type="radio" name="rbType" id="rbText" value="CONTACT" /> Contact
                                </label>

                                <label for="rbCSV" class="radio-label">
                                    <input class="form-check-input rb-enrich-type" type="radio" name="rbType" id="rbCSV" value="BOTH" /> Both
                                </label>

                            </div>
                            <hr>


                        </div>

                        <div id="contactsContainer">
                            <div class="form-group col-sm-12">
                                <label for="ddCategory">Category</label>
                                <select name="ddCategory" id="ddCategory" class="form-control">
                                    <?php
                                    foreach ($titles as $title) {
                                        echo "<option>$title->name</option>";
                                    }
                                    ?>
                                </select>
                                <hr>
                            </div>


                            <div class="form-group col-sm-12">
                                <label for="txtMaxMails">Max Mails Per Domain</label>
                                <input type="number" name="txtMaxMails" value="20" id="txtMaxMails" class="form-control">
                                <hr>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="txtKeyWords">Additional Keywords</label>
                                <input type="text" name="txtKeyWords" id="txtKeyWords" class="form-control">
                                <hr>
                            </div>
                        </div>




                        <div class="form-group col-sm-12">
                            <button style="width:100%; margin-bottom: 20px;" id="btnEnrichSubmit" class="btn btn-primary btn-block" type="submit">
                                Enrich
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
    $(document).on('click', '.btn-select-all', function() {
        $('#ddColumns').select2('destroy').find('option').prop('selected', 'selected').end().select2();
    });

    $(document).on('click', '.btn-deselect-all', function() {
        $('#ddColumns').select2('destroy').find('option').prop('selected', false).end().select2();
    });


    $(document).on('click', '.rb-enrich-type', function() {
        if ($(this).val() != 'COMPANY') {
            $('#contactsContainer').show();
        } else {
            $('#contactsContainer').hide();
        }

    });


    $(document).on('submit', '#frmEnrich', function(e) {
        e.preventDefault();
        $('#btnEnrichSubmit').attr('disabled',true);
        $('#btnEnrichSubmit').html('Processing <i class="fa fa-spinner fa-spin"></i>');
        var url = $(this).attr('action');
        $.post(url, $(this).serialize(), function(response, status) {
            $('#modalEnrich').modal('hide');
            showMessage(response.status,response.message);
            setTimeout(() => {
                window.location.reload()
            }, 500);
        });
    });
</script>