<?php
include"appConfig/conn.php";	
// menyimpan data kedalam variabel
$tanggal = date("Y-m-d H:i:s");
$id= mysqli_query($conn, "SELECT * FROM thasil where tanggal_created in (select max(tanggal_created) from thasil)");
$id_hasil= mysqli_insert_id($conn);
// update nilai ranking
$nama = mysqli_query($conn, "SELECT max(keterangan) as kodeTerbesar FROM trekap");
$data = mysqli_fetch_array($nama);
$namapr = $data['kodeTerbesar'];
$urutan = (int) substr($namapr, 5, 1);
$urutan++;
$huruf = "rekap";
$namapr= $huruf.sprintf("%1s", $urutan);

// query SQL untuk insert data

$proses = mysqli_query($conn,"INSERT INTO trekap (id_hasil,tanggal,keterangan)VALUES('$id_hasil','$tanggal','$namapr')");
if($proses) {
 echo "Data berhasil disimpan";
} else {
 echo "Data gagal disimpan";
}
// mengalihkan ke halaman index.php
// header("location:?loadPage=rekap");
?>