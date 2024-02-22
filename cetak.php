<?php
  include"appConfig/conn.php";
  include"appConfig/region.php";
  include"appConfig/timeZone.php";
  include"appConfig/libb.php";
?>
<body>

        <!-- /. NAV SIDE  -->
        <br>
        <br>
        <br>  
    <div class="col-md-12 pt-5">   
    <h1 class="text-center">Penilaian Lokasi Distribusi Terbaik dengan Metode TOPSIS</h1>
      <h2>"USAHA BUNDAKU TEKTEK"</h2>
    </div>
          
    </br>
    <p3 class="text-center">Berikut merupakan hasil perankingan beberapa lokasi yang akan dijadikan lokasi distribusi usaha Bundaku Tektek. Lokasi tersebut telah diurutkan berdasarkan lokasi yang paling ideal hingga yang kurang ideal untuk menjual produk dari usaha Bundaku Tektek.</p3>
    </br>    
    </br>
          <div class="row">
          <div class="col-md-12">
            <?php
            function tampiltabel($arr){
              echo '<table class="table table-bordered table-highlight">';
              for ($i=0;$i<count($arr);$i++){
                echo '<tr>';
                for ($j=0;$j<count($arr[$i]);$j++){
                  echo '<td>'.number_format($arr[$i][$j], 2, '.', '').'</td>';
                }
                  echo '</tr>';
              }
              echo '</table>';
            }

            function tampilbaris($arr){
              echo '<table class="table  table-bordered table-highlight">';
              echo '<tr>';
              for ($i=0;$i<count($arr);$i++){
                echo '<td>'.number_format($arr[$i], 2, '.', '').'</td>';
              }
              echo "</tr>";
              echo '</table>';
            }

            function tampilkolom($arr){
              echo '<table class="table table-bordered table-highlight">';
              for ($i=0;$i<count($arr);$i++){
                echo '<tr>';
                echo '<td>'.number_format($arr[$i], 3, '.', '').'</td>';
                echo "</tr>";
              }
              echo '</table>';
            }
            
            $alternatif = array(); 
            $queryalternatif = mysqli_query($conn,"SELECT * FROM talternatif ORDER BY id_alternatif");
            $i=0;
              while ($dataalternatif = mysqli_fetch_array($queryalternatif)){
              $alternatif[$i] = $dataalternatif['nama_alternatif'];
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
                  $hasilrangking[$i] = $hasilrangking[$j];
                  $alternatifrangking[$i] = $alternatifrangking[$j];
                  $hasilrangking[$j] = $tmphasil;
                  $alternatifrangking[$j] = $tmpalternatif;
                  }
                }
                }
            ?>


          <div class="col-md-12 ">
          <table class="table table-bordered table-hover table-striped text-center" border="1">
          <thead>
            <tr>
              <th align="center">Ranking</th>
              <th align="center">Alternatif</th>
              <th align="center">Nilai Preferensi</th>
            </tr>
          </thead>
            <?php
            for ($i=0;$i<count($hasilrangking);$i++){ 
            ?>
            <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $alternatifrangking[$i]; ?></td>
            <td><?php echo number_format($hasilrangking[$i], 4, '.', ''); ?></td>
            </tr>

            <?php
            }
            ?>
          </tbody>
          </table>
        </div>
          <br />
          <br />
            Rekomendasi Hasil Rencana Lokasi distribusi terbaik untuk usaha Bundaku Tektek: 
            <h4 class="heading">
              <span class="label label-primary" style="border-radius: 0px"> <?php echo $alternatifrangking[0]; ?> </span>
            </h4> 
            <br>
            Dengan Nilai Terbesar :

            <h4 class="heading">
              <span class="label label-success" style="border-radius: 0px"> 
              <?php echo $hasilrangking[0]; ?></span>
            </h4>
          <br />
          <br />
         
          </div> <!-- /.col -->
          </div> <!-- /.row -->

          </div>
        <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/asset/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/asset/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/asset/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="assets/asset/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/asset/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/asset/js/custom.js"></script>
  <script>window.print()</script>
    
  </br>
  </br>
  
</body>
</html>
</html>
