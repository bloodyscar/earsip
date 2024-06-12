<?php
session_start();
include "../koneksi/koneksi.php";
if (!isset($_SESSION["login"])) {
    header("location: login");
}
$level = $_SESSION['level'];
$id_user = $_SESSION['id_user'];

// Memodifikasi fungsi fsize untuk menangani kesalahan
function fsize($file)
{
    // Menggunakan fungsi file_exists() untuk memeriksa apakah file ada
    if (file_exists($file)) {
        $a = array("B", "KB", "MB", "GB", "TB", "PB");
        $pos = 0;
        $size = filesize($file);
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, 2) . " " . $a[$pos];
    } else {
        return "File tidak ditemukan";
    }
}

if (isset($_GET['aksi']) == 'hapus') {
    $id_document = mysqli_real_escape_string($koneksi, $_GET['id_document']);
    $a = mysqli_query($koneksi, "SELECT * FROM document INNER JOIN jenis_document ON document.id_jenis_document=jenis_document.id_jenis_document WHERE id_document='$id_document'");
    $b = mysqli_fetch_assoc($a);
    $jenis_document = $b['jenis_document'];
    $nama_document = $b['nama_document'];
    $file = $b['file'];
    unlink("file/$jenis_document/$file");
    $hapus = mysqli_query($koneksi, "DELETE FROM document WHERE id_document='$id_document'");
    echo "<script>window.alert('File document $nama_document berhasil dihapus !!!')
    window.location='document'</script>";
}
if (isset($_POST['update'])) {
    $id_document = mysqli_real_escape_string($koneksi, $_POST['id_document']);
    $nama_document = mysqli_real_escape_string($koneksi, $_POST['nama_document']);
    $update = mysqli_query($koneksi, "UPDATE document SET nama_document='$nama_document' WHERE id_document='$id_document'");
    echo "<script>window.alert('File document berhasil diupdate !!!')
    window.location='document'</script>";
}
if (isset($_POST['upload'])) {
    $id_jenis_document = mysqli_real_escape_string($koneksi, $_POST['id_jenis_document']);
    $asd = mysqli_query($koneksi, "SELECT * FROM jenis_document WHERE id_jenis_document='$id_jenis_document'");
    $tampil = mysqli_fetch_assoc($asd);
    $jenis_document = $tampil['jenis_document'];
    $nama_document = mysqli_real_escape_string($koneksi, $_POST['nama_document']);
    $tgl_upload = date('Y-m-d');
    $folder = $jenis_document;
    if (is_dir("file/$folder")) {
    } else {
        mkdir("file/$folder");
    }
    $ekstensi_diperbolehkan = array('PDF', 'pdf', 'png', 'jpg', 'JPG', 'PNG', 'jpeg', 'JPEG', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx');
    $file = $_FILES['file']['name'];
    $x = explode('.', $file);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran <= 10000000) {
            $x_file = $file;
            move_uploaded_file($file_tmp, 'file/' . $folder . '/' . $file);
            $input = mysqli_query($koneksi, "INSERT INTO document VALUES(NULL,'$id_jenis_document','$nama_document','$x_file','$tgl_upload')");
            echo "<script>window.alert('Document $nama_document berhasil diupload')
            window.location='document'</script>";
        } else {
            echo "<script>window.alert('Ukuran file melebihi batas !!!')
            window.location='document'</script>";
        }
    } else {
        echo "<script>window.alert('Ekstensi File tidak di izinkan !!!')
        window.location='document'</script>";
    }
}
if (isset($_POST['gantipass'])) {
    $Password_lama = md5($_POST['Password_lama']);
    $Password_baru = md5($_POST['Password_baru']);
    $cek_pass = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user' AND password='$Password_lama'"));
    if ($cek_pass > 0) {
        $update = mysqli_query($koneksi, "UPDATE user SET password='$Password_baru' WHERE id_user='$id_user'");
        echo "<script>window.alert('Password Anda Berhasil diganti !!!')
        window.location='document'</script>";
    } else {
        echo "<script>window.alert('Ganti Password gagal !!!')
        window.location='document'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Fitrah Hanniah</title>
    <link rel="stylesheet" href="assets/vendors/DataTables/datatables.css">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/css/mystyle.css">

    <!-- <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css"> -->


    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/logo-arsip.jpg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <!-- menu -->
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img style="width: 55%; height: auto; display: block; margin-left: auto; margin-right: auto;"
                        src="assets/images/smk.jpg">
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class='sidebar-title'>Menu</li>
                        <li class="sidebar-item">
                            <a href="dashboard" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php
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
                        <li class="sidebar-item active">
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
                                <span>Cek Share Document</span>
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
                            <a href="logout" onclick="return confirm('Ingin Keluar dari Aplikasi ?')"
                                class='sidebar-link'>
                                <i data-feather="log-out" width="20"></i>
                                <span>Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <!-- menu -->
        <div id="main">
            <?php
            require_once "../template/sidebar.php";
            ?>

            <div class="main-content container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h4>Document</h4>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Document</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <?php if ($level == 'Administratif') :  ?>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <a href="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#primary"><i
                                    data-feather="file-plus"></i> Document baru</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <form action="" method="post">
                                <table>
                                    <tr>
                                        <td>
                                            <select class="form-select" name="id_jenis_document" required="required">
                                                <option value="">--Jenis Document--</option>
                                                <?php
                                                $filter = mysqli_query($koneksi, "SELECT * FROM jenis_document ORDER BY jenis_document ASC");
                                                while ($row_filter = mysqli_fetch_assoc($filter)) {
                                                ?>
                                                <option value="<?= $row_filter['id_jenis_document']; ?>">
                                                    <?= $row_filter['jenis_document']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-info" name="filter"><i
                                                    data-feather="filter"></i> Filter</button>
                                        </td>
                                        <td>
                                            <a href="document" class="btn btn-info">Refresh</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="box-input">
                                <input type="text" id="searchInput" placeholder="cari nama dokumen..">
                                <br>
                                <p id="step"></p>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table style="color: black; font-size: 9.6pt;" class='table table-datatable'
                                    id="myTable">
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th width="50px">Kode</th> <!-- Perbaikan sintaks pada baris ini -->
                                            <th>Jenis Document</th>
                                            <th>Nama Document</th>
                                            <th>Tgl Upload</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $no = 1;
                                    if (isset($_POST['filter'])) {
                                        $id_jenis_document = $_POST['id_jenis_document'];
                                        $Document = mysqli_query($koneksi, "SELECT * FROM document INNER JOIN jenis_document ON document.id_jenis_document=jenis_document.id_jenis_document WHERE document.id_jenis_document='$id_jenis_document' ORDER BY document.nama_document");
                                    } else {
                                        $Document = mysqli_query($koneksi, "SELECT * FROM document INNER JOIN jenis_document ON document.id_jenis_document=jenis_document.id_jenis_document ORDER BY document.nama_document");
                                    }
                                    while ($row_Document = mysqli_fetch_array($Document)) {
                                        $rfile = $row_Document['file'];
                                        $jenis_document = $row_Document['jenis_document'];
                                        $file = "file/$jenis_document/$rfile";
                                        $nama_document = $row_Document['nama_document'];
                                    ?>
                                        <tr style="color: black;">
                                            <td><?php echo $no++; ?></td>
                                            <td><?= ($row_Document['id_document'] > 1000) ? 'DOC-' . $row_Document['id_document'] : 'DOC-00' . $row_Document['id_document']  ?>
                                            </td>
                                            <td><?= $row_Document['jenis_document']; ?></td>
                                            <td><?= $row_Document['nama_document']; ?></td>
                                            <td><?= $row_Document['tgl_upload']; ?></td>
                                            <td>
                                                <?php
                                                $x = explode('.', $rfile);
                                                $type = strtolower(end($x));
                                                echo $type;
                                                ?>
                                            </td>
                                            <td>
                                                <?= fsize($file); ?>
                                            </td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a style="font-size: 6pt;" href="<?= $file ?>"
                                                                class="btn icon btn-success" download>
                                                                <i data-feather="download"></i>
                                                            </a>
                                                        </td>
                                                        <?php if ($level == 'Administratif') :  ?>

                                                        <td>
                                                            <a style="font-size: 5pt;" href=""
                                                                class="btn icon btn-warning" data-bs-toggle="modal"
                                                                data-bs-target="#edit<?= $row_Document['id_document']  ?>">
                                                                <i data-feather="edit"></i>
                                                            </a>

                                                            <div class="modal fade text-left"
                                                                id="edit<?= $row_Document['id_document'];  ?>"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="myModalLabel160" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="post">
                                                                            <div class="modal-header bg-info">
                                                                                <h5 class="modal-title white"
                                                                                    id="myModalLabel160">
                                                                                    Edit Document</h5>
                                                                                <button type="button" class="close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <i data-feather="x"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- content -->
                                                                                <div class="form-group">
                                                                                    <label>Nama Document</label>
                                                                                    <input type="hidden"
                                                                                        name="id_document"
                                                                                        value="<?= $row_Document['id_document']; ?>">
                                                                                    <input type="text"
                                                                                        name="nama_document"
                                                                                        class="form-control"
                                                                                        value="<?= $row_Document['nama_document']; ?>">
                                                                                </div>
                                                                                <!-- batas -->
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-light-secondary"
                                                                                    data-bs-dismiss="modal">
                                                                                    <i
                                                                                        class="bx bx-x d-block d-sm-none"></i>
                                                                                    <span
                                                                                        class="d-none d-sm-block">Tutup</span>
                                                                                </button>
                                                                                <button type="submit" name="update"
                                                                                    class="btn btn-info ml-1">
                                                                                    <i
                                                                                        class="bx bx-check d-block d-sm-none"></i>
                                                                                    <span
                                                                                        class="d-none d-sm-block">OK</span>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a style="font-size: 6pt;"
                                                                href="document?aksi=hapus&id_document=<?= $row_Document['id_document']; ?>"
                                                                onclick="return confirm('Yakin Ingin menghapus Document <?= $nama_document ?> ?')"
                                                                class="btn icon btn-danger">
                                                                <i data-feather="trash"></i>
                                                            </a>
                                                        </td>
                                                        <?php endif; ?>
                                                </table>
                            </div>

                            <?php } ?>

                            </table>

                            <table style="color: black; font-size: 9.6pt;"
                                class='table table-datatable table-responsive' id="myTable2">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th style="<?= ($level == 'Administratif') ? 'width: 50px;' : ''; ?>">Kode</th>
                                        <th>Jenis Document</th>
                                        <th>Nama Document</th>
                                        <th>Tgl Upload</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $no = 1;
                            if (isset($_POST['filter'])) {
                                $id_jenis_document = $_POST['id_jenis_document'];
                                $Document = mysqli_query($koneksi, "SELECT * FROM document INNER JOIN jenis_document ON document.id_jenis_document=jenis_document.id_jenis_document WHERE document.id_jenis_document='$id_jenis_document' ORDER BY document.nama_document");
                            } else {
                                $Document = mysqli_query($koneksi, "SELECT * FROM document INNER JOIN jenis_document ON document.id_jenis_document=jenis_document.id_jenis_document ORDER BY document.nama_document");
                            }
                            while ($row_Document = mysqli_fetch_array($Document)) {
                                $rfile = $row_Document['file'];
                                $jenis_document = $row_Document['jenis_document'];
                                $file = "file/$jenis_document/$rfile";
                                $nama_document = $row_Document['nama_document'];
                            ?>
                                    <tr style="color: black;">
                                        <td><?php echo $no++; ?></td>
                                        <td><?= ($row_Document['id_document'] > 1000) ? 'DOC-' . $row_Document['id_document'] : 'DOC-00' . $row_Document['id_document']  ?>
                                        </td>
                                        <td><?= $row_Document['jenis_document']; ?></td>
                                        <td><?= $row_Document['nama_document']; ?></td>
                                        <td><?= $row_Document['tgl_upload']; ?></td>
                                        <td>
                                            <?php
                                        $x = explode('.', $rfile);
                                        $type = strtolower(end($x));
                                        echo $type;
                                        ?>
                                        </td>
                                        <td>
                                            <?= fsize($file); ?>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a style="font-size: 6pt;" href="<?= $file ?>"
                                                            class="btn icon btn-success" download>
                                                            <i data-feather="download"></i>
                                                        </a>

                                                    </td>
                                                    <?php if ($level == 'Administratif') :  ?>

                                                    <td>
                                                        <a style="font-size: 5pt;" href="" class="btn icon btn-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit<?= $row_Document['id_document']  ?>">
                                                            <i data-feather="edit"></i>
                                                        </a>

                                                        <div class="modal fade text-left"
                                                            id="edit<?= $row_Document['id_document'];  ?>" tabindex="-1"
                                                            role="dialog" aria-labelledby="myModalLabel160"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <form action="" method="post">
                                                                        <div class="modal-header bg-info">
                                                                            <h5 class="modal-title white"
                                                                                id="myModalLabel160">
                                                                                Edit Document</h5>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <i data-feather="x"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- content -->
                                                                            <div class="form-group">
                                                                                <label>Nama Document</label>
                                                                                <input type="hidden" name="id_document"
                                                                                    value="<?= $row_Document['id_document']; ?>">
                                                                                <input type="text" name="nama_document"
                                                                                    class="form-control"
                                                                                    value="<?= $row_Document['nama_document']; ?>">
                                                                            </div>
                                                                            <!-- batas -->
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-light-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                <i
                                                                                    class="bx bx-x d-block d-sm-none"></i>
                                                                                <span
                                                                                    class="d-none d-sm-block">Tutup</span>
                                                                            </button>
                                                                            <button type="submit" name="update"
                                                                                class="btn btn-info ml-1">
                                                                                <i
                                                                                    class="bx bx-check d-block d-sm-none"></i>
                                                                                <span
                                                                                    class="d-none d-sm-block">OK</span>
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a style="font-size: 6pt;"
                                                            href="document?aksi=hapus&id_document=<?= $row_Document['id_document']; ?>"
                                                            onclick="return confirm('Yakin Ingin menghapus Document <?= $nama_document ?> ?')"
                                                            class="btn icon btn-danger">
                                                            <i data-feather="trash"></i>
                                                        </a>
                                                    </td>
                                                    <?php endif; ?>
                                            </table>
                        </div>

                        <?php } ?>

                        </table>
                    </div>
            </div>


            </section>
        </div>


        <?php
    require_once "../template/footer.php";
    ?>
    </div>
    </div>
    <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="myModalLabel160">
                            File Document <br> Format FILE : PDF, DOCX, XLSX, PPT, PNG <br>Max : 10MB</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="color: black;">
                        <div>
                            <div class="form-group">
                                <label>Jenis Document</label>
                                <select class="form-select" name="id_jenis_document" required="required">
                                    <option value="">--Jenis Document--</option>
                                    <?php
                                    $filter = mysqli_query($koneksi, "SELECT * FROM jenis_document ORDER BY jenis_document ASC");
                                    while ($row_filter = mysqli_fetch_assoc($filter)) {
                                    ?>
                                    <option value="<?= $row_filter['id_jenis_document']; ?>">
                                        <?= $row_filter['jenis_document']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Document</label>
                                <input type="text" autocomplete="off" class="form-control" name="nama_document"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control" name="file" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" name="upload" class="btn btn-info ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Upload</span>
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    <!-- ganti password -->
    <div class="modal fade text-left" id="gantipass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="myModalLabel160"><i data-feather="key"></i> Ganti Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <!-- content -->
                        <div class="form-group">
                            <label>Masukan Password Lama</label>
                            <input type="Password" name="Password_lama" class="form-control" placeholder="Password Lama"
                                required="required">
                        </div>
                        <div class="form-group">
                            <label>Password baru Anda</label>
                            <input type="Password" name="Password_baru" class="form-control" placeholder="Password baru"
                                required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" name="gantipass" class="btn btn-info ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Ok</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!--  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/vendors/DataTables/datatables.js"></script>


    <script src="assets/js/vendors.js"></script>

    <script src="assets/js/main.js"></script>

    <!-- <script>
        $(document).ready(function() {

            // Initialize DataTables
            var table = $("#myTable").DataTable({
                // paging: false,
                searching: false,
                responsive: true
            });
            var originalData = table.rows().data().toArray();
            var originalTableContent; // Variabel untuk menyimpan isi tabel asli

            // Fungsi pencarian
            window.search = function() {
                var searchValue = $("#searchInput").val().toLowerCase(); // Konversi ke huruf kecil
                if (searchValue !== "") {
                    var index = binarySearch(searchValue);
                    if (index !== -1) {
                        $("#myTable tbody").empty();
                        showMatchingRows(searchValue);
                    } else {
                        // Jika pencarian tidak menghasilkan hasil, kembalikan isi tabel asli
                        // $("#myTable tbody").html(originalTableContent);
                        resetTable();
                    }
                } else {
                    table.search("").draw(); // Hapus filter pencarian
                    document.getElementById("step").innerHTML = "";
                    // $("#myTable tbody").html(originalTableContent); // Kembalikan isi tabel asli
                    resetTable();
                }
            };

            // Menyimpan isi tabel asli
            originalTableContent = $("#myTable tbody").html();

            function binarySearch(value) {
                var startTime = performance.now(); // Waktu awal proses pencarian
                var low = 0;
                var high = table.rows().count() - 1;
                var iteration = 0; // Inisialisasi hitungan iterasi
                var stepElement = document.getElementById("step"); // Mendapatkan elemen DOM dengan ID "step"

                // Fungsi untuk menambahkan teks ke dalam elemen DOM "step"
                function addStepText(text) {
                    stepElement.innerHTML += "<p>" + text + "</p>"; // Menambahkan teks ke dalam elemen "step"
                }

                // Membersihkan konten sebelumnya dari elemen "step"
                stepElement.innerHTML = "";

                while (low <= high) {
                    iteration++; // Tambah hitungan iterasi
                    var mid = Math.floor((low + high) / 2);
                    var rowData = table.row(mid).data();
                    var currentValue = rowData[3].toLowerCase(); // Mengambil nilai dari kolom nama (indeks 2) dan mengonversi ke huruf kecil
                    var matchingRows = [];
                    // table.clear();

                    originalData.forEach(function(rowData) {
                        var currentValue = rowData[3].toLowerCase();
                        if (currentValue.includes(currentValue)) {
                            matchingRows.push(rowData);
                        }
                    });


                    addStepText("Iterasi " + iteration + ": (" + low + " + " + high + ") / 2 = " + mid + ", Nama = " + currentValue);


                    if (currentValue === value) {
                        var endTime = performance.now(); // Waktu akhir proses pencarian
                        var timeTaken = endTime - startTime; // Waktu yang dibutuhkan untuk proses pencarian
                        addStepText("Nilai <b>" + value + "</b> ditemukan pada indeks  <b>" + mid + "</b>, dengan penomoran: <b>" + (mid + 1) + "</b>");
                        addStepText("Durasi Pencarian: " + timeTaken.toFixed(2) + " milidetik");
                        return mid; // Nilai ditemukan
                    } else if (currentValue < value) {
                        low = mid + 1; // Menuju setengah kanan
                    } else {
                        high = mid - 1; // Menuju setengah kiri
                    }
                }

                addStepText("Nilai " + value + " tidak ditemukan");
                return -1; // Nilai tidak ditemukan
            }

            // Fungsi untuk menampilkan baris yang sesuai dengan hasil pencarian
            function showMatchingRows(searchValue) {
                // Simpan baris yang sesuai dengan hasil pencarian
                var matchingRows = [];
                table.clear();

                originalData.forEach(function(rowData) {
                    var currentValue = rowData[3].toLowerCase();
                    if (currentValue.includes(searchValue)) {
                        matchingRows.push(rowData);
                    }
                });

                // Tambahkan kembali baris yang sesuai dengan hasil pencarian baru
                matchingRows.forEach(function(rowData) {
                    table.row.add(rowData);
                });

                // Terapkan ulang pencarian DataTables
                table.search(searchValue).draw();
            }


            // Fungsi untuk mengembalikan tabel ke data asli
            function resetTable() {
                table.clear();
                originalData.forEach(function(rowData) {
                    table.row.add(rowData);
                });
                table.draw();
            }

            // Live search saat input berubah
            $("#searchInput").on("input", function() {
                search();
            });
        });
    </script> -->

    <script>
    $(document).ready(function() {

        // Initialize DataTables
        var table = $("#myTable").DataTable({
            searching: false,
            responsive: true
        });

        var table2 = $("#myTable2").DataTable({
            searching: false,
            responsive: true
        });

        // Style tambahan
        $("#myTable2").css("display", "none");
        $("#myTable2_length").css("display", "none");
        $("#myTable2_info").css("display", "none");

        // Simpan data asli tabel dalam variabel terpisah
        var originalData = table.rows().data().toArray();
        var sortedData = originalData.slice().sort((a, b) => a[3].localeCompare(b[3]));

        var typingTimer;
        var doneTypingInterval = 1000;

        window.search = function() {
            clearTimeout(typingTimer); // Hapus timeout sebelumnya
            typingTimer = setTimeout(performSearch, doneTypingInterval); // Mulai timeout baru
        };

        function performSearch() {
            var searchValue = $("#searchInput").val().toLowerCase();
            if (searchValue !== "") {
                var index = binarySearch(searchValue);
                if (index !== -1) {
                    $("#myTable tbody").empty();
                    showMatchingRows(searchValue);
                } else {
                    $("#myTable").css("display", "none");
                    $("#myTable_length").css("display", "none");
                    $("#myTable_info").css("display", "none");
                    if (showMatchingRows2(searchValue)) {
                        $("#myTable2").css("display", "block");
                        $("#myTable2_length").css("display", "block");
                        $("#myTable2_info").css("display", "block");
                    } else {
                        resetTable();
                    }
                }
            } else {
                resetTable();
                document.getElementById("step").innerHTML = "";
            }
        }

        function showMatchingRows(searchValue) {
            // Simpan baris yang sesuai dengan hasil pencarian
            var matchingRows = [];
            table.clear();

            originalData.forEach(function(rowData) {
                var currentValue = rowData[3].toLowerCase();
                if (currentValue.includes(searchValue)) {
                    matchingRows.push(rowData);
                }
            });

            matchingRows.forEach(function(rowData) {
                table.row.add(rowData);
            });

            table.search(searchValue).draw();
        }

        function showMatchingRows2(searchValue) {
            // Simpan baris yang sesuai dengan hasil pencarian
            var matchingRows = [];
            table2.clear();

            sortedData.forEach(function(rowData) {
                var currentValue = rowData[3].toLowerCase();
                if (currentValue.includes(searchValue)) {
                    matchingRows.push(rowData);
                }
            });

            // Tambahkan kembali baris yang sesuai dengan hasil pencarian baru
            matchingRows.forEach(function(rowData) {
                table2.row.add(rowData);
            });

            // Terapkan ulang pencarian DataTables
            var result = matchingRows.length > 0;
            table2.search(searchValue).draw();
            return result;
        }

        function binarySearch(value) {
            var startTime = performance.now(); // Waktu awal proses pencarian
            var low = 0;
            var high = sortedData.length - 1; // Gunakan data yang telah diurutkan
            var iteration = 0; // Inisialisasi hitungan iterasi
            var stepElement = document.getElementById("step");

            function addStepText(text) {
                stepElement.innerHTML += "<p>" + text + "</p>";
            }

            stepElement.innerHTML = "";
            while (low <= high) {
                iteration++;
                var mid = Math.floor((low + high) / 2);
                var rowData = sortedData[mid];
                var currentValue = rowData[3].toLowerCase();
                addStepText("Iterasi " + iteration + ": (" + low + " + " + high + ") / 2 = " + mid +
                    ", Nama = " + currentValue);
                if (currentValue === value) {
                    var endTime = performance.now(); // Waktu akhir proses pencarian
                    var timeTaken = endTime - startTime; // Waktu yang dibutuhkan untuk proses pencarian
                    addStepText("Nilai <b>" + value + "</b> ditemukan pada indeks <b>" + mid +
                        "</b>, dengan penomoran: <b>" + (mid + 1) + "</b>");
                    addStepText("Durasi Pencarian: " + timeTaken.toFixed(2) + " milidetik");
                    return mid; // Nilai ditemukan
                } else if (currentValue < value) {
                    low = mid + 1;
                } else {
                    high = mid - 1;
                }
            }
            addStepText("Nilai " + value + " tidak ditemukan");
            return -1; // Nilai tidak ditemukan
        }

        // Fungsi untuk mengembalikan tabel ke data asli
        function resetTable() {
            table.clear();
            table2.clear();
            originalData.forEach(function(rowData) {
                table.row.add(rowData);
                table2.row.add(rowData);
            });
            table.draw();
            table2.draw();

            // Tampilkan kembali table1 dan sembunyikan table2
            $("#myTable").css("display", "block");
            $("#myTable_length").css("display", "block");
            $("#myTable_info").css("display", "block");
            $("#myTable2").css("display", "none");
            $("#myTable2_length").css("display", "none");
            $("#myTable2_info").css("display", "none");
        }

        // Live search saat input berubah
        $("#searchInput").on("input", function() {
            search();
        });
    });
    </script>



</body>

</html>