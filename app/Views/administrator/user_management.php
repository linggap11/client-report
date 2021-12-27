<?= $this->extend('administrator/layout/template') ?>

<?= $this->section('content') ?>

<div class="content">


    <div class="card">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert bg-success text-white alert-styled-left alert-dismissible m-2">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <span class="font-weight-semibold">Well done!</span> User Successfully Created <a href="#" class="alert-link"></a>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('delete')) : ?>
            <div class="alert bg-danger text-white alert-styled-left alert-dismissible m-2">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <span class="font-weight-semibold">Well done!</span> User Successfully Deleted <a href="#" class="alert-link"></a>
            </div>
        <?php endif ?>
        <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
            <div class="d-flex align-items-center mb-3 mb-lg-0">
                <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                    <i class="icon-table2"></i>
                </a>
                <div class="ml-3">
                    <h5 class="font-weight-semibold mb-0"><?= $users->getnumRows() ?></h5>
                    <span class="text-muted">Total Client</span>

                </div>
            </div>

            <div>
                <button type="button" class="btn btn-teal" data-toggle="modal" data-target="#modal_form_upload"><i class="icon-user-plus mr-2"></i>Add Client</button>
                <div id="modal_form_upload" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title">Add Client</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="<?= base_url('/add-client') ?>" method="POST" enctype="multipart/form-data" id="form">
                                <?php csrf_field() ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-user"></i></span>
                                            </span>
                                            <input type="text" class="form-control" name="fullname" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-office"></i></span>
                                            </span>
                                            <input type="text" class="form-control" name="company" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <Address></Address>Address
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-address-book3"></i></span>
                                            </span>
                                            <textarea class="form-control" name="address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-mail5"></i></span>
                                            </span>
                                            <input type="email" class="form-control" name="email" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-users2"></i></span>
                                            </span>
                                            <input type="text" class="form-control" name="username" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-lock2"></i></span>
                                            </span>
                                            <input type="password" name="new_password" class="form-control" autocomplete="false" id="password" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-lock2"></i></span>
                                            </span>
                                            <input type="password" name="confirm_password" class="form-control" autocomplete="false" id="confirm_password" value="">

                                        </div>
                                        <div class="message">
                                            <span id='message'></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-secondary disabled" id="btnAdd">Add <i class="icon-paperplane ml-2"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table datatable-basic" style="font-size: 12px;">
            <thead>
                <tr>
                    <th style="width:5%">No.</th>
                    <th>Client Name</th>
                    <th>Username</th>
                    <th>Company Name</th>
                    <th>Role</th>
                    <th class="text-center" style="width:5%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users->getNumRows() > 0) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($users->getResultArray() as $row) : ?>
                        <tr>
                            <td class="text-center"> <?= $no++ ?> </td>
                            </td>
                            <td>
                                <a href="#" class="text-body">
                                    <div class="font-weight-semibold"><?= $row['fullname'] ?></div>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?= $row['username'] ?></a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="#" class="text-body">
                                    <div class="font-weight-semibold"><?= $row['company'] ?></div>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="text-body">
                                    <div class="font-weight-semibold"><?= $row['role'] ?></div>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="<?= base_url('/edit-client/' . $row['id']) ?>" class="dropdown-item"><i class="icon-pencil text-primary"></i> Edit</a>
                                            <form action="<?= base_url('/delete-client/' . $row['id']) ?>" method="post">
                                                <?php csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="dropdown-item"><i class="icon-cross2 text-danger"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
    <!-- /blocks with chart -->

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script src="<?= base_url() ?>/assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/demo_pages/datatables_basic.js"></script>
<script>
    $(document).ready(function() {
        $('#password, #confirm_password').on('keyup', function() {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Password Matching').css('color', 'green');
                $('#btnAdd').removeClass('disabled');
            } else
                $('#message').html('Password not matching!').css('color', 'red');

        });
    });
</script>


<?= $this->endSection() ?>