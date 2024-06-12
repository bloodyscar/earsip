-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jun 2024 pada 05.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `document`
--

CREATE TABLE `document` (
  `id_document` int(11) NOT NULL,
  `id_jenis_document` int(11) NOT NULL,
  `nama_document` text NOT NULL,
  `file` text NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `document`
--

INSERT INTO `document` (`id_document`, `id_jenis_document`, `nama_document`, `file`, `tgl_upload`) VALUES
(1, 2, 'Cover Laporan Dan Evaluasi Program', 'Cover Laporan Dan Evaluasi Program.pdf', '2024-05-23'),
(2, 3, 'Contoh Proposal UKK', 'Cotoh Proposal UKK.docx', '2024-05-23'),
(3, 3, 'Proposal Cover Rencana Kegiatan Sekolah', 'Proposal Cover Rencana Kegiatan Sekolah.pdf', '2024-05-23'),
(4, 3, 'Proposal EEJ Edisi Revisi', 'Proposal EEJ Edisi Revisi.pdf', '2024-05-23'),
(5, 3, 'Proposal Kegiatan EEJ', 'Proposal Kegiatan EEJ.pdf', '2024-05-23'),
(6, 3, 'Proposal Kegiatan PMR', 'Proposal Kegiatan PMR.docx', '2024-05-23'),
(7, 3, 'Proposal LDKS', 'Proposal LDKS.docx', '2024-05-23'),
(8, 3, 'Proposal Manasik Haji', 'Proposal Manasik Haji.pdf', '2024-05-23'),
(9, 3, 'Proposal Prakerin', 'Proposal Prakerin.docx', '2024-05-23'),
(10, 3, 'Proposal Ramadhan Ceria', 'Proposal Ramadhan Ceria.pdf', '2024-05-23'),
(11, 3, 'Proposal UAS SMK', 'Proposal UAS SMK.pdf', '2024-05-23'),
(12, 3, 'Proposal US', 'Proposal US.pdf', '2024-05-23'),
(13, 3, 'Proposal UTS 2017', 'Proposal UTS 2017.pdf', '2024-05-23'),
(15, 1, 'Format Verifikasi Guru Dan Kepala Sekolah', 'Format Verifikasi Guru & Kepala Sekolah.pdf', '2024-05-23'),
(18, 5, 'Education Journey Japan', 'Education Journey Japan.pptx', '2024-05-23'),
(19, 6, 'Fisika X', 'Fisika X.pdf', '2024-05-23'),
(20, 6, 'Kimia X SMK', 'Kimia X SMK.pdf', '2024-05-23'),
(21, 7, 'Soal Kimia X', 'Soal Kimia X.pdf', '2024-05-23'),
(22, 7, 'Soal PKN X', 'Soal PKN X.pdf', '2024-05-23'),
(23, 8, 'SK Akreditasi', 'SK Akreditasi.pdf', '2024-05-23'),
(25, 11, 'Pelaksanaan Akreditasi Tahap II', 'Pelaksanaan Akreditasi Tahap II.pdf', '2024-05-23'),
(26, 10, 'Forum Organisasi Siswa Intra Sekolah', 'Forum Organisasi Siswa Intra Sekolah.pdf', '2024-05-23'),
(27, 10, 'Undangan Sosialisasi PBD SMK', 'Undangan Sosialisasi PBD SMK.pdf', '2024-05-23'),
(31, 3, 'Proposal UTS', 'Proposal UTS.docx', '2024-05-23'),
(38, 12, 'Kimia X', 'KIMIA X REVISI.docx', '2024-05-23'),
(39, 12, 'Ipa XII', 'Ipa XII.docx', '2024-05-23'),
(40, 12, 'Ipa X', 'Ipa X.pdf', '2024-05-23'),
(41, 12, 'Pai X', 'Pai XI.pdf', '2024-05-23'),
(42, 12, 'Fisika X', 'Fisika X.pdf', '2024-05-23'),
(43, 6, 'Ipa X', 'Ipa X.pdf', '2024-05-23'),
(44, 7, 'Ipa X', 'Ipa X.pdf', '2024-05-23'),
(45, 7, 'Kimia XI ', 'Kimia XI.pdf', '2024-05-23'),
(46, 2, 'Laporan Kegiatan Masa Orientasi Siswa', 'Laporan Kegiatan Masa Orientasi Siswa.pdf', '2024-05-23'),
(47, 11, 'Pelaksanaa Akreditasi Tahap IV', 'Pelaksanaa Akreditasi Tahap IV.pdf', '2024-05-23'),
(59, 1, 'A', 'CLDS FIXXX AJA.drawio.png', '2024-06-01'),
(60, 10, 'ABC', 'DIAGRAMMMM UMLLL SKRIPSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS-Halaman-17.drawio.png', '2024-06-01'),
(62, 1, 't1', 'JIKO-UTDI-NEW-Template.docx', '2024-06-04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_pribadi`
--

CREATE TABLE `document_pribadi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jenis_document` varchar(11) NOT NULL,
  `nama_document` text NOT NULL,
  `file` text NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `document_pribadi`
--

INSERT INTO `document_pribadi` (`id`, `id_user`, `id_jenis_document`, `nama_document`, `file`, `tgl_upload`) VALUES
(11, 22, '10', 'TESSSS', '557-1593-1-PB.pdf', '2024-06-05'),
(12, 22, '17', 'COBA ', 'FORMULIR PERSYARATAN SIDANG SKRIPSI (1).docx', '2024-06-08'),
(13, 23, '17', 'Cek', 'Reza (2)-Page-1.drawio (1).png', '2024-06-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_document`
--

CREATE TABLE `jenis_document` (
  `id_jenis_document` int(11) NOT NULL,
  `jenis_document` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_document`
--

INSERT INTO `jenis_document` (`id_jenis_document`, `jenis_document`) VALUES
(1, 'Lampiran Undangan'),
(2, 'Laporan kegiatan'),
(3, 'Proposal Kegiatan'),
(5, 'Seminar'),
(6, 'Silabus'),
(7, 'Soal Ujian'),
(8, 'Surat Keterangan'),
(10, 'Surat Undangan'),
(11, 'Surat Pemberitahuan'),
(12, 'RPP'),
(17, 'Absen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `share_document`
--

CREATE TABLE `share_document` (
  `id_share` int(11) NOT NULL,
  `id_from_user` int(11) NOT NULL,
  `id_to_user` int(11) NOT NULL,
  `id_document_pribadi` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `share_document`
--

INSERT INTO `share_document` (`id_share`, `id_from_user`, `id_to_user`, `id_document_pribadi`, `created_at`) VALUES
(8, 22, 31, 11, '2024-06-05 15:10:01'),
(9, 23, 22, 13, '2024-06-08 22:13:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` text NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
(22, 'reza', 'bb98b1d0b523d5e783f931550d7702b6', 'Administratif'),
(23, 'Widya', '9146bfc09df862ee46fa9b512c72f9a6', 'Guru'),
(24, 'Suratmi', '659791a31f82b92d1b08b36a5bb95ddb', 'Guru'),
(25, 'Taufik', '1484d6b47b5990d7c5b75a122cc44022', 'Guru'),
(26, 'Hadi', 'c8bfbd4887cb16addccd97887e278a2c', 'Guru'),
(27, 'Eka', '456da125e5a1c0bcc2bdbdc4fd710ac6', 'Administratif'),
(28, 'tes', 'bfbf5345f5627ea3d5caf8cc69406a35', 'Guru'),
(31, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administratif'),
(32, 'guru', '77e69c137812518e359196bb2f5e9bb9', 'Guru');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id_document`),
  ADD KEY `id_jenis_document` (`id_jenis_document`);

--
-- Indeks untuk tabel `document_pribadi`
--
ALTER TABLE `document_pribadi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jenis_document` (`id_jenis_document`);

--
-- Indeks untuk tabel `jenis_document`
--
ALTER TABLE `jenis_document`
  ADD PRIMARY KEY (`id_jenis_document`);

--
-- Indeks untuk tabel `share_document`
--
ALTER TABLE `share_document`
  ADD PRIMARY KEY (`id_share`),
  ADD KEY `id_from_user` (`id_from_user`),
  ADD KEY `id_to_user` (`id_to_user`),
  ADD KEY `id_document_pribadi` (`id_document_pribadi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `document`
--
ALTER TABLE `document`
  MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `document_pribadi`
--
ALTER TABLE `document_pribadi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `jenis_document`
--
ALTER TABLE `jenis_document`
  MODIFY `id_jenis_document` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `share_document`
--
ALTER TABLE `share_document`
  MODIFY `id_share` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`id_jenis_document`) REFERENCES `jenis_document` (`id_jenis_document`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `document_pribadi`
--
ALTER TABLE `document_pribadi`
  ADD CONSTRAINT `document_pribadi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `share_document`
--
ALTER TABLE `share_document`
  ADD CONSTRAINT `share_document_ibfk_1` FOREIGN KEY (`id_from_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `share_document_ibfk_2` FOREIGN KEY (`id_to_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `share_document_ibfk_3` FOREIGN KEY (`id_document_pribadi`) REFERENCES `document_pribadi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
