<?php
include "koneksi.php";
?>

<!-- Default box -->
<div class="card card-solid">
  <div class="col">
      <a href="index.php?halaman=tambahadmin" class="btn btn-primary float-right btn-sm mt-3">
          <i class="fas fa-user-plus"></i> Tambah Admin
      </a>
  </div>
  <div class="card-body pb-0">
      <div class="row">

          <?php
          $query = mysqli_query($koneksi, "
              SELECT admin.*, jabatan.namajabatan 
              FROM admin 
              LEFT JOIN jabatan ON admin.idjabatan = jabatan.idjabatan
              ORDER BY admin.idadmin DESC
          ");
          while ($data = mysqli_fetch_assoc($query)) {
              $foto = !empty($data['foto']) ? "foto/" . $data['foto'] : "dist/img/default-user.png";
          ?>
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                  <div class="card bg-light d-flex flex-fill">
                      <div class="card-header text-muted border-bottom-0">
                          <?= htmlspecialchars($data['namajabatan']) ?>
                      </div>
                      <div class="card-body pt-0">
                          <div class="row">
                              <div class="col-7">
                                  <h2 class="lead"><b><?= htmlspecialchars($data['namaadmin']) ?></b></h2>
                                  <p class="text-muted text-sm">
                                      <b>Username:</b> <?= htmlspecialchars($data['username']) ?>
                                  </p>
                                  <ul class="ml-4 mb-0 fa-ul text-muted">
                                      <li class="small">
                                          <span class="fa-li"><i class="fas fa-id-card"></i></span> ID: <?= $data['idadmin'] ?>
                                      </li>
                                  </ul>
                              </div>
                              <div class="col-5 text-center">
                                  <img src="<?= $foto ?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;object-fit:cover;">
                              </div>
                          </div>
                      </div>
                      <div class="card-footer">
                          <div class="text-right">
                              <a href="index.php?halaman=editadmin&idadmin=<?= $data['idadmin'] ?>" class="btn btn-sm btn-warning">
                                  <i class="fas fa-edit"></i> Edit
                              </a>
                              <a href="proses/dbadmin.php?proses=hapus&idadmin=<?= $data['idadmin'] ?>" 
                                 class="btn btn-sm btn-danger"
                                 onclick="return confirm('Yakin ingin menghapus data ini?')">
                                  <i class="fas fa-trash"></i> Hapus
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>

      </div>
  </div>

  <!-- /.card-footer -->
  <div class="card-footer">
      <nav aria-label="Contacts Page Navigation">
          <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
          </ul>
      </nav>
  </div>
</div>
<!-- /.card -->
