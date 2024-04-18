<?php
// koneksi database
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "mahasiswa_db";

// buat koneksi
    $koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));

// kode otomatis(belum)

// jika tombol simpan diklik
if(isset($_POST['bsimpan'])){


    // pengujian apakah data akan diedit / disimpan baru
    if(isset($_GET['hal']) == "edit"){
        $edit = mysqli_real_query($koneksi, "UPDATE maba SET
                                                    nim = '$_POST[tnim]',
                                                    nama = '$_POST[tnama]',
                                                    tmp_lahir = '$_POST[ttmplahir]',
                                                    tgl_lahir = '$_POST[ttgllahir]',
                                                    prodi = '$_POST[tprodi]',
                                                    alamat = '$_POST[talamat]',
                                                    email = '$_POST[temail]',
                                                    no_hp = '$_POST[tnohp]'
                                            WHERE id_mhs = '$_GET[id]'
                                            ");
        
            // test if edit saved successfully
        if($edit){
            echo "<script>
                    alert('edit data sukses!'); 
                    document.location='index.php';
                </script>";
        }else{
            echo "<script>
                    alert('edit data GAGAL!'); 
                    document.location='index.php';
                </script>";
        }
    
    }else{
        // data akan disimpan baru
                $simpan = mysqli_query($koneksi, " INSERT INTO maba (nim, nama, tmp_lahir, tgl_lahir, prodi, alamat, email, no_hp)
                                                    VALUE ( '$_POST[tnim]',
                                                            '$_POST[tnama]',
                                                            '$_POST[ttmplahir]',
                                                            '$_POST[ttgllahir]',
                                                            '$_POST[tprodi]',
                                                            '$_POST[talamat]',
                                                            '$_POST[temail]',
                                                            '$_POST[tnohp]' )
                                                ");

            // test if data saved successfully
            if($simpan){
            echo "<script>
                    alert('simpan data sukses!'); 
                    document.location='index.php';
                 </script>";
            }else{
            echo "<script>
                    alert('simpan data GAGAL!'); 
                    document.location='index.php';
                 </script>";
            }
    }
    
}

// deklarasi variabel untuk menampung data yang akan diedit
$vnim = "";
$vnama = "";
$vtmp_lahir = "";
$vtgl_lahir = "";
$vprodi = "";
$valamat = "";
$vemail = "";
$vno_hp = "";


// pengujian jika tombool edit atau hapus diklik
if(isset($_GET['hal'])){
    // pengujian jika edit data
    if($_GET['hal'] == "edit"){
        // tampilkan data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT *FROM maba WHERE id_mhs = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data){
            // jika data ditemukan, maka data ditampung dalam variabel
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $vtmp_lahir = $data['tmp_lahir'];
            $vtgl_lahir = $data['tgl_lahir'];
            $vprodi = $data['prodi'];
            $valamat = $data['alamat'];
            $vemail = $data['email'];
            $vno_hp = $data['no_hp'];
        }
    }else if($_GET['hal'] == "hapus") {
        // persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM maba WHERE id_mhs = '$_GET[id]' ");
        // test if data deleted successfully
        if($hapus){
            echo "<script>
                    alert('hapus data sukses!'); 
                    document.location='index.php';
                 </script>";
            }else{
            echo "<script>
                    alert('hapus data GAGAL!'); 
                    document.location='index.php';
                 </script>";
            }
    }
}

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>



<div class="container">
    <h3 class="text-center">Data mahasiswa baru</h3>
    <h3 class="text-center">Maba</h3>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    Form input data mahasiswa
                </div>
                <div class="card-body">
                    <!-- form begin -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nim</label>
                            <input type="text" name="tnim" required value="<?= $vnim ?>" class="form-control" placeholder="input nim">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" name="tnama" required value="<?= $vnama ?>" class="form-control" placeholder="input nama">
                        </div>
                    <!-- BEGIN column tempat dan tanggal lahir -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Tempat lahir</label>
                                    <input type="text" name="ttmplahir" required value="<?= $vtmp_lahir ?>" class="form-control" placeholder="input tempat lahir">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal lahir</label>
                                    <input type="date" name="ttgllahir" required value="<?= $vtgl_lahir ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    <!-- END column tempat dan tanggal lahir -->
                        <div class="mb-3">
                            <label class="form-label">Prodi</label>
                            <select class="form-select" name="tprodi" required>
                                <option value="<?= $vprodi ?>"required><?= $vprodi ?></option>
                                <option value="MPI">MPI</option>
                                <option value="HKI">HKI</option>
                                <option value="PIAUD">PIAUD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="talamat" required id="exampleFormControlTextarea1" rows="3" placeholder="masukan alamat"><?= $valamat ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="temail" required value="<?= $vemail ?>" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No hp</label>
                            <input type="number" name="tnohp" required value="<?= $vno_hp ?>" class="form-control" placeholder="input no hp Ex 62">
                        </div>

                        <div class="text-center">
                            <hr>
                            <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                            <button class="btn btn-danger" name="bkosongkan" type="reset">Kosongkan</button>
                        </div>
                    </form>
                    <!-- form end -->
                </div>
                <div class="card-footer bg-dark">

                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN SHOW DATAS -->
        <div class="card mt-5">
            <div class="card-header bg-dark text-light">
                Data mahasiswa
            </div>
            <div class="card-body"> 
                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" value="<?= @$_POST['tcari'] ?>" class="form-control" 
                            placeholder="masukan kata kunci">
                            <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>

                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Nim</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Prodi</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Aksi</th>
                    </tr>

                    <?php
                    // persiapan menampilkan data
                    $no = 1;

                    // untuk pencarian data
                    // jika tombil cari diklik
                    if(isset($_POST['bcari'])){
                        // tampilkan data yang dicari
                        $keyword = $_POST['tcari'];
                        $q = "SELECT * FROM maba WHERE nim like '%$keyword%' or nama like '%$keyword%' or prodi like '%$keyword%' order by 
                        id_mhs desc ";
                    }else{
                        $q = "SELECT * FROM maba order by id_mhs desc";
                    }

                    $tampil = mysqli_query($koneksi, $q);
                    while($data = mysqli_fetch_array($tampil)) :
                    ?>


                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['nim'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['tmp_lahir'] ?></td>
                        <td><?= $data['tgl_lahir'] ?></td>
                        <td><?= $data['prodi']?></td>
                        <td><?= $data['alamat']?></td>
                        <td><?= $data['email']?></td>
                        <td><?= $data['no_hp']?></td>
                        <td>
                            <a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" 
                            class="btn btn-danger" onclick="return confirm('Apakah anda ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <div class="card-footer bg-dark">

            </div>
        </div>
    <!-- BEGIN SHOW DATAS -->


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
crossorigin="anonymous"></script>

</body>
</html>