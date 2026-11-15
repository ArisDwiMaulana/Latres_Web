-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 15, 2026 at 07:16 AM
-- Server version: 10.4.34-MariaDB-1:10.4.34+maria~ubu2004
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_roti`
--

-- --------------------------------------------------------

--
-- Table structure for table `kue`
--

CREATE TABLE `kue` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kue`
--

INSERT INTO `kue` (`id`, `nama`, `harga`, `stok`, `foto`, `created_at`) VALUES
(1, 'croissant', 50000, 10, 'croissant.jpg', '2026-11-15 02:59:55'),
(2, 'Kue ulang tahun', 250000, 3, 'kue_ulang_tahun.jpg', '2026-11-15 02:59:55'),
(3, 'Kue lapis', 80000, 7, 'kue_lapis.jpg', '2026-11-15 02:59:55'),
(4, 'Kue Lumpur', 12000, 25, 'kue_lumpur.jpg', '2026-11-15 02:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'mamat', '$2y$10$IpoWPnOmcxidv0tYc0w5Fu5d8qrdvftFcfwgLL0.oBt9/Unnc5jly', '2026-11-14 07:43:52'),
(2, 'atmin', '$2y$10$CHW6M8uamwtdp9.4JnlVBOG4spgJ/cLGS1fwoGorEwP/BEnNLQBvS', '2026-11-15 07:13:04'),
(3, 'jujun', '$2y$10$yWahvgy4./laShUkcNIcT.El0q0tPv8joLThPzcMcHW5KvZIEFqZW', '2026-11-15 07:13:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kue`
--
ALTER TABLE `kue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kue`
--
ALTER TABLE `kue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
