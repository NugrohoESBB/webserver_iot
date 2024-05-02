-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Bulan Mei 2024 pada 08.58
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_iot`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `station1`
--

CREATE TABLE `station1` (
  `id` int(6) UNSIGNED NOT NULL,
  `temp` double NOT NULL,
  `difftemp` double NOT NULL,
  `perctemp` double NOT NULL,
  `hum` double NOT NULL,
  `diffhum` double NOT NULL,
  `perchum` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `station1`
--

INSERT INTO `station1` (`id`, `temp`, `difftemp`, `perctemp`, `hum`, `diffhum`, `perchum`, `created_at`) VALUES
(1, 29.9, 29.9, 11.68, 82.9, 82.9, 32.38, '2024-04-24 14:46:06'),
(2, 30.1, 0.2, 0.08, 84, 1.1, 0.43, '2024-04-24 14:47:06'),
(3, 30, -0.1, -0.04, 83.8, -0.2, -0.08, '2024-04-24 14:49:07'),
(4, 30.2, 0.2, 0.08, 83.8, -0.2, -0.08, '2024-04-24 14:52:09'),
(5, 30.3, 0.1, 0.04, 83.3, -0.3, -0.12, '2024-04-24 14:58:11'),
(6, 30.5, 0.2, 0.08, 83, -0.3, -0.12, '2024-04-24 14:59:11'),
(7, 30.6, 0.1, 0.04, 82.6, -0.4, -0.16, '2024-04-24 15:00:12'),
(8, 30.7, 0.1, 0.04, 82, -0.2, -0.08, '2024-04-24 15:02:13'),
(9, 30.6, -0.1, -0.04, 82.2, 0.2, 0.08, '2024-04-24 15:03:13'),
(10, 30.5, -0.1, -0.04, 82.6, 0.2, 0.08, '2024-04-24 15:05:14'),
(11, 30.4, -0.1, -0.04, 82.9, 0.3, 0.12, '2024-04-24 15:06:14'),
(12, 30.3, -0.1, -0.04, 83.1, 0.2, 0.08, '2024-04-24 15:07:21'),
(13, 30.4, 0.1, 0.04, 83.1, -0.2, -0.08, '2024-04-24 15:11:21'),
(14, 30.5, 0.1, 0.04, 82.4, -0.3, -0.12, '2024-04-24 15:19:22'),
(15, 30.7, 0.1, 0.04, 82, -0.4, -0.16, '2024-04-24 15:22:22'),
(16, 30.6, -0.1, -0.04, 82.2, 0.2, 0.08, '2024-04-24 15:23:23'),
(17, 30.6, -0.1, -0.04, 82.2, 0.2, 0.08, '2024-04-24 15:26:28'),
(18, 30.7, 0.1, 0.04, 81.8, -0.4, -0.16, '2024-04-24 15:31:29'),
(19, 30.5, -0.1, -0.04, 82.2, 0.2, 0.08, '2024-04-24 15:40:30'),
(20, 30.6, 0.1, 0.04, 82, -0.2, -0.08, '2024-04-24 15:41:31'),
(21, 30.7, 0.1, 0.04, 81.8, -0.2, -0.08, '2024-04-24 15:42:31'),
(22, 32.7, 32.7, 12.77, 63.4, 63.4, 24.77, '2024-05-01 07:12:46'),
(23, 33, 0.3, 0.12, 65.6, 2.2, 0.86, '2024-05-01 07:13:45'),
(24, 32.9, -0.1, -0.04, 65.6, 0.1, 0.04, '2024-05-01 07:15:45'),
(25, 33.2, 0.2, 0.08, 64.6, -0.9, -0.35, '2024-05-01 07:18:49'),
(26, 33.4, 0.2, 0.08, 63.9, -0.7, -0.27, '2024-05-01 07:20:50'),
(27, 33.6, 0.2, 0.08, 62.6, -1.3, -0.51, '2024-05-01 07:21:51'),
(28, 33.7, 0.1, 0.04, 61.9, -0.7, -0.27, '2024-05-01 07:22:51'),
(29, 33.6, -0.1, -0.04, 62.1, 0.2, 0.08, '2024-05-01 07:23:52'),
(30, 33.5, -0.1, -0.04, 61.6, -0.5, -0.2, '2024-05-01 07:24:53'),
(31, 33.4, 0, 0, 63, 0, 0, '2024-05-01 07:26:56'),
(32, 33.5, 0.1, 0.04, 62.5, -0.5, -0.2, '2024-05-01 07:28:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `station1asli`
--

CREATE TABLE `station1asli` (
  `id` int(6) UNSIGNED NOT NULL,
  `temp` double NOT NULL,
  `difftemp` double NOT NULL,
  `perctemp` double NOT NULL,
  `hum` double NOT NULL,
  `diffhum` double NOT NULL,
  `perchum` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `station1asli`
--

INSERT INTO `station1asli` (`id`, `temp`, `difftemp`, `perctemp`, `hum`, `diffhum`, `perchum`, `created_at`) VALUES
(1, 25.2, 25.2, 9.84, 53.4, 53.4, 20.86, '2024-04-22 06:42:32'),
(2, 25.1, -0.1, -0.04, 53.8, 0.4, 0.16, '2024-04-22 06:43:17'),
(3, 25.1, 0, 0, 53.7, -0.1, -0.04, '2024-04-22 07:08:34'),
(4, 25, -0.1, -0.04, 52.5, -0.3, -0.12, '2024-04-22 07:18:56'),
(5, 36, 11, 44, 69.71, 17.21, 32.78, '2024-04-22 08:30:16'),
(6, 45.2, 9.2, 25.55, 73.66, 3.95, 5.66, '2024-04-22 08:34:26'),
(7, 26.8, -18.4, -40.7, 59.71, -13.95, -18.93, '2024-04-22 08:38:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `station1`
--
ALTER TABLE `station1`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `station1asli`
--
ALTER TABLE `station1asli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `station1`
--
ALTER TABLE `station1`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `station1asli`
--
ALTER TABLE `station1asli`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
