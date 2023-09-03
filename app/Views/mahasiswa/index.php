<?= $this->extend('layout/template'); ?>

<?= $this->section("css") ?>
<!-- DataTables -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<section>
  <div class="container">
    <div class="card my-4">
      <div class="card-header">
        <div class="d-flex justify-content-between items-align-center">
          <h3>Daftar Mahasiswa</h3>
          <button type="button" class="btn btn-primary" data-toggle="modal" onclick="ModalTambah()">
            <i class="fa-solid fa-plus"></i> Tambah data
          </button>
        </div>
      </div>
      <div class="card-body">
        <table id="tabel_mhs" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Mahasiswa</th>
              <th scope="col">NIM</th>
              <th scope="col">Jenis Kelamin</th>
              <th scope="col">Kelas</th>
              <th scope="col">Program Studi</th>
              <th scope="col">Foto</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Start: Modal tambah -->
<div class="modal fade" id="tambahMhs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form tambah mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_tambah_mhs" method="post" enctype="multipart/form-data" action="javascript:TambahMahasiswa();">
          <?= csrf_field(); ?>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="nama_mhs">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="nama_mhs" name="nama_mhs">
                <small class="text-danger error-nama"></small>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="nim_mhs">Nomor Induk Mahasiswa</label>
                <input type="text" class="form-control" id="nim_mhs" name="nim_mhs">
                <small class="text-danger error-nim"></small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="jenkel_mhs">Jenis Kelamin</label>
                <select class="form-control" id="jenkel_mhs" name="jenkel_mhs">
                  <option>-Pilih-</option>
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="jenkel_mhs">Program Studi Mahasiswa</label>
                <select class="form-control" id="prodi_mhs" name="prodi_mhs">
                  <option>-Pilih-</option>
                  <?php
                  foreach ($prodi as $key => $value) {
                  ?>
                    <option value="<?= $value->id ?>"><?= $value->prodi ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="prodi_mhs">Kelas</label>
                <input type="text" class="form-control" id="kelas_mhs" name="kelas_mhs">
                <small class="text-danger error-kelas"></small>
              </div>
            </div>
            <div class="col-6">
              <label for="foto_mhs">Upload Foto</label>
              <div class="custom-file">
                <div class="custom-file mb-3">
                  <input type="file" class="form-control" id="foto_mhs" name="foto_mhs">
                  <small class="text-danger error-foto"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="add_mhs">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End: Modal tambah -->

<!-- Start: Modal edit -->
<div class="modal fade" id="editMhs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form edit mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_ubah_mhs" method="post" enctype="multipart/form-data" action="javascript:UpdateMahasiswa();">
          <?= csrf_field(); ?>
          <input type="hidden" class="form-control" id="id" name="id">
          <input type="hidden" class="form-control" id="ofoto_mhs" name="ofoto_mhs">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="nama_mhs">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="nama_mhs" name="nama_mhs">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="nim_mhs">Nomor Induk Mahasiswa</label>
                <input type="text" class="form-control" id="nim_mhs" name="nim_mhs">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="jenkel_mhs">Jenis Kelamin</label>
                <select class="form-control" id="jenkel_mhs" name="jenkel_mhs">
                  <option>-Pilih-</option>
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="jenkel_mhs">Program Studi Mahasiswa</label>
                <select class="form-control" id="prodi_mhs" name="prodi_mhs">
                  <option>-Pilih-</option>
                  <?php
                  foreach ($prodi as $key => $value) {
                  ?>
                    <option value="<?= $value->id ?>"><?= $value->prodi ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="prodi_mhs">Kelas</label>
                <input type="text" class="form-control" id="kelas_mhs" name="kelas_mhs">
              </div>
            </div>
            <div class="col-6">
              <label for="foto_mhs">Upload Foto</label>
              <div class="custom-file">
                <div class="custom-file mb-3">
                  <input type="file" class="form-control" id="foto_mhs" name="foto_mhs">
                  <small class="text-danger error-foto"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="edit_mhs">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End: Modal edit -->

<?= $this->endSection(); ?>

<!-- page script -->
<?= $this->section("script") ?>

<!-- Required datatable js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tabel_mhs').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollX": true,
      "scrollY": false,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?= base_url("mahasiswa/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });

  function ModalTambah() {
    $('#form_tambah_mhs')[0].reset();
    $('#tambahMhs').modal('show');
  }

  function ModalEdit() {
    $('#form_ubah_mhs')[0].reset();
    $('#editMhs').modal('show');
  }

  function TambahMahasiswa() {
    var form = $('#form_tambah_mhs');
    var formData = new FormData(form[0]);
    $('#add_mhs').attr('disabled');
    $("#add_mhs").html('<i class="fa fa-spin fa-spinner"></i> Loading...');
    $.ajax({
      url: "<?= base_url(); ?>mahasiswa/TambahMahasiswa",
      type: "post",
      dataType: "json",
      data: formData,
      enctype: 'multipart/form-data',
      cache: false,
      contentType: false, // Let jQuery handle content type
      processData: false, // Don't process data, let jQuery handle it
      success: function(respon) {
        if (respon.error) {
          if (respon.error.nama_mhs) {
            $('#nama_mhs').addClass('is-invalid');
            $('.error-nama').html(respon.error.nama_mhs);
          } else {
            $('#nama_mhs').removeClass('is-invalid');
            $('.error-nama').html('');
          }

          if (respon.error.nim_mhs) {
            $('#nim_mhs').addClass('is-invalid');
            $('.error-nim').html(respon.error.nim_mhs);
          } else {
            $('#nim_mhs').removeClass('is-invalid');
            $('.error-nim').html('');
          }

          if (respon.error.jenkel_mhs) {
            $('#jenkel_mhs').addClass('is-invalid');
            $('.error-jenkel').html(respon.error.jenkel_mhs);
          } else {
            $('#jenkel_mhs').removeClass('is-invalid');
            $('.error-jenkel').html('');
          }

          if (respon.error.kelas_mhs) {
            $('#kelas_mhs').addClass('is-invalid');
            $('.error-kelas').html(respon.error.kelas_mhs);
          } else {
            $('#kelas_mhs').removeClass('is-invalid');
            $('.error-kelas').html('');
          }

          if (respon.error.prodi_mhs) {
            $('#prodi_mhs').addClass('is-invalid');
            $('.error-prodi').html(respon.error.prodi_mhs);
          } else {
            $('#prodi_mhs').removeClass('is-invalid');
            $('.error-prodi').html('');
          }

          if (respon.error.foto_mhs) {
            $('#foto_mhs').addClass('is-invalid');
            $('.error-foto').html(respon.error.foto_mhs);
          } else {
            $('#foto_mhs').removeClass('is-invalid');
            $('.error-foto').html('');
          }

        } else {
          if (respon.status) {
            $('#tambahMhs').modal('hide');
            Swal.fire({
              icon: 'success',
              text: respon.msg,
            }).then(function() {
              $('#tabel_mhs').DataTable().ajax.reload(null, false).draw(false);
            })
            $('#add_mhs').removeAttr('disable');
            $('#add_mhs').html('Simpan');
          } else {
            Swal.fire({
              icon: 'warning',
              text: respon.msg,
            });
          }
        }
      }
    });
  }

  function EditMahasiswa(id) {
    $.ajax({
      url: "<?= base_url() ?>mahasiswa/getOne",
      type: "post",
      data: {
        id: id
      },
      dataType: "json",
      success: function(respon) {
        ModalEdit();
        //insert data to form
        $("#form_ubah_mhs #id").val(respon.id);
        $("#form_ubah_mhs #ofoto_mhs").val(respon.foto);
        $("#form_ubah_mhs #nama_mhs").val(respon.nama);
        $("#form_ubah_mhs #nim_mhs").val(respon.nim);
        $("#form_ubah_mhs #jenkel_mhs").val(respon.jen_kel);
        $("#form_ubah_mhs #kelas_mhs").val(respon.kelas);
        $("#form_ubah_mhs #prodi_mhs").val(respon.prodi);
      }
    });
  }

  function UpdateMahasiswa() {
    var form = $('#form_ubah_mhs');
    var formData = new FormData(form[0]);
    $('#edit_mhs').attr('disabled');
    $("#edit_mhs").html('<i class="fa fa-spin fa-spinner"></i> Loading...');
    $.ajax({
      url: "<?= base_url() ?>mahasiswa/UpdateMahasiswa",
      type: "post",
      data: formData,
      enctype: 'multipart/form-data',
      cache: false,
      contentType: false, // Let jQuery handle content type
      processData: false, // Don't process data, let jQuery handle it
      dataType: "json",
      success: function(respon) {
        if (respon.status) {
          $('#editMhs').modal('hide');
          Swal.fire({
            icon: 'success',
            text: respon.msg,
          }).then(function() {
            $('#tabel_mhs').DataTable().ajax.reload(null, false).draw(false);
          })
          $('#edit_mhs').removeAttr('disable');
          $('#edit_mhs').html('Update');
        } else if (respon.status) {
          Swal.fire({
            icon: 'warning',
            text: respon.msg,
          });
        }
      }
    });
  }

  function HapusMahasiswa(id) {
    $.ajax({
      url: "<?= base_url() ?>mahasiswa/HapusMahasiswa",
      type: "post",
      data: {
        id: id
      },
      dataType: "json",
      success: function(respon) {
        if (respon.status) {
          Swal.fire({
            icon: 'success',
            text: respon.msg,
          }).then(function() {
            $('#tabel_mhs').DataTable().ajax.reload(null, false).draw(false);
          })
        } else {
          Swal.fire({
            icon: 'warning',
            text: respon.msg,
          });
        }
      }
    });
  }
</script>

<?= $this->endSection(); ?>