  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php?halaman=dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <!-- BAGIAN ADMIN -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Data Admin
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahadmin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah Admin</p>
                </a>
              </li>              
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=jabatan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahjabatan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah jabatan</p>
                </a>
              </li>              
            </ul>
          </li>

          <!-- BAGIAN PEMINJAM -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data peminjam
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=peminjam" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index peminjam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahpeminjam" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah peminjam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=asal" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index asal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahasal" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah asal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=peminjambermasalah" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>peminjam Bermasalah</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- BAGIAN peminjaman -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Data peminjaman
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=peminjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index peminjaman</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="index.php?halaman=peminjamanbermasalah" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>peminjaman Bermasalah</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=kategori" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index kategori</p>
                </a>
              </li>                           
            </ul>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=merk" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index merk</p>
                </a>
              </li>                           
            </ul>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=posisi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index posisi</p>
                </a>
              </li>                           
            </ul>

          </li>
          
          <!-- BAGIAN peminjaman -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Data peminjaman
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=daftarpeminjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>daftar peminjaman</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="index.php?halaman=tambahpeminjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>tambah peminjaman</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=daftarpengembalian" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>daftar pengembalian</p>
                </a>
              </li>                           
            </ul>
            

          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>