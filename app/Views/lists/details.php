<?= $this->extend('shared/_layout') ?>

<?= $this->section('content') ?>
<style>
    #tblPersons {
        zoom: 80%;
    }
</style>
<div class="row">

    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="<?= route('lists/index') ?>" class="btn btn-danger btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>

                <a href="#" class="btn btn-success btn-sm btn-enrich"> <i class="fa fa-tasks"></i> Enrich</a>
                <a href="#" class="btn btn-primary btn-sm btn-export"> <i class="fa fa-download"></i> Export</a>
                <a href="#" class="btn btn-warning btn-sm btn-merge"> <i class="fa fa-list"></i> Merge</a>
            </div>
            <div class="card-body">
                <h5 class="card-title">List Records</h5>
                <div class="table-responsive">
                    <table id="tblPersons" class="display table-hover" style="width:100%">
                        <thead>

                            <tr>
                                <?php
                                $arr = [];

                                $count = 0;
                                foreach ($columns as $column) :
                                    $strCol = str_replace('_', ' ', $column);
                                    $strVisible = true;
                                    if ($column == 'id' || $column == 'status')
                                        $strVisible = false;



                                    $arr[]  = [
                                        'data' => $column,
                                        'name' => $column,
                                        'title' => $strCol,
                                        'visible' => $strVisible,
                                        'orderable' => false
                                    ];

                                ?>
                                    <th><?= $strCol ?></th>
                                <?php

                                    $count++;
                                endforeach;
                                ?>

                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->include("lists/popups/enrichment.php"); ?>
<?= $this->include("lists/popups/export.php"); ?>
<?= $this->include("lists/popups/contacts.php"); ?>
<?= $this->include("lists/popups/merge.php"); ?>



<?= $this->endSection() ?>


<?= $this->section("scripts") ?>


<?php
$strColumns = json_encode($arr);

?>

<script>
    $(document).ready(function() {
        $('#ddColumns,#ddMergeColumns').select2({
            'width': '100%'
        });

    });

    var jsonColumns = JSON.parse('<?= $strColumns ?>');
    var table = $('#tblPersons').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: "<?= route('/lists/getdetailslist?id=') . $id ?>",
            type: "GET"
        },
        columns: jsonColumns
    });

    $(document).on('click', '.btn-enrich', function(e) {
        e.preventDefault();
        $('#modalEnrich').modal('show');
    });

    $(document).on('click', '.btn-export', function(e) {
        e.preventDefault();
        $('#modalExport').modal('show');
    });



    $(document).on('click', '.btn-merge', function(e) {
        e.preventDefault();
        $('#modalMerge').modal('show');
    });

    $(document).on('click','#tblPersons tbody tr',function(e){
        e.preventDefault();
        var rowData = table.row( this ).data();
        var site = $(rowData.<?=$domain_column?>).val();
        var url = "<?=route('/lists/get_contacts?site=')?>"+site;
        $.get(url,function(response,status){
            var tbody = createTBody(response.data);
            $('#tblContacts tbody').html(tbody);
            $('#modalContacts').modal('show');
        });

    });


    function createTBody(data)
    {
        var html = '';
        data.forEach((row)=>{
            html+=`<tr>`;
            html+=`<td>${row.firstname}</td>`;
            html+=`<td>${row.lastname}</td>`;
            html+=`<td>${row.personal_email}</td>`;
            html+=`<td>${row.work_email}</td>`;
            html+=`<td>${row.title}</td>`;
            html+=`<td>${row.category}</td>`;
            html+=`</tr>`;

        });
        return html;
    }
</script>
<?= $this->endSection() ?>