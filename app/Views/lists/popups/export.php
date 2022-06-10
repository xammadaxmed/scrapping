

<style>
    .radio-label {
        display: inline-block;
        margin-right: 50px;
        ;
    }

    #contacstContainer{
        display: none;
    }
</style>


<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export</h5>
            </div>
            <form action="<?= route('/lists/export') ?>" id="frmExport" method="post">
                <div class="modal-body">
                    <input type="hidden" name="txtId" value="<?= $id ?>">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <div class="form-check">
                                <label for="rbExcel" class="radio-label">
                                    <input class="form-check-input" type="radio" name="rbFileType" id="rbExcel" value="EXCEL" checked /> Excel
                                </label>


                                <label for="rbText" class="radio-label">
                                    <input class="form-check-input" type="radio" name="rbFileType" id="rbText" value="TEXT" /> Text
                                </label>

                                <label for="rbCSV" class="radio-label">
                                    <input class="form-check-input" type="radio" name="rbFileType" id="rbCSV" value="CSV" /> CSV
                                </label>

                            </div>
                            <hr>


                        </div>


                        <div class="form-group col-sm-12">
                            <strong>Please Choose Columns To Export:</strong>
                            <div class="form-check">

                                <label for="rbOther" class="radio-label">
                                    <input class="form-check-input rb-type" type="radio" name="rbType" id="rbOther" checked value="OTHER" /> All
                                </label>
                                <br>
                                <label for="rbContacts" class="radio-label">
                                    <input class="form-check-input rb-type" type="radio" name="rbType" id="rbContacts" value="CONTACTS" /> Contacts
                                </label>

                            </div>
                            <hr>


                        </div>


                        <div class="form-group col-sm-12" >
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <a class="btn btn-info btn-sm btn-select-all">Select All</a>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <a class="btn btn-info btn-sm btn-deselect-all">DeSelect All</a>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <style>
                            #ddColumns.select2-container .select2-results {
                                max-height: 200px;
                            }

                            #ddColumns .select2-results {
                                max-height: 200px;
                            }

                            #ddColumns .select2-choices {
                                min-height: 150px;
                                max-height: 150px;
                                overflow-y: auto;
                            }
                        </style>

                    <div class="form-group col-sm-12" id="contacstContainer">
                            <label for="ddContactsColumns">Columns</label>
                            <select name="ddContactsColumns[]" id="ddContactsColumns" class="form-control" multiple style="height: 200px;">
                                <?php

                                
                                foreach ($contactsColumns as $column) {
                                    if ($column == 'id' || $column == 'status') {
                                        continue;
                                    }
                                    echo "<option selected value='$column'>$column</option>";
                                }
                                ?>

                            </select>
                            <hr>
                        </div>


                        <div class="form-group col-sm-12" id="columnsContainer">
                            <label for="ddColumns">Columns</label>
                            <select name="ddColumns[]" id="ddColumns" class="form-control" multiple style="height: 200px;">
                                <?php
                                foreach ($columns as $column) {
                                    if ($column == 'id' || $column == 'status') {
                                        continue;
                                    }
                                    echo "<option selected value='$column'>$column</option>";
                                }
                                ?>

                            </select>
                            <hr>
                        </div>


                        <div class="form-group col-sm-12">
                            <label>Please Choose Rows</label> <br>
                            <label for="txtFrom"> From : <input style="width:150px;" type="number" value="0" name="txtFrom" id="txtFrom"></label>
                            <label for="txtTo"> To : <input style="width:150px;" type="number" value="<?= $totalRows ?>" name="txtTo" id="txtTo"></label>
                            <hr>
                        </div>

                        <div class="form-group col-sm-12">
                            <button style="width:100%; margin-bottom: 20px;" class="btn btn-primary btn-block" type="submit">Export</button>
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


    $(document).on('click', '.rb-type', function() {
        if ($(this).val() == 'CONTACTS') {
            $('#columnsContainer').hide();
            $('#contacstContainer').show();
        } else {
            $('#columnsContainer').show();
            $('#contacstContainer').hide();

        }
    });
</script>