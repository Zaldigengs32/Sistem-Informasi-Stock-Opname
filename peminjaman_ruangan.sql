-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2022 pada 16.53
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_ruangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto` varchar(500) DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`username`, `password`, `nama`, `nohp`, `email`, `foto`, `status`) VALUES
('Max', 'max12345', 'Max Cowell Robert', '082374212567', 'mcowll@gmail.com', '1650099101-download-(1).jpg', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `idBarang` int(11) NOT NULL,
  `idRuangan` int(11) NOT NULL,
  `namaBarang` varchar(50) NOT NULL,
  `totalBarang` int(11) NOT NULL,
  `jumlahTersedia` int(11) NOT NULL,
  `jumlahRusak` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`idBarang`, `idRuangan`, `namaBarang`, `totalBarang`, `jumlahTersedia`, `jumlahRusak`, `status`) VALUES
(1, 105, 'sasa', 3113, 34, 3, 1),
(4, 105, 'test', 2, 2, 2, 1),
(5, 105, 'qwerty', 122332, 323, 21311, 0),
(6, 105, 'test', 1, 2, 3, 0),
(7, 105, 'test123', 11123, 22123, 33123, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_ruangan`
--

CREATE TABLE `jenis_ruangan` (
  `idJenisRuangan` int(11) NOT NULL,
  `namaJenisRuangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_ruangan`
--

INSERT INTO `jenis_ruangan` (`idJenisRuangan`, `namaJenisRuangan`) VALUES
(1, 'Kelas'),
(2, 'Laboratorium');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idPeminjaman` int(11) NOT NULL,
  `idRuangan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `mulai` time NOT NULL,
  `selesai` time NOT NULL,
  `jumlahPemakai` int(11) NOT NULL,
  `nim` int(11) NOT NULL,
  `peminjam` varchar(50) NOT NULL,
  `tingkat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `idRuangan` int(11) NOT NULL,
  `idJenisRuangan` int(11) NOT NULL,
  `idSop` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `namaRuangan` varchar(50) NOT NULL,
  `statusPinjam` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`idRuangan`, `idJenisRuangan`, `idSop`, `username`, `namaRuangan`, `statusPinjam`, `kapasitas`, `foto`, `status`) VALUES
(105, 2, 2, 'Max', '101', 1, 30, '1650098467-download-(5).jpg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sop`
--

CREATE TABLE `sop` (
  `idSop` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sop`
--

INSERT INTO `sop` (`idSop`, `deskripsi`) VALUES
(1, 'sop1'),
(2, 'sop2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idBarang`);

--
-- Indeks untuk tabel `jenis_ruangan`
--
ALTER TABLE `jenis_ruangan`
  ADD PRIMARY KEY (`idJenisRuangan`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idPeminjaman`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`idRuangan`);

--
-- Indeks untuk tabel `sop`
--
ALTER TABLE `sop`
  ADD PRIMARY KEY (`idSop`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `idBarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jenis_ruangan`
--
ALTER TABLE `jenis_ruangan`
  MODIFY `idJenisRuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idPeminjaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `idRuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `sop`
--
ALTER TABLE `sop`
  MODIFY `idSop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
