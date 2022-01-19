<?= $this->extend('administrator/layout/template') ?>

<?= $this->section('content') ?>

<div class="content">
    <div class="card">
        <form class="wizard-form steps-async wizard clearfix" action="<?= base_url() ?>/save-assignment" method="post" data-fouc="" role="application" id="steps-uid-1">
            <?= csrf_field() ?>
            <div class="steps clearfix">
                <ul role="tablist">
                    <li role="tab" class="disabled" aria-disabled="true" aria-selected="true"><a id="steps-uid-1-t-0" href="#steps-uid-1-h-0" aria-controls="steps-uid-1-p-0" class=""><span class="current-info audible">current step: </span><span class="number">1</span> Box Assignment</a></li>
                    <li role="tab" class="first current" aria-disabled="false" aria-selected="true"><a id="steps-uid-1-t-1" href="#steps-uid-1-h-1" aria-controls="steps-uid-1-p-1" class="disabled"><span class="number">2</span> Assignment Process</a></li>
                    <li role="tab" class="disabled" aria-disabled="true"><a id="steps-uid-1-t-2" href="#steps-uid-1-h-2" aria-controls="steps-uid-1-p-2" class="disabled"><span class="number">3</span> Completed Assignment</a></li>
                </ul>
            </div>
            <table class="table datatable-basic" id="myTable" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center" style="width: 10%">Box Name</th>
                        <th class="text-center" style="width: 10%">Status</th>
                        <th class="text-center" style="width: 15%">Box Value</th>
                        <th class="text-center" style="width: 5%">Order</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">AMZ Store</th>
                        <th class="text-center">Current</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody id="assign-body">
                    <?php if ($getAllAssignReport->getNumRows() > 0) : ?>
                        <?php $no = 1 ?>
                        <?php foreach ($getAllAssignReport->getResultArray() as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['box_name'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td class="value_box_<?= $no ?>">$ <?= $row['box_value'] ?></td>
                                <td>
                                    <input type="text" class="daterange-single" name="date[]" value="10/01/2022" style="width: 90px; text-align:center">
                                </td>
                                <td>
                                    <select class="form-control clientSelect select-search" name="client[]" id="box_<?= $no ?> " data-fouc>
                                        <option>Select Client</option>
                                        <?php foreach ($getAllClient->getResultArray() as $client) : ?>
                                            <option value="<?= $client['id'] ?>"><?= $client['fullname'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="company_box_<?= $no ?>"></td>
                                <td class="currentCost_box_<?= $no ?>"></td>
                                <td class="total_box_<?= $no ?>"></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>

            </table>
            <div class="card-body text-right">
                <button type="submit" class="btn btn-secondary"><i class="icon-checkmark3"></i> Save</button>
            </div>
        </form>

    </div>
    <!-- /blocks with chart -->
    <button type="button" id="noty_created" style="display: none;"></button>
    <button type="button" id="noty_deleted" style="display: none;"></button>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="/assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="/assets/js/demo_pages/picker_date.js"></script>
<script src="/assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="/assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/assets/js/demo_pages/datatables_basic.js"></script>
<script src="/assets/js/plugins/notifications/jgrowl.min.js"></script>
<script src="/assets/js/plugins/notifications/noty.min.js"></script>
<script src="/assets/js/demo_pages/extra_jgrowl_noty.js"></script>
<script src="/assets/js/demo_pages/form_select2.js"></script>
<script src="/assets//js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="/assets//js/plugins/forms/selects/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('success')) : ?>
            $('#noty_created').click();
        <?php endif ?>
        <?php if (session()->getFlashdata('delete')) : ?>
            $('#noty_deleted').click();
        <?php endif ?>
        $(".clientSelect").select2({
            width: '150px'
        });

        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
        $(".floatTextBox").inputFilter(function(value) {
            return /^-?\d*[.]?\d*$/.test(value);
        });

    });
    var i = 1;
    var tempTotal = 0;
    var total = 0;
    $('.clientSelect').on('change', function() {
        var boxId = $(this).attr('id');
        var valueBoxId = "value_" + $(this).attr('id');
        var valueBox = $('.' + valueBoxId).html();
        var valueBox = valueBox.substring(2);

        var clientId = this.value;

        console.log(valueBox);
        $.get('/get-company/' + clientId, function(data) {
            if (data != 'null') {
                var client = JSON.parse(data);
                if (i == 1) {
                    tempTotal = parseFloat(client['cost']);
                    i = 4;
                }
                total = tempTotal - parseFloat(valueBox);
                if (total <= -500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Total exceed $500.00!'
                    })
                } else {
                    $('.company_' + boxId).html("<b>22" + client['company'] + "</b>");
                    $('.currentCost_' + boxId).html("<b>$ " + numberWithCommas(client['cost']) + "</b>");
                    $('.total_' + boxId).html("<b>$ " + numberWithCommas(total.toFixed(2)) + "</b>");
                    tempTotal = total;
                }

            } else {
                $('.company_' + boxId).html("");
                $('.currentCost_' + boxId).html("");
                $('.total_' + boxId).html("");
            }

        })
    });
    $('#noty_created').on('click', function() {
        new Noty({
            text: 'You successfully upload the report.',
            type: 'success'
        }).show();
    });
    $('#noty_deleted').on('click', function() {
        new Noty({
            text: 'You successfully delete the report.',
            type: 'alert'
        }).show();
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var input = document.getElementById('file-upload');
    var infoArea = document.getElementById('file-upload-filename');

    input.addEventListener('change', showFileName);

    function showFileName(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea.textContent = '' + fileName;
    }
</script>

<?= $this->endSection() ?>