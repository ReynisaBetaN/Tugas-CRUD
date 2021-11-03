<?php
include "model/m_data.php";

$dt = new Data($connection);

if(@$_GET['act'] == '') {
?>
  <div class="row">
          <div class="col-lg-12">
            <h1>Data <small>Data Mahasiswa</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Data</a></li>
            </ol>
          </div>
        </div>

        <div class="row">
           <div class="col-lg-12">
           		<div class="table-responsive">
           			<table class="table table-bordered table-hover table-striped">
           				<tr>
           					<th>ID</th>
           					<th>NIM Mahasiswa</th>
           					<th>Nama Mahasiswa</th>
           					<th>Jenis Kelamin</th>
           					<th>Alamat</th>
           					<th>Kota</th>
           					<th>Email</th>
           					<th>Foto</th>
           					<th>Pilihan</th>
           				</tr>
                  <?php
                  $no = 1;
                  $tampil = $dt->tampil();
                  while ($mhs = $tampil->fetch_object()){
                  ?>
           				<tr>
           				    <td align="center"><?php echo $no++."."; ?></td>
           				    <td><?php echo $mhs->nim; ?></td>
           				    <td><?php echo $mhs->namamhs; ?></td>
           				    <td><?php echo $mhs->jk; ?></td>
           				    <td><?php echo $mhs->alamat; ?></td>
           				    <td><?php echo $mhs->kota; ?></td>
           				    <td><?php echo $mhs->email; ?></td>
           				    <td>
                        <img src="assets/image/jpg/<?php echo $mhs->foto; ?>" width = "70px">
                      </td>
           				    <td align="center">
                        <a id="edit_dt" data-toggle="modal" data-target="#edit" data-id="<?php echo $mhs->id; ?>" data-nim="<?php echo $mhs->nim; ?>" data-nama="<?php echo $mhs->namamhs; ?>" data-jk="<?php echo $mhs->jk; ?>" data-alamat="<?php echo $mhs->alamat; ?>" data-kota="<?php echo $mhs->kota; ?>" data-email="<?php echo $mhs->email; ?>" data-gambar="<?php echo $mhs->foto; ?>">
           				    	<button class="btn btn-info btn-xs"><i class="fa fa-edit"></i>Update</button></a>
                        <a href="?page=Data&act=del&id=<?php echo $mhs->id ?>" onclick="return confirm('Hapus Data?')">
           				      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                        </a>
           				    </td>
           				</tr>
                  <?php
                  }?>
           			</table>
           		</div>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah">Create</button>

              <div id="tambah" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modul-title">Insert Data</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="form-group">
                          <label class="control-label" for="nim">NIM Mahasiswa</label>
                          <input type="number" name="nim" class="form-control" id="nim" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="namamhs">Nama Mahasiswa</label>
                          <input type="text" name="namamhs" class="form-control" id="namamhs" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="jk">Jenis Kelamin</label>
                          <input type="text" name="jk" class="form-control" id="jk" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="alamat">Alamat</label>
                          <input type="text" name="alamat" class="form-control" id="alamat" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="kota">Kota</label>
                          <input type="text" name="kota" class="form-control" id="kota" required>
                        </div>
                       <div class="form-group">
                          <label class="control-label" for="email">Email</label>
                          <input type="text" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="foto">Foto</label>
                          <input type="file" name="foto" class="form-control" id="foto" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                          <button type="reset" class="btn btn-danger">Reset</button>
                          <input type="submit" class="btn btn-success" name="tambah" value="Save">
                      </div>
                    </form>
                  <?php
                  if(@$_POST['tambah']) {
                    $nim = $connection->conn->real_escape_string($_POST['nim']);
                    $namamhs = $connection->conn->real_escape_string($_POST['namamhs']);
                    $jk = $connection->conn->real_escape_string($_POST['jk']);
                    $alamat = $connection->conn->real_escape_string($_POST['alamat']);
                    $kota = $connection->conn->real_escape_string($_POST['kota']);
                    $email = $connection->conn->real_escape_string($_POST['email']);
                  
                    $extensi = explode(".", $_FILES['foto']['name']);
                    $foto = "fotomhs-".round(microtime(true)).".".end($extensi);
                    $sumber = $_FILES['foto']['tmp_name'];

                    $upload = move_uploaded_file($sumber,"assets/image/jpg/".$foto);
                    if($upload) {
                        $dt->tambah($nim, $namamhs, $jk, $alamat, $kota, $email, $foto);
                        header("location: ?page=Data");
                    } 
                  }
                  ?>
                </div>
              </div> 
          </div>


<div id="edit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modul-title">Update Data</h4>
                    </div>
                    <form id="form" enctype="multipart/form-data">
                      <div class="modal-body" id="modal-edit">
                        <div class="form-group">
                          <label class="control-label" for="nim">NIM Mahasiswa</label>
                          <input type="hidden" name="id" id="id">
                          <input type="number" name="nim" class="form-control" id="nim" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="namamhs">Nama Mahasiswa</label>
                          <input type="text" name="namamhs" class="form-control" id="namamhs" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="jk">Jenis Kelamin</label>
                          <input type="text" name="jk" class="form-control" id="jk" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="alamat">Alamat</label>
                          <input type="text" name="alamat" class="form-control" id="alamat" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="kota">Kota</label>
                          <input type="text" name="kota" class="form-control" id="kota" required>
                        </div>
                       <div class="form-group">
                          <label class="control-label" for="email">Email</label>
                          <input type="text" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="foto">Foto</label>
                          <div style="padding-bottom:5px">
                             <img src="" width="80px" id="pict">
                          </div>
                          <input type="file" name="foto" class="form-control" id="foto">
                        </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" class="btn btn-success" name="edit" value="Save">
                      </div>
                    </form>
                </div>
              </div> 
          </div>
          <script src="assets/sb-admin/js/jquery-1.10.2.js"></script>
          <script type="text/javascript">
            $(document).on("click", "#edit_dt", function() {
              var idmhs = $(this).data('id');
              var nimmhs = $(this).data('nim');
              var nmmhs = $(this).data('nama');
              var jkmhs = $(this).data('jk');
              var alamatmhs = $(this).data('alamat');
              var kotamhs = $(this).data('kota');
              var emailmhs = $(this).data('email');
              var gambarmhs = $(this).data('gambar');
              $("#modal-edit #id").val(idmhs);
              $("#modal-edit #nim").val(nimmhs);
              $("#modal-edit #namamhs").val(nmmhs);
              $("#modal-edit #jk").val(jkmhs);
              $("#modal-edit #alamat").val(alamatmhs);
              $("#modal-edit #kota").val(kotamhs);
              $("#modal-edit #email").val(emailmhs);
              $("#modal-edit #pict").attr("src", "assets/image/jpg/"+gambarmhs);
            })

          $(document).ready(function(e) {
            $("#form").on("submit", (function(e) {
              e.preventDefault();
              $.ajax({
                url : 'model/proses_edit_data.php',
                type : 'POST',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function(msg) {
                    $('.table').html(msg);
                }
              });
            })); 
          })
          </script>

      </div>
    </div>

<?php
} else if(@$_GET['act'] == 'del') {
    echo "proses delete untuk id : ".$_GET['id'];

    $dt->hapus($_GET['id']);
    header("location: ?page=Data");
}