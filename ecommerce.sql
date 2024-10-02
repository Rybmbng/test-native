-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Okt 2024 pada 21.59
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `master_barang`
--

INSERT INTO `master_barang` (`kode_barang`, `nama_barang`, `harga`, `stok`) VALUES
('001', 'Skin Care', 5000, 12),
('002', 'Body Care', 4000, 100),
('003', 'Facial Care', 3000, 100),
('004', 'Hair Care', 2000, 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_header`
--

CREATE TABLE `penjualan_header` (
  `no_transaksi` varchar(20) NOT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `kode_promo` varchar(20) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `grand_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan_header`
--

INSERT INTO `penjualan_header` (`no_transaksi`, `tgl_transaksi`, `customer`, `kode_promo`, `total_bayar`, `ppn`, `grand_total`) VALUES
('202410-001', '2024-10-02', 'Michael', 'promo-001', 11000, 1100, 12100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_header_detail`
--

CREATE TABLE `penjualan_header_detail` (
  `id` int(11) NOT NULL,
  `no_transaksi` varchar(20) DEFAULT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan_header_detail`
--

INSERT INTO `penjualan_header_detail` (`id`, `no_transaksi`, `kode_barang`, `qty`, `harga`, `discount`, `subtotal`) VALUES
(17, '202410-001', '001', 1, 5000, 0, 5000),
(18, '202410-001', '003', 3, 3000, 3000, 6000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo`
--

CREATE TABLE `promo` (
  `kode_promo` varchar(20) NOT NULL,
  `nama_promo` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `promo`
--

INSERT INTO `promo` (`kode_promo`, `nama_promo`, `keterangan`) VALUES
('promo-001', 'promo facial care', 'setiap pembelian Facial Care sejumlah 2 pcs akan mendapat potongan harga 3000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `penjualan_header`
--
ALTER TABLE `penjualan_header`
  ADD PRIMARY KEY (`no_transaksi`);

--
-- Indeks untuk tabel `penjualan_header_detail`
--
ALTER TABLE `penjualan_header_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_transaksi` (`no_transaksi`);

--
-- Indeks untuk tabel `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`kode_promo`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penjualan_header_detail`
--
ALTER TABLE `penjualan_header_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penjualan_header_detail`
--
ALTER TABLE `penjualan_header_detail`
  ADD CONSTRAINT `penjualan_header_detail_ibfk_1` FOREIGN KEY (`no_transaksi`) REFERENCES `penjualan_header` (`no_transaksi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
