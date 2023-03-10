-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 oct. 2022 à 15:51
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `poo_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `host_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `email`, `phone_number`, `role`, `host_id`, `customer_id`) VALUES
(1, 'dyson@contact.fr', '0344853614', 'Client', NULL, 1),
(2, 'ca@contact.fr', '0344812514', 'Client', NULL, 2),
(3, 'citroen@contact.fr', '0344813614', 'Client', NULL, 3),
(4, 'philips@contact.fr', '0344818414', 'Client', NULL, 4),
(5, 'orpi@contact.fr', '0344812314', 'Client', NULL, 5),
(6, 'saint-gobain@contact.fr', '0344851354', 'Client', NULL, 6),
(7, 'pmu@contact.fr', '0344100814', 'Client', NULL, 7),
(8, 'pocalin@contact.fr', '0344817314', 'Client', NULL, 8),
(9, 'cofidis@contact.fr', '0344853614', 'Client', NULL, 9),
(10, 'ipsec@contact.fr', '0344853452', 'Client', NULL, 10),
(11, 'eads@contact.f', '0344060606', 'Client', NULL, 11),
(12, 'corporate@hotelbb.com', '0892788115', 'Client', NULL, 12),
(13, 'marketing@assystem.com', '0341252900', 'Client', NULL, 13),
(14, 'contact@ionos.fr', '0970808911', 'Hébergeur web', 1, NULL),
(15, 'fr@hostinger.com', '0892977093', 'Hébergeur web', 2, NULL),
(16, 'investors@godaddy.com', '0975187039', 'Gestion nom de domaine', 3, NULL),
(17, 'support@gator.com', '0891150447', 'Hébergeur web', 4, NULL),
(18, 'contact@com-network.fr', '03825745692', 'Gestion nom de domaine', 5, NULL),
(19, 'contacta2hosting.com', '1734-222-4678', 'Hébergeur web', 6, NULL),
(20, 'contact@inmotion.com', '888-321-4678', 'Hébergeur web', 7, NULL),
(21, 'marketing@webhostingpad.com', '1847346180', 'Hébergeur web', 8, NULL),
(22, 'contact@007hebergement.com', '0177623003', 'Hébergeur web', 9, NULL),
(23, 'support@planethoster.com', '0176604143', 'Hébergeur web', 10, NULL),
(24, 'support@ovh.com', '0972101007', 'Hébergeur web', 11, NULL),
(25, 'support@lws.com', '0177623003', 'Hébergeur web', 12, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `code`, `name`, `notes`) VALUES
(1, 'CUST_DYSON', 'DYSON', 'Ceci est un client'),
(2, 'CUST_CREDIT_AGRICOLE', 'CREDIT AGRICOLE', 'Ceci est un autre client'),
(3, 'CUST_CITROEN', 'CITROEN', 'Ceci est un troisième client'),
(4, 'CUST_PHILIPS', 'PHILIPS', 'Ceci est un quatrième client'),
(5, 'CUST_ORPI', 'ORPI', 'Ceci est un cinquième client'),
(6, 'CUST_SAINT_GOBAIN', 'SAINT-GOBAIN', 'Ceci est un sixième client'),
(7, 'CUST_PMU', 'PMU', 'Ceci est un septième client'),
(8, 'CUST_POCLAIN_HYDRAULICS', 'POCLAIN HYDRAULICS', 'Ceci est un huitième client'),
(9, 'CUST_COFIDIS', 'COFIDIS', 'Ceci est un neuvième client'),
(10, 'CUST_IPSEC', 'IPSEC', 'Ceci est un dixième client'),
(11, 'CUST_EADS', 'EADS', 'Ceci est un onzième client'),
(12, 'CUST_B&B_HOTELS', 'B&B HOTELS', 'Ceci est un douzième client'),
(13, 'CUST_ASSYSTEM', 'ASSYSTEM', 'Ceci est un autre client');

-- --------------------------------------------------------

--
-- Structure de la table `environment`
--

CREATE TABLE `environment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `ssh_port` int(6) NOT NULL,
  `ssh_username` varchar(255) NOT NULL,
  `phpmyadmin_link` varchar(255) NOT NULL,
  `ip_restriction` tinyint(1) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `environment`
--

INSERT INTO `environment` (`id`, `name`, `link`, `ip_address`, `ssh_port`, `ssh_username`, `phpmyadmin_link`, `ip_restriction`, `project_id`) VALUES
(1, 'Production', 'https://adobe-xd.com//dyson-extranet', '172.00.00.01', 22, 'ssh-dyson', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 1),
(2, 'Production_2', 'https://adobe-xd.com//creditAgricole-extranet', '172.00.00.02', 22, 'ssh-creditAgricole', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 2),
(3, 'Production_3', 'https://adobe-xd.com//citroen-extranet', '172.00.00.03', 22, 'ssh-citroen', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 3),
(4, 'Production_4', 'https://adobe-xd.com//philips-extranet', '172.00.00.04', 22, 'ssh-philips', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 4),
(5, 'Production_5', 'https://adobe-xd.com//orpi-extranet', '172.00.00.05', 22, 'ssh-orpi', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 5),
(6, 'Production_6', 'https://adobe-xd.com//saintGobain-extranet', '172.00.00.06', 22, 'ssh-saintGobain', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 6),
(7, 'Production_7', 'https://adobe-xd.com//pmu-extranet', '172.00.00.07', 23, 'ssh-pmu', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 7),
(8, 'Production_8', 'https://adobe-xd.com//poclainHydraulics-extranet', '172.00.00.08', 22, 'ssh-poclainHudraulics', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 8),
(9, 'Production_9', 'https://adobe-xd.com//cofidis-extranet', '172.00.00.09', 22, 'ssh-cofidis', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 1, 9),
(10, 'Production_10', 'https://adobe-xd.com//ipsec-extranet', '172.00.00.10', 22, 'ssh-ipsec', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 1, 11),
(11, 'Production_11', 'https://adobe-xd.com//eads-extranet', '172.00.00.11', 22, 'ssh-eads', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 0, 11),
(12, 'Production_12', 'https://adobe-xd.com//B&B_Hotels-extranet', '172.00.00.20', 21, 'ssh-B&B_Hotels', 'http://localhost/phpmyadmin/index.php?route=/database/structure&db=poo_php', 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `host`
--

CREATE TABLE `host` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `notes` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `host`
--

INSERT INTO `host` (`id`, `code`, `name`, `notes`) VALUES
(1, 'HOST_IONOS', 'IONOS', 'Ceci est un hébergeur'),
(2, 'HOST_HOSTINGER', 'HOSTINGER', 'Ceci est un autre hébergeur'),
(3, 'HOST_GODADDY', 'GODADDY', 'Ceci est un troisième hébergeur'),
(4, 'HOST_HOSTGATOR', 'HOSTGATOR', 'Ceci est un quatrième hébergeur'),
(5, 'HOST_NETWORK_SOLUTIONS', 'NETWORK SOLUTIONS', 'Ceci est un cinquième hébergeur'),
(6, 'HOST_A2_HOSTING', 'A2 HOSTING', 'Ceci est un sixième hébergeur'),
(7, 'HOST_INMOTION', 'INMOTION', 'Ceci est un septième hébergeur'),
(8, 'HOST_WEBHOSTINGPAD', 'WEBHOSTINGPAD', 'Ceci est un huitième hébergeur'),
(9, 'HOST_007HEBERGEMENT', '007HEBERGEMENT', 'Ceci est un neuvième hébergeur'),
(10, 'HOST_PLANETHOSTER', 'PLANETHOSTER', 'Ceci est un dixième hébergeur'),
(11, 'HOST_OVH', 'OVH', 'Ceci est un onzième hébergeur'),
(12, 'HOST_LWS', 'LWS', 'Ceci est un douzième hébergeur');

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `lastpass_folder` varchar(255) NOT NULL,
  `link_mock_ups` varchar(255) NOT NULL,
  `managed_server` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `host_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `code`, `lastpass_folder`, `link_mock_ups`, `managed_server`, `notes`, `host_id`, `customer_id`) VALUES
(1, 'Dyson', 'PROJECT_DYSON', 'Clients/Dyson/Extranet', 'https://adobe-xd.com//dyson-extranet', 0, 'Site web pour la société Dyson', 1, 1),
(2, 'Crédit agricole', 'PROJECT_CREDIT_AGRICOLE', 'Clients/creditAgricole/Extranet', 'https://adobe-xd.com//creditAgricole-extranet', 1, 'Site web pour la société Crédit Agricole', 1, 2),
(3, 'Citroen', 'PROJECT_CITROEN', 'Clients/Citroen/Extranet', 'https://adobe-xd.com//Citroen-extranet', 0, 'Site web pour la société Citroen', 1, 3),
(4, 'Philips', 'PROJECT_PHILIPS', 'Clients/Philips/Extranet', 'https://adobe-xd.com//Philips-extranet', 0, 'Site web pour la société Philips', 4, 4),
(5, 'Orpi', 'PROJECT_ORPI', 'Clients/Orpi/Extranet', 'https://adobe-xd.com//Orpi-extranet', 1, 'Site web pour la société Orpi', 5, 4),
(6, 'Saint-Gobain', 'PROJECT_SAINT_GOBAIN', 'Clients/Saint-Gobain/Extranet', 'https://adobe-xd.com//Saint-Gobain-extranet', 0, 'Site web pour la société Saint-Gobain', 6, 4),
(7, 'PMU', 'PROJECT_PMU', 'Clients/PMU/Extranet', 'https://adobe-xd.com//PMU-extranet', 1, 'Site web pour la société PMU', 7, 7),
(8, 'Poclain Hydraulics', 'PROJECT_POCLAIN_HYDRAULICS', 'Clients/poclainHydraulics/Extranet', 'https://adobe-xd.com//poclainHydraulics-extranet', 1, 'Site web pour la société Poclain Hydraulics', 8, 8),
(9, 'Cofidis', 'PROJECT_COFIDIS', 'Clients/Cofidis/Extranet', 'https://adobe-xd.com//Cofidis-extranet', 0, 'Site web pour la société Cofidis', 9, 9),
(10, 'Ipsec', 'PROJECT_IPSEC', 'Clients/Ipsec/Extranet', 'https://adobe-xd.com//Ipsec-extranet', 1, 'Site web pour la société Ipsec', 10, 10),
(11, 'Eads', 'PROJECT_EADS', 'Clients/Eads/Extranet', 'https://adobe-xd.com//Eads-extranet', 1, 'Site web pour la société Eads', 11, 11),
(12, 'B&B Hotels', 'PROJECT_B&B_HOTELS', 'Clients/B&B_Hotels/Extranet', 'https://adobe-xd.com//B&B_Hotels-extranet', 1, 'Site web pour la société B&B_Hotels', 12, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `environment`
--
ALTER TABLE `environment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Index pour la table `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `host_id` (`host_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `environment`
--
ALTER TABLE `environment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `host`
--
ALTER TABLE `host`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`host_id`) REFERENCES `host` (`id`);

--
-- Contraintes pour la table `environment`
--
ALTER TABLE `environment`
  ADD CONSTRAINT `environment_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `host` (`id`),
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
