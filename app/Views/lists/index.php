<?= $this->extend('shared/_layout') ?>

<?= $this->section('content') ?>

<style>
    #linkIdContainer{
        display: none;
    }
    .btn-active
    {

    }
</style>
<div class="row">

    <div class="col">
        
        <div class="card">

        <div class="card-header">
        <button type="button" class="btn btn-primary btn-sm" onclick="showModal('#mdlAdd')">Add New</button>
        </div>
            <div class="card-body">
                <h5 class="card-title">Lists</h5>
               <table id="tblPersons" class="display" style="width:100%">
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
                <h5 class="modal-title" id="exampleModalLabel">New List</h5>
            </div>
            <form id="frmPerSonLlist" action="<?= route('lists/save') ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="txtName">List Name</label>
                            <input type="text" name="txtName" id="txtName" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-12 form-group">
                            <label for="ddListTemplate">List Template</label>
                            <select name="ddListTemplate" id="ddListTemplate" class="form-control form-control-sm">
                                <option value="">--SELECT--</option>
                                <?php
                                foreach($templates as $template):
                                    echo "<option value='$template->id'>$template->name</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-12 form-group">
                            <hr>
                            <a href="#" class="btn btn-primary btn-sm btn-tab btn-danger" data-show="#fuContainer" data-hide="#linkIdContainer">File</a>
                            <a href="#" class="btn btn-primary btn-sm btn-tab" data-show="#linkIdContainer" data-hide="#fuContainer">Source Id</a> 
                            <hr>
                        </div>

                        <div class="col-sm-12 form-group" id="fuContainer">
                            <label for="fuDomainList">Domain File</label>
                            <input type="file" name="fuDomainList" id="fuDomainList" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-12 form-group" id="linkIdContainer">
                            <label for="txtLinkId">File Id</label>
                            <input type="text" name="txtLinkId" id="txtLinkId" class="form-control form-control-sm" >
                        </div>

                        <input type="hidden" name="txtType" value="P">
                        <input type="hidden" name="txtId">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('#mdlAdd')">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section("scripts") ?>


<script>
    var table = $('#tblPersons').DataTable({
        serverSide: true,
        processing: true,
        ajax: "<?= route('/lists/getlist') ?>"
    });


    $(document).on('submit', '#frmPerSonLlist', function(e) {
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
               showMessage(data.status,data.message);
            }
           
        });

    });

    function remove($this)
    {
        var url = $this.attr('href');

        $.get(url,function(response,status){
               table.ajax.reload();
               showMessage(data.status,data.message);
        });
    }
    function details($this)
    {
        var url = $this.attr('href');
        window.open(url,'_blank');
    }

    $(document).on('click','.btn-tab',function(e){
        e.preventDefault();
        $('.btn-tab').removeClass('btn-danger');
        var show = $(this).attr('data-show');
        var hide = $(this).attr('data-hide');
        $(show).show();
        $(hide).hide();
        $(this).addClass('btn-danger');
    });
</script>
<?= $this->endSection() ?>