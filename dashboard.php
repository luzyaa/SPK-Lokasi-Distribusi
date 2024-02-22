  
  <div class="row">
      <div class="jumbotron">
       <div class="card my-4">
          <span class="mask  bg-gradient-secondary  opacity-2"></span>
        <div class="card-body">
         <h1 class="display-4">Selamat Datang di Aplikasi SPK</h1> 
          <p class="lead">"Sistem Pendukung Keputusan Pemilihan Lokasi Distribusi Terbaik "</p>
          <hr class="my-2">
          <p>Pada kasus kali ini diangkat Sistem Pendukung Keputusan permilihann lokasi distribusi terbaik usaha bundaku tektek Menggunakan Metode TOPSIS
          </p>
        </div> 
      </div>
    </div>
  
  <div class="card card-body mx-3 mx-md-4 ">
        <div class="row gx-4 mb-2">

          <div class="col-auto">
            <span class="mask  bg-gradient-secondary  opacity-2"></span>
            <div class="avatar avatar-xl position-relative">
              <img src="assets/img/i.png" class="user-image img-responsive" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <p class="mb-1">
            <?php echo"$_SESSION[nmLengkap]";?> 
            <h5 class="mb-0 font-weight-normal text-sm"><?php echo"$_SESSION[username]";?></h5>
          </p>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav" >

                <li class="nav-item">
                  <a  class="btn btn-success" class="nav-link mb-0 px-0 py-1 active "  href="?loadPage=pengguna&action=edit&id=<?php echo" $_SESSION[idPengguna]";?>">
                    <i class= "fa fa-edit fa"></i>
                    <span class="ms-1">Edit User</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-secondary" class="nav-link mb-0 px-0 py-1 "  href="?loadPage=ganti-password" role="tab" aria-selected="false">
                    <i class="fa fa-unlock-alt fa"></i>
                    <span class="ms-1">Ganti Password</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

