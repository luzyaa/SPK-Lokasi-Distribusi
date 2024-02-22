
<div class="content-header">
  <h3 class="content-header-title">Hasil TOPSIS </h3>
    
</div> <!-- /.content-header -->
  
<div class="row">
  <div class="col-md-12">
    <?php
	  function tampiltabel($arr){
		echo '<table class="table table-bordered table-highlight">';
		  for ($i=0;$i<count($arr);$i++){
		  	echo '<tr>';
			  for ($j=0;$j<count($arr[$i]);$j++){
			    echo '<td>'.$arr[$i][$j].'</td>';
			  }
		  		echo '</tr>';
		  }
		  echo '</table>';
	  }

	  function tampilbaris($arr){
		echo '<table class="table  table-bordered table-highlight">';
		echo '<tr>';
		  for ($i=0;$i<count($arr);$i++){
			echo '<td>'.$arr[$i].'</td>';
		  }
		  echo "</tr>";
		  echo '</table>';
	  }

	  function tampilkolom($arr){
		echo '<table class="table table-bordered table-highlight">';
	      for ($i=0;$i<count($arr);$i++){
			echo '<tr>';
			echo '<td>'.$arr[$i].'</td>';
			echo "</tr>";
	      }
		  echo '</table>';
	  }
	
	  $alternatif = array(); 
	  $id_alternatif = array();
	  $queryalternatif = mysqli_query($conn,"SELECT * FROM talternatif ORDER BY id_alternatif");
	  $i=0;
	    while ($dataalternatif = mysqli_fetch_array($queryalternatif)){
		  $alternatif[$i] = $dataalternatif['nama_alternatif'];
		  $id_alternatif[$i] = $dataalternatif['id_alternatif'];
		  $i++;
	    }
	
		$kriteria = array(); 
		$atribut = array(); 
		$bobot_kepentingan = array(); 

		$querykriteria = mysqli_query($conn,"SELECT * FROM tkriteria ORDER BY id_kriteria");
		$i=0;
		  while ($datakriteria = mysqli_fetch_array($querykriteria)){
			$kriteria[$i] = $datakriteria['nama_kriteria'];
			$atribut[$i] = $datakriteria['atribut'];
			$bobot_kepentingan[$i] = $datakriteria['bobot_kepentingan'];
			$i++;
		  }
		  $alternatifkriteria = array();
		
	
		  $queryalternatif = mysqli_query($conn,"SELECT * FROM talternatif ORDER BY id_alternatif");
		  $i=0;
			while ($dataalternatif = mysqli_fetch_array($queryalternatif)){
			  $querykriteria = mysqli_query($conn,"SELECT * FROM tkriteria ORDER BY id_kriteria");
			  $j=0;
				while ($datakriteria = mysqli_fetch_array($querykriteria)){
				  $queryalternatifkriteria = mysqli_query($conn,"SELECT * FROM talternatif_kriteria WHERE id_alternatif = '$dataalternatif[id_alternatif]' AND id_kriteria = '$datakriteria[id_kriteria]'");


				  $dataalternatifkriteria = mysqli_fetch_array($queryalternatifkriteria);
			      $alternatifkriteria[$i][$j] = $dataalternatifkriteria['nilai'];
			      $j++;
				}
				$i++;
			}
			
			$pembagi = array();
			for ($i=0;$i<count($kriteria);$i++){
			  $pembagi[$i] = 0;
			  for ($j=0;$j<count($alternatif);$j++){
				$pembagi[$i] = $pembagi[$i] + ($alternatifkriteria[$j][$i] * $alternatifkriteria[$j][$i]);
			  }
			  $pembagi[$i] = sqrt($pembagi[$i]);
			}
			//matriks keputusan yang ternormalisasi
			$normalisasi = array();
			for ($i=0;$i<count($alternatif);$i++){
			  for ($j=0;$j<count($kriteria);$j++){
				$normalisasi[$i][$j] = $alternatifkriteria[$i][$j] / $pembagi[$j];
			  }
			}
			//matriks keputusan yang terbobot
			$terbobot = array();
			for ($i=0;$i<count($alternatif);$i++){
			  for ($j=0;$j<count($kriteria);$j++){
				$terbobot[$i][$j] = $normalisasi[$i][$j] * $bobot_kepentingan[$j];
			  }
			}	
			//matriks solusi ideal positif
			$aplus = array();
			for ($i=0;$i<count($kriteria);$i++){
			  if ($atribut[$i] == 'Cost'){
				for ($j=0;$j<count($alternatif);$j++){
				  if ($j == 0){ 
					$aplus[$i] = $terbobot[$j][$i];
				  }
				  else{
					if ($aplus[$i] > $terbobot[$j][$i]){
					  $aplus[$i] = $terbobot[$j][$i];
					}
				  }
				}
			  }
			  else{
				for ($j=0;$j<count($alternatif);$j++){
				  if ($j == 0){ 
					$aplus[$i] = $terbobot[$j][$i];
				  }
				  else{
					if ($aplus[$i] < $terbobot[$j][$i]){
					  $aplus[$i] = $terbobot[$j][$i];
					}
				  }
			    }
			  }
			}
			//matriks solusi ideal negatif
			$amin = array();
			for ($i=0;$i<count($kriteria);$i++){
			  if ($atribut[$i] == 'Cost'){
				for ($j=0;$j<count($alternatif);$j++){
				  if ($j == 0){ 
					$amin[$i] = $terbobot[$j][$i];
				  }
				  else{
					if ($amin[$i] < $terbobot[$j][$i]){
						$amin[$i] = $terbobot[$j][$i];
					}
				  }
				}
			  }
			  else{
				for ($j=0;$j<count($alternatif);$j++){
				  if ($j == 0){ 
					$amin[$i] = $terbobot[$j][$i];
				  }
				  else{
					if ($amin[$i] > $terbobot[$j][$i]){
						$amin[$i] = $terbobot[$j][$i];
					}
				  }
				}
			  }
			}
			//jarak nilai dengan matriks solusi ideal positif
			$dplus = array();
			for ($i=0;$i<count($alternatif);$i++){
			  $dplus[$i] = 0;
			  for ($j=0;$j<count($kriteria);$j++){
				$dplus[$i] = $dplus[$i] + (($aplus[$j] - $terbobot[$i][$j]) * ($aplus[$j] - $terbobot[$i][$j]));
			  }
			  $dplus[$i] = sqrt($dplus[$i]);
			}
			//jarak nilai dengan matriks solusi ideal negatif
			$dmin = array();
			for ($i=0;$i<count($alternatif);$i++){
			  $dmin[$i] = 0;
			  for ($j=0;$j<count($kriteria);$j++){
				$dmin[$i] = $dmin[$i] + (($terbobot[$i][$j] - $amin[$j]) * ($terbobot[$i][$j] - $amin[$j]));
			  }
			  $dmin[$i] = sqrt($dmin[$i]);
			}
	
			//nilai preferensi
			$hasil = array();
			for ($i=0;$i<count($alternatif);$i++){
			  $hasil[$i] = $dmin[$i] / ($dmin[$i] + $dplus[$i]);
			}	
	
			$alternatifrangking = array();
			$hasilrangking = array();
	
			for ($i=0;$i<count($alternatif);$i++){
			  $hasilrangking[$i] = $hasil[$i];
			  $alternatifrangking[$i] = $alternatif[$i];
			}
	
			for ($i=0;$i<count($alternatif);$i++){
			  for ($j=$i;$j<count($alternatif);$j++){
				if ($hasilrangking[$j] > $hasilrangking[$i]){
				  $tmphasil = $hasilrangking[$i];
				  $tmpalternatif = $alternatifrangking[$i];
				  $tmpidalternatif = $id_alternatif[$i];
				  $hasilrangking[$i] = $hasilrangking[$j];
				  $alternatifrangking[$i] = $alternatifrangking[$j];
				  $id_alternatif[$i] = $id_alternatif[$j];
				  $hasilrangking[$j] = $tmphasil;
				  $alternatifrangking[$j] = $tmpalternatif; 
				  $id_alternatif[$j] = $tmpidalternatif;
				}
			  }
			}
	?>

	<div id="perhitungan" style="display:none;">

  	  <h4 class="heading">Alternatif :</h4>
  	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
			<?php 
				tampilbaris($alternatif); 
			?>
	</table>
	</div>
</div>
</div>
	  
      <br />

	  	<h4 class="heading">Kriteria :</h4>
	  	<div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">	<?php 
				tampilbaris($kriteria); 
			?>
		</table>
		</div>
		</div>
		</div>
	  <br />

	  <h4 class="heading">Atribut:</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampilbaris($atribut); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />

	  <h4 class="heading">Bobot Kepentingan :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampilbaris($bobot_kepentingan); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />

	  <h4 class="heading">Konferensi Nilai Bobot :</h4>
	  <div class="row">

  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
	  <?php 
	    tampiltabel($alternatifkriteria); 
	  ?>
	</table>
</div>
</div>
</div>/
	  <br />

	  <h4 class="heading">Pembagi :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampilbaris($pembagi); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />
	
	  <h4 class="heading">Normalisasi:</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampiltabel($normalisasi); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />

	  <h4 class="heading">Normalisasi Terbobot:</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
		<?php 
			tampiltabel($terbobot); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />
	  
	  <h4 class="heading">Solusi Ideal Positif (A+) :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampilbaris($aplus); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />

	  <h4 class="heading">Solusi Ideal Negatif (A-) :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
		<?php 
			tampilbaris($amin); 
		?>
	</table>
</div>
</div>
	  </div>
	  <br />

	  <h4 class="heading">Jarak Ideal Positif (D+):</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
	  <?php 
	    tampilkolom($dplus); 
	  ?>
	</table>
</div>
</div>
</div>
	  <br />

	  <h4 class="heading">Jarak Ideal Negatif (D-):</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
	  <?php 
	    tampilkolom($dmin); 
	  ?>
	</table>
</div>
</div>
</div>
	  <br />

	  <h4 class="heading">Nilai Preferensi :</h4>
	  <<div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
	  <?php 
	    tampilkolom($hasil); 
	  ?>
	</table>
</div>
</div>
</div>
	  <br />

	  <h4 class="heading">Hasil Ranking :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
          		<?php 
	    tampilkolom($hasilrangking); 
	  ?>
	</table>
</div>
</div>
</div>
	  <br />

	  <h4 class="heading">Alternatif Ranking :</h4>
	  <div class="row">
  <div class="col-md-12">
          <div class="card  ">
          	<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
	  <?php 
	    tampilkolom($alternatifrangking); 
	  ?>
	</table>
</div>
</div>
</div>
	  <br />

	  Rekomendasi Hasil Rencana Lokasi Yang Paling Tepat Untuk distribusi :<h4 class="heading"><span class="label label-default" style="border-radius: 0px"> <?php echo $alternatifrangking[0]; ?></span></h4> 
	  Dengan Nilai Terbesar :<h4 class="heading"><span class="label label-default" style="border-radius: 0px"> <?php echo $hasilrangking[0]; ?></span></h4>
	  <br />
	</div>
	<input type="button" class="btn btn-primary pull-right" value="Lihat Analisis" onclick="document.getElementById('perhitungan').style.display='block';"/>
	<a href="cetak.php" class="btn btn-success pull-right" target="_blank" style="margin-left:10px;">Cetak</a>
	
<br />
<?php
if (isset($_POST["simpan"])){
$s=1;

$tanggal = date("Y-m-d H:i:s");
// update nilai ranking
$nama = mysqli_query($conn, "SELECT max(keterangan) as kodeTerbesar FROM trekap");
$data = mysqli_fetch_array($nama);
$namapr = $data['kodeTerbesar'];
$urutan = (int) substr($namapr, 5, 1);
$urutan++;
$huruf = "rekap";
$namapr= $huruf.sprintf("%1s", $urutan);
for ($i=0;$i<count($alternatif);$i++){
    
   $insert = mysqli_query($conn,"INSERT INTO thasil (tanggal_created,id_alternatif,alternatif,nilai_preferensi,ranking)VALUES('$tanggal','$id_alternatif[$i]','$alternatifrangking[$i]','$hasilrangking[$i]','$s') ON DUPLICATE KEY UPDATE tanggal_created='$tanggal', nilai_preferensi='$hasilrangking[$i]', ranking='$s'");
    $id_hasil= mysqli_insert_id($conn);
    $proses = mysqli_query($conn,"INSERT INTO trekap (id_hasil,tanggal,keterangan)VALUES('$id_hasil','$tanggal','$namapr')");
    // var_dump($proses);
$s++;
  }
}
?>
<div class="row  mb-0">
        <div class="col">
          <div class="card ">
                  <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
  <thead>
    <tr>
    	<th>Ranking</th>
    	<th>Alternatif</th>
    	<th>Nilai Preferensi</th>
    </tr>
  </thead>
  <tbody>
    <?php
	  for ($i=0;$i<count($hasilrangking);$i++){	
    ?>
    <tr>
      <td><?php echo ($i+1);?></td>
      <td><?php echo $alternatifrangking[$i]; ?></td>
      <td><?php echo $hasilrangking[$i]; ?></td>
    </tr>

	<?php
	}
	?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
<br />
<br />
	Rekomendasi Hasil Rencana Lokasi Yang Paling Tepat Untuk distribusi :<h4 class="heading"><span class="label label-default" style="border-radius: 0px"> <?php echo $alternatifrangking[0]; ?> </span></h4> 
		 (Jadi <?php echo $alternatifrangking[0]; ?> adalah alternatif dengan hasil tertinggi yang memiliki kedekatan dengan kriteria benefit(untung) dan menjauhkan dari kriteria cost (rugi))
			<br>
	Dengan Nilai Terbesar :<h4 class="heading"><span class="label label-default" style="border-radius: 0px"> <?php echo $hasilrangking[0]; ?></span></h4>
  <br />
  <form method="post" action="">
  <button type='submit' class='btn btn-success btn-sm' value='simpan' name="simpan">Simpan ke rekap</button></a>
  </form>
  <br/>
  <br />
  </div> <!-- /.col -->
</div> <!-- /.row -->
 