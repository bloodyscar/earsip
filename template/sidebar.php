<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
    aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
    <li class="dropdown nav-icon me-2">
        <a href="#" data-bs-toggle="dropdown"
        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <div class="d-lg-inline-block">
            <i data-feather="inbox"></i> Massage
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="document_masuk"><i data-feather="file"></i> Document Masuk
            <?php 
            $m=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM share_document WHERE id_to_user='$id_user'"));
            echo "$m";
            ?>
        </a>
        <a class="dropdown-item" href="document_keluar"><i data-feather="file"></i> Document Keluar
            <?php 
            $k=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM share_document WHERE id_from_user='$id_user'"));
            echo "$k";
            ?>
        </a>
    </div>
</li>
<li class="dropdown">
    <a href="#" data-bs-toggle="dropdown"
    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <div class="avatar avatar-lg me-3">
        <img src="assets/images/avatar-pegawai.jpg" style="width: 50px;" alt="" srcset="">
        <span class="avatar-status bg-success"></span>
    </div>
    <div class="d-none d-md-block d-lg-inline-block">Hi, <?= $_SESSION['username']; ?></div>
</a>
<div class="dropdown-menu dropdown-menu-end">
    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#gantipass"><i data-feather="key"></i> Ubah Password</a>
    <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
        <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" onclick="return confirm('Ingin keluar dari Aplikasi ?')" href="logout"><i data-feather="log-out"></i> Keluar</a>
    </div>
</li>
</ul>
</div>
</nav>