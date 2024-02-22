
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Binary Admin</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/asset/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/asset/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/asset/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- TABLE STYLES-->
    <link href="assets/asset/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">SPK Lokasi ATM</a> 
            </div>

            <div style="color: white;
            padding: 15px 50px 5px 50px;
            float: right;
            font-size: 16px;">
                <a href="logout.php" class="btn btn-danger square-btn-adjust" class="">Logout</a> 
            </div>

        </nav>   
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="assets/asset/img/find_user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a  href="?loadPage=dashboard"><i class="fa fa-home fa-2x"></i> Home</a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-table fa-2x"></i> Alternatif<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="?loadPage=alternatif">Daftar Alternatif</a>
                            </li>
                            <li>
                                <a href="?loadPage=alternatif&action=input">Tambah Alternatif</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-2x"></i> Kriteria<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="?loadPage=kriteria">Daftar Kriteria</a>
                            </li>
                            <li>
                                <a href="?loadPage=kriteria&action=input">Tambah Kriteria</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a  href="?loadPage=analisis-satu"><i class="fa fa-cogs fa-2x"></i> Analisis Topsis</a>
                    </li>

                    <li>
                        <a  href="?loadPage=pengguna"><i class="fa fa-users fa-2x"></i> Data Pengguna</a>
                    </li>              
                </ul>
               
            </div>
            
        </nav>  

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                      <!-- Advanced Tables -->
          <div class="panel panel-default">
              <div class="panel-heading">
                    Advanced Tables
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                          <thead>
                              <tr>
                                  <th>Rendering engine</th>
                                  <th>Browser</th>
                                  <th>Platform(s)</th>
                                  <th>Engine version</th>
                                  <th>CSS grade</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="odd gradeX">
                                  <td>Trident</td>
                                  <td>Internet Explorer 4.0</td>
                                  <td>Win 95+</td>
                                  <td class="center">4</td>
                                  <td class="center">X</td>
                              </tr>
                              <tr class="even gradeC">
                                  <td>Trident</td>
                                  <td>Internet Explorer 5.0</td>
                                  <td>Win 95+</td>
                                  <td class="center">5</td>
                                  <td class="center">C</td>
                              </tr>
                              <tr class="odd gradeA">
                                  <td>Trident</td>
                                  <td>Internet Explorer 5.5</td>
                                  <td>Win 95+</td>
                                  <td class="center">5.5</td>
                                  <td class="center">A</td>
                              </tr>
                              <tr class="even gradeA">
                                  <td>Trident</td>
                                  <td>Internet Explorer 6</td>
                                  <td>Win 98+</td>
                                  <td class="center">6</td>
                                  <td class="center">A</td>
                              </tr>
                              <tr class="odd gradeA">
                                  <td>Trident</td>
                                  <td>Internet Explorer 7</td>
                                  <td>Win XP SP2+</td>
                                  <td class="center">7</td>
                                  <td class="center">A</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <!--End Advanced Tables -->  
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
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/asset/js/custom.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="assets/asset/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/asset/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
    
</body>
</html>