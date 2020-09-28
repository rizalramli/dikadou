-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Bulan Mei 2020 pada 11.21
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dikadou`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(3) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(9) NOT NULL,
  `tingkat_kesulitan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `tingkat_kesulitan`) VALUES
(13, 'AL QUR\'AN KECIL', 155000, 4),
(14, 'AL QUR\'AN BESAR', 185000, 5),
(15, 'GARSKIN COVER', 70000, 3),
(16, 'GARSKIN FULL ', 115000, 4),
(17, 'MUG', 20000, 3),
(18, 'TOTEBAG', 15000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(9) NOT NULL,
  `id_transaksi` varchar(8) NOT NULL,
  `id_barang` int(3) NOT NULL,
  `id_kriteria` int(3) NOT NULL,
  `nama_barang_detail` text NOT NULL,
  `value_kriteria` varchar(50) NOT NULL,
  `status_pengerjaan` enum('Belum Selesai','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_barang`, `id_kriteria`, `nama_barang_detail`, `value_kriteria`, `status_pengerjaan`) VALUES
(41, 'T0000001', 14, 5, 'Adi,08923412312,AL QUR\'AN BESAR 0000000001', '2020-05-20', 'Belum Selesai'),
(42, 'T0000001', 14, 6, 'Adi,08923412312,AL QUR\'AN BESAR 0000000001', '3', 'Belum Selesai'),
(43, 'T0000001', 14, 7, 'Adi,08923412312,AL QUR\'AN BESAR 0000000001', '185000', 'Belum Selesai'),
(44, 'T0000001', 14, 8, 'Adi,08923412312,AL QUR\'AN BESAR 0000000001', '5', 'Belum Selesai'),
(45, 'T0000001', 14, 9, 'Adi,08923412312,AL QUR\'AN BESAR 0000000001', '5', 'Belum Selesai'),
(46, 'T0000002', 16, 5, 'Munih,08213213221,GARSKIN FULL  0000000002', '2020-05-19', 'Belum Selesai'),
(47, 'T0000002', 16, 6, 'Munih,08213213221,GARSKIN FULL  0000000002', '2', 'Belum Selesai'),
(48, 'T0000002', 16, 7, 'Munih,08213213221,GARSKIN FULL  0000000002', '115000', 'Belum Selesai'),
(49, 'T0000002', 16, 8, 'Munih,08213213221,GARSKIN FULL  0000000002', '3', 'Belum Selesai'),
(50, 'T0000002', 16, 9, 'Munih,08213213221,GARSKIN FULL  0000000002', '4', 'Belum Selesai'),
(51, 'T0000003', 17, 5, 'Kafi,0891232112,MUG 0000000003', '2020-05-21', 'Belum Selesai'),
(52, 'T0000003', 17, 6, 'Kafi,0891232112,MUG 0000000003', '4', 'Belum Selesai'),
(53, 'T0000003', 17, 7, 'Kafi,0891232112,MUG 0000000003', '20000', 'Belum Selesai'),
(54, 'T0000003', 17, 8, 'Kafi,0891232112,MUG 0000000003', '20', 'Belum Selesai'),
(55, 'T0000003', 17, 9, 'Kafi,0891232112,MUG 0000000003', '3', 'Belum Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(3) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `atribut` enum('Benefit','Cost') NOT NULL,
  `bobot` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `atribut`, `bobot`) VALUES
(5, 'Sisa Hari', 'Cost', 5),
(6, 'Waktu Pengerjaan', 'Cost', 4),
(7, 'Harga', 'Benefit', 3),
(8, 'Jumlah Pesanan', 'Benefit', 4),
(9, 'Tingkat Kesulitan', 'Cost', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(8) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tgl_deadline` date NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `total_harga` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_transaksi`, `tgl_deadline`, `nama_customer`, `no_hp`, `total_harga`) VALUES
('T0000001', '2020-05-17', '2020-05-20', 'Adi', '08923412312', 925000),
('T0000002', '2020-05-17', '2020-05-19', 'Munih', '08213213221', 345000),
('T0000003', '2020-05-17', '2020-05-21', 'Kafi', '0891232112', 400000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`) VALUES
(4, 'admin', 'admin', '$2y$10$yaWKvuE9jGsOxTFUcSpVRO0hiYfw5lOR1akh2x2ZXIZ.FPRk4w/y6');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
