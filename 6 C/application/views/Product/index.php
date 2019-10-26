<?php get_template('template/header') ?>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-lg-9">
                <h1>
                    Product
                    <small>Arkademy</small>
                </h1>
            </div>
            <div class="col-lg-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item active"><a href="#">Product</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-success mb-2 ml-2" onclick="tambah()">Add Product</button>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th width="30px">No.</th>
                                        <th width="80px">Action</th>
                                        <th>Cashier</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 grid-margin stretch-card">
                <div class="card">
                    <div class="detail p-3"></div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
                <a href="#" target="_blank">Mohammad Yusuf Noor Habibi</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
                <i class="mdi mdi-heart text-danger"></i>
            </span>
        </div>
    </footer>
</div>

<?php get_template('template/footer') ?>

<script>
    $(document).ready(function() {
        loadTable("<?php echo base_url('product/get_data') ?>", "table");

        $("input").change(function() {
            // $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            // $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
    });

    function tambah() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Product');
    }

    function ubah(id) {
        save_method = 'update';
        $('#form')[0].reset();

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url('product/ubah/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="cashier"]').val(data.id_cashier);
                $('[name="category"]').val(data.id_category);
                $('[name="price"]').val(data.price);
                $('[name="product"]').val(data.name_product);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Kehadiran'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        $('#btnSave').text('menyimpan...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('product/tambah') ?>";
        } else if (save_method == 'update') {
            url = "<?php echo base_url('product/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            cache: false,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    $('#table').DataTable().ajax.reload(null, false);
                    $('.detail').hide();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        // $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    function hapus(id) {
        if (confirm('Apakah anda yakin menghapus data ini?')) {

            $.ajax({
                url: "<?php echo base_url('product/hapus') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    $('#table').DataTable().ajax.reload(null, false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });

        }
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Cashier</label>
                            <div class="col-md-9">
                                <select name="cashier" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php foreach ($cashier as $key) : ?>
                                        <option value="<?= $key->id ?>"><?= $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select name="category" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php foreach ($category as $key) : ?>
                                        <option value="<?= $key->id ?>"><?= $key->name_category ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Product</label>
                            <div class="col-md-9">
                                <input name="product" placeholder="Ex: pizza" class="form-control" type="text">
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Price</label>
                            <div class="col-md-9">
                                <input name="price" placeholder="Ex: 10000" class="form-control" type="text">
                                <small class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->