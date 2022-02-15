-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 15 fév. 2022 à 19:15
-- Version du serveur :  10.2.39-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `urzawebf_db`
--

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `firstName`, `pseudo`, `email`, `phone`, `portable`, `password`, `salt`, `statusConnected`, `activeUser`, `validationKey`, `activatedUser`, `dateCreate`, `TypeUser_idTypeUser`, `askPromotion`, `code`) VALUES
(1, 'Doe', 'John', 'ADMIN', 'mon@email.fr', '', '', '$2y$10$fs5X9t59RGsuN5UKikN3L.tAidl6PhwZ.CYXCIH6.Z7MKJbI1xw2m', 's4IFJjOn/l', 1, 1, '08eddc8f7bbe8a94b38442ea07f8f49172bdd49db518ef7f9ddd69a84cdd5045', 1, '2022-02-15', 4, 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
