<?= $this->extend('shared/_layout') ?>

<?= $this->section('content') ?>
<style>
    .form-control {
        padding-top: 3px !important;
        padding-bottom: 3px !important;
    }
</style>
<div class="row">

    <div class="col">
        
        <div class="card">
            <div class="card-header">
            <!-- <button type="button" class="btn btn-primary btn-sm" onclick="showModal('#mdlAdd'); $('.column-container').html('')">Add New</button> -->
               
            </div>
            <div class="card-body">
                <h5 class="card-title">Templates List</h5>
                <table id="tblTemplates" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>List Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="mdlAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tamplate</h5>
            </div>
            <form id="frmTemplate" action="<?= route('templates/save') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="txtName">Template Name</label>
                            <input type="text" name="txtName" id="txtName" class="form-control form-control-sm" required>
                        </div>


                        <div class="col-sm-12 form-group">
                            <label for="txtDomain">Domain Column</label>
                            <input type="text" name="txtDomain" id="txtDomain" class="form-control form-control-sm" required>
                        </div>


                        <div class="col-sm-12 form-group">
                            <label for="fuTemplate">File</label>
                            <input type="file" name="fuTemplate" id="fuTemplate" class="form-control form-control-sm" required>

                        </div>

                        <input type="hidden" name="txtId">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="hideModal('#mdlAdd')">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section("scripts") ?>


<script>
   var table = $('#tblTemplates').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url:"<?= route('/templates/getlist') ?>",
            type: 'POST'
        }
    });


    $(document).on('submit', '#frmTemplate', function(e) {
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
                $('#mdlAdd').modal('hide');
                showMessage(data.status, data.message);
            }

        });

    });



    function remove($this) {
        $this = $($this);
        var $url = $this.attr('href');
        $.get($url,function(response,status){
            table.ajax.reload();
            showMessage(response.status,response.message)
        });

    }

    function details($this) {
        $this = $($this);
        var url = $this.attr('href');
        $.get(url, function(response, status) {
            if (response.status == "success") {
                var html = '';
                var master = response.data[0];
                $('#txtName').val(master.name);
                $('#txtName').attr('data-id', master.template_id);
                response.data.forEach((data) => {
                    html += `<tr>`;
                    html += `<th><input placeholder="Column Name" value="${data.column_name}" type="text" name="txtColumns[]" class="form-control" required></th>`;
                    html += `<th> <a class="btn btn-danger btn-sm btn-remove-col"> <i class="fa fa-times"></i> </a> </th>`;
                    html += `</tr>`;
                });
                $('.column-container').html('');
                $('.column-container').append(html);
                $('#mdlAdd').modal('show');
            }
        });
    }



    $(document).on('click', '.btn-remove-col', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });


</script>
<?= $this->endSection() ?>