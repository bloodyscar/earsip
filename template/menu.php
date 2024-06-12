<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Fitrah Hanniah</title>
    <!-- Sisipkan referensi ke file CSS Anda di sini -->
    <!-- Sisipkan referensi ke file JavaScript Anda di sini -->
</head>
<body>

<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img style="width: 55%; height: auto; display: block; margin-left: auto; margin-right: auto;" src="assets/images/smk.jpg">
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class='sidebar-title'>Menu</li>
                <li class="sidebar-item active ">
                    <a href="dashboard" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php 
                // Pastikan $level sudah diatur sebelumnya
                if ($level == "Administratif") {
                ?>
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="database" width="20"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="jenis_document">Jenis Document</a>
                        </li>
                        <li>
                            <a href="pengguna">Data Pengguna</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <li class="sidebar-item">
                    <a href="document" class='sidebar-link'>
                        <i data-feather="briefcase" width="20"></i>
                        <span>Document Administrasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="document_pribadi" class='sidebar-link'>
                        <i data-feather="folder" width="20"></i>
                        <span>Document Pribadi</span>
                    </a>
                </li>
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="check" width="20"></i>
                        <span>Cek Share Document </span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="document_masuk">Document Masuk</a>
                        </li>
                        <li>
                            <a href="document_keluar">Document Keluar</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="logout" onclick="return confirm('Ingin Keluar dari Aplikasi ?')" class='sidebar-link'>
                        <i data-feather="log-out" width="20"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

</body>
</html>
