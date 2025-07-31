-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 07:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'armaghan', '$2y$10$NYupuwV2ikMn03NXc1EkqO9bwvDz3lzZlPReNs2KQuE5kLJJz0N2q', '2025-07-23 23:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `content_history`
--

CREATE TABLE `content_history` (
  `id` int(11) NOT NULL,
  `content_key` varchar(255) NOT NULL,
  `old_content_text` text DEFAULT NULL,
  `new_content_text` text NOT NULL,
  `changed_by` varchar(255) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_history`
--

INSERT INTO `content_history` (`id`, `content_key`, `old_content_text`, `new_content_text`, `changed_by`, `changed_at`) VALUES
(1, 'faqs_a1', 'FortiFund is an innovative platform offering financial solutions, including a unique matchmaking service and other upcoming features designed to help individuals and businesses thrive.', 'abc', 'armaghan', '2025-07-31 04:30:21'),
(2, 'faqs_a1', 'abc', 'FortiFund is an innovative platform offering financial solutions, including a unique matchmaking service and other upcoming features designed to help individuals and businesses thrive.', 'armaghan (Redo)', '2025-07-31 04:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `main_file_content`
--

CREATE TABLE `main_file_content` (
  `id` int(11) NOT NULL,
  `content_type` enum('image','video','text') NOT NULL,
  `file_path` varchar(512) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `alt_text` text DEFAULT NULL,
  `content_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_file_content`
--

INSERT INTO `main_file_content` (`id`, `content_type`, `file_path`, `description`, `section`, `alt_text`, `content_text`, `created_at`, `last_updated`) VALUES
(1, 'image', 'uploads/688a3b858a2bd8.64168062.png', 'Logo in navbar', 'navbar', 'image not found', '', '2025-07-30 12:11:06', '2025-07-30 15:34:29'),
(2, 'image', 'uploads/688a25ca1a6472.22960368.webp', 'Hero section - Two professionals', 'hero', 'Two professionals', '', '2025-07-30 12:11:06', '2025-07-30 14:01:46'),
(3, 'image', 'uploads/688a2623b1e378.92605534.jpg', 'Client logo - DBL Partners', 'client_logos', 'DBL Partners', '', '2025-07-30 12:11:06', '2025-07-30 14:03:15'),
(4, 'image', 'image/conversica.jpg', 'Client logo - Conversica', 'client_logos', 'Conversica', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(5, 'image', 'image/beiGene.png', 'Client logo - BeiGene', 'client_logos', 'BeiGene', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(6, 'image', 'image/NFX.jpg', 'Client logo - NFX', 'client_logos', 'NFX', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(7, 'image', 'image/Y combinatorss.JPG', 'Client logo - Y Combinators', 'client_logos', 'Y Combinators', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(8, 'image', 'image/floodgate.JPG', 'Client logo - Floodgate', 'client_logos', 'Floodgate', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(9, 'image', 'image/lime.JPG', 'Client logo - Lime', 'client_logos', 'Lime', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(10, 'image', 'image/foundation.JPG', 'Client logo - Foundation', 'client_logos', 'Foundation', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(11, 'image', 'image/em.JPG', 'Client logo - EM', 'client_logos', 'EM', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(12, 'image', 'image/logo 1.jpg', 'Client logo - Logo 1', 'client_logos', 'Logo 1', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(13, 'image', 'image/thistle.JPG', 'Client logo - Thistle', 'client_logos', 'Thistle', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(14, 'image', 'image/Astranis.jpg', 'Client logo - Astranis', 'client_logos', 'Astranis', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(15, 'image', 'image/talent meet tech.jpg', 'Talent Meets Tech section', 'talent_tech', 'Talent Meets Tech', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(16, 'image', 'image/person 1.webp', 'Smiling woman in Built to Scale section', 'person1', 'Smiling woman', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(17, 'image', 'uploads/688a2316a6c3d8.07416325.webp', 'Man looking up in Built to Scale section', 'person2', 'Man looking up', '', '2025-07-30 12:11:06', '2025-07-30 13:50:14'),
(18, 'image', 'image/person 3.webp', 'Woman on tablet in Built to Scale section', 'person3', 'Woman on tablet', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(19, 'image', 'uploads/688a238b257d71.33230649.webp', 'Agriculture industry', 'industries', 'Agriculture', '', '2025-07-30 12:11:06', '2025-07-30 13:52:11'),
(20, 'image', 'image/automotive.jfif', 'Automotive industry', 'industries', 'Automotive', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(21, 'image', 'image/construction.jfif', 'Construction industry', 'industries', 'Construction', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(22, 'image', 'image/finance.webp', 'Financial industry', 'industries', 'Financial', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(23, 'image', 'image/healthcare.jfif', 'Healthcare industry', 'industries', 'Healthcare', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(24, 'image', 'image/hospitality.webp', 'Hospitality industry', 'industries', 'Hospitality', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(25, 'image', 'image/manufacturing.webp', 'Manufacturing industry', 'industries', 'Manufacturing', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(26, 'image', 'image/non profit.jpg', 'Non-Profit industry', 'industries', 'Non-Profit', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(27, 'image', 'image/professional services.webp', 'Professional Services industry', 'industries', 'Professional Services', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(28, 'image', 'image/technology.webp', 'Technology industry', 'industries', 'Technology', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(29, 'image', 'image/life science.png', 'Life Science industry', 'industries', 'Life Science', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(30, 'image', 'image/wholesale.jfif', 'Cannabis industry', 'industries', 'Cannabis', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(31, 'image', 'uploads/688a26867d38a5.52203964.jpg', 'Latest from Newfront - Young Accounts', 'latest_articles', 'Young Accounts', '', '2025-07-30 12:11:06', '2025-07-30 14:04:54'),
(32, 'image', 'image/obr.png', 'Latest from Newfront - Insights', 'latest_articles', 'Insights', NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(33, 'image', 'uploads/688a26aad41795.83945880.webp', 'Latest from Newfront - Leadership', 'latest_articles', 'Leadership', '', '2025-07-30 12:11:06', '2025-07-30 14:05:30'),
(34, 'video', 'uploads/688af12a2d3d49.19876935.mp4', 'Charting a New Course section', 'charting', '', 'ggg', '2025-07-30 12:11:06', '2025-07-31 04:29:30'),
(35, 'video', 'video/insurance.mp4', 'Background video in Our Approach section', 'approach', NULL, NULL, '2025-07-30 12:11:06', '2025-07-28 14:11:22'),
(36, 'image', '', 'Main hero heading', 'hero_heading', '', 'abccccccccccccccccccc', '2025-07-30 12:11:06', '2025-07-30 14:06:42'),
(37, 'text', '', 'Hero subheading', 'hero_subheading', 'thiiissssssss is changed text', 'Human Progress', '2025-07-30 12:11:06', '2025-07-30 14:41:42'),
(38, 'text', '', 'Hero subtext', 'hero_text', NULL, 'With elite insurance expertise empowered by breakthrough technology. Redefined for the modern finance landscape of the 21st centuries', '2025-07-30 12:11:06', '2025-07-30 14:21:20'),
(39, 'text', '', 'Section title', 'derisking_title', NULL, 'De Risking Financing', '2025-07-30 12:11:06', '2025-07-30 15:35:55'),
(40, 'text', '', 'Section description', 'derisking_desc', NULL, 'The alternative finance space is fast-moving, fragmented, and full of risk — but it doesn\'t have to be. FortiFund was built by experts who know the game inside and out. We help brokerages reduce risk at every step', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(41, 'text', '', 'Section title', 'approach_title', NULL, 'Our approach', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(42, 'text', '', 'Section description', 'approach_desc', NULL, 'With any structural change, it\'s critical to ensure premium savings are commensurate with the additional risk assumed, at the very least. We lean in to help you assess and weigh your options.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(43, 'text', '', 'Approach point 1', 'approach_point1', NULL, 'this is the way where alter financing works', '2025-07-30 12:11:06', '2025-07-30 14:40:55'),
(44, 'text', '', 'Approach point 1 description', 'approach_point1_desc', NULL, 'admin', '2025-07-30 12:11:06', '2025-07-30 15:38:36'),
(45, 'text', '', 'Approach point 2', 'approach_point2', NULL, 'Outline the possibilities', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(46, 'text', '', 'Approach point 2 description', 'approach_point2_desc', NULL, 'While the landscape is constantly changing, we deeply understand the opportunities and propose alternative risk financing solutions aligned to risk management needs along with potential utilization scenarios.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(47, 'text', '', 'Approach point 3', 'approach_point3', NULL, 'Analyze the options', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(48, 'text', '', 'Approach point 3 description', 'approach_point3_desc', NULL, 'We quantify both the fixed and frictional costs associated with the formation of captive or other structures, articulate funding requirements, and outline structural opportunities.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(49, 'text', '', 'Approach point 4', 'approach_point4', NULL, 'Propose optimal strategy', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(50, 'text', '', 'Approach point 4 description', 'approach_point4_desc', NULL, 'Finally, we make a recommendation and lay out the best possible structure alternatives, tailored to your business needs and risk appetite.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(51, 'text', '', 'Section title', 'charting_title', NULL, 'Charting a New Course', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(52, 'text', '', 'Section description', 'charting_desc', NULL, 'We\'re bringing advanced technology to an antiquated industry, fostering transparency, convenience, and optimized client outcomes.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(53, 'text', '', 'Section title', 'numbers_title', NULL, 'By the Numbers', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(54, 'text', '', 'Section description', 'numbers_desc', NULL, 'The data speaks for itself. From our large roster of established and growing clients to our stellar client retention rate—we build relationships that last.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(55, 'text', '', 'Stat 1 value', 'stat1_value', NULL, '$3.1B', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(56, 'text', '', 'Stat 1 label', 'stat1_label', NULL, 'in annual premiums placed', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(57, 'text', '', 'Stat 2 value', 'stat2_value', NULL, '~20%', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(58, 'text', '', 'Stat 2 label', 'stat2_label', NULL, 'U.S. unicorns represented', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(59, 'text', '', 'Stat 3 value', 'stat3_value', NULL, '500+', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(60, 'text', '', 'Stat 3 label', 'stat3_label', NULL, 'public company experience', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(61, 'text', '', 'Section title', 'talent_title', NULL, 'Talent Meets Tech', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(62, 'text', '', 'Section description', 'talent_desc', NULL, 'Technology should enhance human expertise not replace it. By equipping our elite insurance talent with tech, we\'re creating a competitive edge for our people and clients.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(63, 'text', '', 'Section title', 'scale_title', NULL, 'Built to Scale', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(64, 'text', '', 'Section description', 'scale_desc', NULL, 'Our highly-tenured team of experts support clients through their growth and business evolution at a variety of milestones with solutions that fit their needs—from early stage to mature enterprise.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(65, 'text', '', 'Section title', 'know_title', NULL, 'Get to Know Newfront', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(66, 'text', '', 'Section title', 'ai_title', NULL, 'Using AI to Improve the Client Experience', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(67, 'text', '', 'Section description', 'ai_desc', NULL, 'Newfront is building breakthrough AI to drive client insights and free our teams to do the strategic work they were built to do.', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(68, 'text', '', 'Section title', 'industries_title', NULL, 'Explore Our Industries and Services', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(69, 'text', '', 'Article title 1', 'article1_title', NULL, 'Young Accounts as an Employee Benefits Broker', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(70, 'text', '', 'Article 1 description', 'article1_desc', NULL, 'The process of hiring a broker for your company\'s employee benefits plan can feel a bit like dating...', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(71, 'text', '', 'Article title 2', 'article2_title', NULL, 'Navigating Your One Big Renewal (OBR)', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(72, 'text', '', 'Article 2 description', 'article2_desc', NULL, 'One Big Renewal (OBR) is an annual process where an employer must renew or update their employee benefits plans...', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(73, 'text', '', 'Article title 3', 'article3_title', NULL, 'Sequoia & Evergreen Business: Why People Culture and Plan Sponsors Benefit From...', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(74, 'text', '', 'Article 3 description', 'article3_desc', NULL, 'While traditional insurance brokers primarily focus on simply placing insurance, Evergreen Insurance Services...', '2025-07-30 12:11:06', '2025-07-28 14:11:23'),
(75, 'text', NULL, 'Hero Section Heading', 'Main hero', NULL, 'De-Risking', '2025-07-30 14:51:33', '2025-07-30 15:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `media_files`
--

CREATE TABLE `media_files` (
  `media_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(512) NOT NULL,
  `media_type` enum('image','video','document','audio') NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `thumbnail_path` varchar(512) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_files`
--

INSERT INTO `media_files` (`media_id`, `filename`, `file_path`, `media_type`, `alt_text`, `thumbnail_path`, `uploaded_at`) VALUES
(2, 'insurance.mp4', 'video/insurance.mp4', 'video', 'Background video of insurance concepts', 'video/insurance_thumb.jpg', '2025-07-28 05:23:35'),
(3, 'person1.webp', 'image/person 1.webp', 'image', 'Smiling woman', NULL, '2025-07-28 05:23:35'),
(4, 'person3.webp', 'image/person 3.webp', 'image', 'Woman on tablet', NULL, '2025-07-28 05:23:35'),
(5, 'person2.webp', 'image/person 2.webp', 'image', 'Man looking up', NULL, '2025-07-28 05:23:35'),
(6, 'agriculture.jfif', 'image/agriculture.jfif', 'image', 'Agriculture industry', NULL, '2025-07-28 05:23:35'),
(7, 'acc.jpg', 'image/acc.jpg', 'image', 'Young Accounts blog cover', NULL, '2025-07-28 05:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `media_history`
--

CREATE TABLE `media_history` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`new_data`)),
  `changed_by` varchar(100) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_history`
--

INSERT INTO `media_history` (`id`, `media_id`, `old_data`, `new_data`, `changed_by`, `changed_at`) VALUES
(1, 36, '{\"id\":\"36\",\"content_type\":\"text\",\"file_path\":\"\",\"description\":\"Main hero heading\",\"section\":\"hero_heading\",\"alt_text\":\"\",\"content_text\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaa\",\"last_updated\":\"2025-07-29 11:42:06\"}', '{\"section\":\"hero_heading\",\"description\":\"Main hero heading\",\"file_path\":\"\"}', '', '2025-07-29 18:52:41'),
(2, 36, '{\"id\":\"36\",\"content_type\":\"text\",\"file_path\":\"\",\"description\":\"Main hero heading\",\"section\":\"hero_heading\",\"alt_text\":\"\",\"content_text\":\"De-Risking Heading\",\"last_updated\":\"2025-07-29 11:52:41\"}', '{\"section\":\"hero_heading\",\"description\":\"Main hero heading\",\"file_path\":\"\"}', '', '2025-07-30 11:26:45'),
(3, 37, '{\"id\":\"37\",\"content_type\":\"text\",\"file_path\":\"\",\"description\":\"Hero subheading\",\"section\":\"hero_subheading\",\"alt_text\":null,\"content_text\":\"Human Progress\",\"last_updated\":\"2025-07-28 07:11:23\"}', '{\"section\":\"hero_subheading\",\"description\":\"Hero subheading\",\"file_path\":\"\"}', '', '2025-07-30 11:27:41'),
(4, 37, '{\"id\":\"37\",\"content_type\":\"text\",\"file_path\":\"\",\"description\":\"Hero subheading\",\"section\":\"hero_subheading\",\"alt_text\":\"thiiissssssss is changed text\",\"content_text\":\"HUMAN PROGRESS\",\"last_updated\":\"2025-07-30 04:27:41\"}', '{\"section\":\"hero_subheading\",\"description\":\"Hero subheading\",\"file_path\":\"\"}', '', '2025-07-30 11:28:13'),
(5, 1, '{\"id\":\"1\",\"content_type\":\"image\",\"file_path\":\"uploads/forti fund.PNG\",\"description\":\"Logo in navbar\",\"section\":\"navbar\",\"alt_text\":\"a\",\"content_text\":\"\",\"last_updated\":\"2025-07-29 11:41:32\"}', '{\"section\":\"navbar\",\"description\":\"Logo in navbar\",\"file_path\":\"uploads/forti fund.PNG\"}', '', '2025-07-30 11:32:53'),
(6, 1, '{\"id\":\"1\",\"content_type\":\"image\",\"file_path\":\"uploads/forti fund.PNG\",\"description\":\"Logo in navbar\",\"section\":\"navbar\",\"alt_text\":\"\",\"content_text\":\"\",\"last_updated\":\"2025-07-30 04:32:53\"}', '{\"section\":\"navbar\",\"description\":\"Logo in navbar\",\"file_path\":\"uploads/forti fund.PNG\"}', '', '2025-07-30 11:33:37'),
(7, 1, '{\"id\":1,\"content_type\":\"image\",\"file_path\":\"uploads\\/Capture.PNG\",\"description\":\"Logo in navbar\",\"section\":\"navbar\",\"alt_text\":\"image not found\",\"content_text\":\"\",\"created_at\":\"2025-07-30 05:11:06\",\"last_updated\":\"2025-07-30 04:33:37\"}', '{\"section\":\"navbar\",\"description\":\"Logo in navbar\",\"file_path\":\"uploads\\/688a19021d7da5.14619879.jpg\",\"alt_text\":\"image not found\",\"content_text\":\"\"}', 'armaghan', '2025-07-30 13:07:14'),
(8, 1, '{\"id\":1,\"content_type\":\"image\",\"file_path\":\"uploads\\/688a19021d7da5.14619879.jpg\",\"description\":\"Logo in navbar\",\"section\":\"navbar\",\"alt_text\":\"image not found\",\"content_text\":\"\",\"created_at\":\"2025-07-30 05:11:06\",\"last_updated\":\"2025-07-30 06:07:14\"}', '{\"section\":\"navbar\",\"description\":\"Logo in navbar\",\"file_path\":\"uploads\\/688a191dd6ba55.69918947.png\",\"alt_text\":\"image not found\",\"content_text\":\"\"}', 'armaghan', '2025-07-30 13:07:41'),
(9, 2, '{\"id\":2,\"content_type\":\"image\",\"file_path\":\"image\\/upimg.webp\",\"description\":\"Hero section - Two professionals\",\"section\":\"hero\",\"alt_text\":\"Two professionals\",\"content_text\":null,\"created_at\":\"2025-07-30 05:11:06\",\"last_updated\":\"2025-07-28 07:11:22\"}', '{\"section\":\"hero\",\"description\":\"Hero section - Two professionals\",\"file_path\":\"uploads\\/688a19d6c0d170.01864460.jpg\",\"alt_text\":\"Two professionals\",\"content_text\":\"\"}', 'armaghan', '2025-07-30 13:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `preorders`
--

CREATE TABLE `preorders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `num_employees` int(11) NOT NULL,
  `help_option` varchar(50) NOT NULL,
  `additional_details` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `website_content`
--

CREATE TABLE `website_content` (
  `id` int(11) NOT NULL,
  `content_key` varchar(255) NOT NULL,
  `main_heading` varchar(255) DEFAULT NULL,
  `content_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `content_type` varchar(250) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_content`
--

INSERT INTO `website_content` (`id`, `content_key`, `main_heading`, `content_text`, `media_id`, `created_at`, `updated_at`, `content_type`, `file_path`, `image_id`, `video_id`) VALUES
(1, 'faqs_title', 'FAQS', 'FortiFund - Frequently Asked Questions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(2, 'faqs_main_heading', 'FAQS', 'Frequently Asked Questions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(3, 'faqs_q1', 'FAQS', 'What is FortiFund?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(4, 'faqs_a1', 'FAQS', 'FortiFund is an innovative platform offering financial solutions, including a unique matchmaking service and other upcoming features designed to help individuals and businesses thrive.', NULL, '2025-07-24 05:13:23', '2025-07-31 04:31:16', NULL, NULL, NULL, NULL),
(5, 'faqs_q2', 'FAQS', 'How does the matchmaking service work?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(6, 'faqs_a2', 'FAQS', 'Our matchmaking service connects individuals and businesses with relevant financial opportunities and resources, based on their specific needs and goals. We use advanced algorithms to find the best matches.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(7, 'faqs_q3', 'FAQS', 'Is my data secure with FortiFund?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(8, 'faqs_a3', 'FAQS', 'Yes, we prioritize the security of your data. We employ industry-standard encryption and security protocols to protect your personal and financial information.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(9, 'faqs_q4', 'FAQS', 'What kind of solutions does FortiFund offer?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(10, 'faqs_a4', 'FAQS', 'Currently, we offer a matchmaking service. We have exciting upcoming solutions in development, including advanced analytics, personalized financial planning tools, and investment opportunities.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(11, 'faqs_q5', 'FAQS', 'How can I contact customer support?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(12, 'faqs_a5', 'FAQS', 'You can reach our customer support team via the \"Contact Us\" page on our website. We are available during business hours to assist you with any inquiries.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(13, 'faqs_q6', 'FAQS', 'What are the benefits of using FortiFund?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(14, 'faqs_a6_p1', 'FAQS', 'FortiFund helps you streamline your financial journey by connecting you with tailored solutions. Our platform aims to save you time and effort in finding the right opportunities.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(15, 'faqs_a6_p2', 'FAQS', 'We provide a secure and efficient environment to explore, connect, and grow your financial standing.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(16, 'faqs_q7', 'FAQS', 'Can I use FortiFund on my mobile device?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(17, 'faqs_a7', 'FAQS', 'Yes, our website is fully responsive and optimized for mobile devices, allowing you to access all features seamlessly from your smartphone or tablet.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(18, 'faqs_q8', 'FAQS', 'What is the \"Pre-Order\" option for?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(19, 'faqs_a8', 'FAQS', 'The \"Pre-Order\" option allows you to express early interest and potentially gain exclusive access or benefits for our upcoming solutions before they are officially launched.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(20, 'faqs_q9', 'FAQS', 'How often are new solutions launched?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(21, 'faqs_a9', 'FAQS', 'We are continuously working on new and innovative financial solutions. We aim to launch new features periodically, and you can stay updated through our announcements and newsletters.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(22, 'faqs_q10', 'FAQS', 'Do you offer a free trial for any services?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(23, 'faqs_a10', 'FAQS', 'Specific trial offers vary by service. Please check the details on our \"Pricing\" or \"Our Solutions\" pages for information on free trials or demo opportunities.', NULL, '2025-07-24 05:13:23', '2025-07-24 07:44:32', NULL, NULL, NULL, NULL),
(24, 'faqs_q11', 'FAQS', 'What information is required to register?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(25, 'faqs_a11', 'FAQS', 'Basic registration typically requires your name, email address, and creation of a secure password. Additional information may be requested depending on the specific services you wish to utilize.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:55:04', NULL, NULL, NULL, NULL),
(26, 'faqs_q12', 'FAQS', 'How do I resolve technical issues?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(27, 'faqs_a12_p1', 'FAQS', 'If you encounter any technical issues, first try clearing your browser cache and cookies, or try a different browser.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(28, 'faqs_a12_p2', 'FAQS', 'If the problem persists, please contact our support team via the \"Contact Us\" page with a detailed description of the issue and any error messages you received.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(29, 'faqs_q13', 'FAQS', 'What are the system requirements for using FortiFund?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(30, 'faqs_a13_p1', 'FAQS', 'Our platform is web-based, so you primarily need a modern web browser and a stable internet connection. For optimal experience, we recommend:', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(31, 'faqs_a13_li1', 'FAQS', 'Using the latest versions of Chrome, Firefox, Safari, or Edge.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(32, 'faqs_a13_li2', 'FAQS', 'A screen resolution of at least 1280x800 pixels.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(33, 'faqs_a13_li3', 'FAQS', 'Enabling JavaScript and cookies in your browser.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(34, 'faqs_a13_p2', 'FAQS', 'There are no specific operating system requirements as long as you can run a compatible browser.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(35, 'faqs_q14', 'FAQS', 'How can I provide feedback or suggestions?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(36, 'faqs_a14', 'FAQS', 'We welcome your feedback! You can provide suggestions directly through the \"Contact Us\" form on our website, or by emailing our support team.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(37, 'faqs_q15', 'FAQS', 'Is FortiFund available internationally?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(38, 'faqs_a15', 'FAQS', 'FortiFund is currently focused on specific regions, but we are continuously evaluating expansion into new markets. Please check our website or contact support for current availability in your country.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(39, 'matchmaking_title', 'MATCHMAKING SECTION', 'FortiFund - Matchmaking Solution', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(40, 'matchmaking_main_heading', 'MATCHMAKING SECTION', 'Our Matchmaking Solution', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(41, 'matchmaking_intro', 'MATCHMAKING SECTION', 'FortiFund\'s matchmaking service intelligently connects individuals and businesses with the most relevant financial opportunities and resources. We streamline the process of finding ideal partnerships and solutions.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(42, 'matchmaking_features_heading', 'MATCHMAKING SECTION', 'Key Features', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(43, 'matchmaking_feature1_title', 'MATCHMAKING SECTION', 'Smart Algorithmic Matching', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(44, 'matchmaking_feature1_description', 'MATCHMAKING SECTION', 'Our advanced algorithms analyze your profile and requirements to suggest the most suitable matches.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(45, 'matchmaking_feature2_title', 'MATCHMAKING SECTION', 'Personalized Recommendations', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(46, 'matchmaking_feature2_description', 'MATCHMAKING SECTION', 'Receive tailored suggestions that align with your financial goals and preferences.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(47, 'matchmaking_feature3_title', 'MATCHMAKING SECTION', 'Secure Communication', NULL, '2025-07-24 05:13:23', '2025-07-29 16:19:42', NULL, NULL, NULL, NULL),
(48, 'matchmaking_feature3_description', 'MATCHMAKING SECTION', 'Connect and communicate with potential matches through a secure and confidential platform.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(49, 'matchmaking_feature4_title', 'MATCHMAKING SECTION', 'Comprehensive Network', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(50, 'matchmaking_feature4_description', 'MATCHMAKING SECTION', 'Access a broad network of financial institutions, investors, and business opportunities.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(51, 'matchmaking_cta', 'MATCHMAKING SECTION', 'Ready to find your perfect financial match? Join FortiFund today!', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(52, 'upcoming_solutions_page_title', 'UPCOMING SOLUTIONS SECTION', 'FortiFund - Upcoming Solutions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(53, 'upcoming_solutions_main_heading', 'UPCOMING SOLUTIONS SECTION', 'Revolutionizing Your Future: Our Upcoming Solutions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(54, 'upcoming_solutions_intro_paragraph', 'UPCOMING SOLUTIONS SECTION', 'At FortiFund, innovation is at our core. We are constantly developing cutting-edge financial solutions designed to empower you with greater control and opportunities. Get a sneak peek into what\'s coming next!', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(55, 'upcoming_solutions_subheading', 'UPCOMING SOLUTIONS SECTION', 'Discover What\'s Next', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(56, 'upcoming_solutions_feature1_title', 'UPCOMING SOLUTIONS SECTION', 'AI-Powered Financial Insights', NULL, '2025-07-24 05:13:23', '2025-07-29 16:19:09', NULL, NULL, NULL, NULL),
(57, 'upcoming_solutions_feature1_description', 'UPCOMING SOLUTIONS SECTION', 'Leverage artificial intelligence to gain predictive insights, optimize investments, and make smarter financial decisions.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(58, 'upcoming_solutions_feature2_title', 'UPCOMING SOLUTIONS SECTION', 'Decentralized Finance (DeFi) Integrations', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(59, 'upcoming_solutions_feature2_description', 'UPCOMING SOLUTIONS SECTION', 'Explore seamless access to DeFi protocols, enabling new avenues for lending, borrowing, and yield generation.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(60, 'upcoming_solutions_feature3_title', 'UPCOMING SOLUTIONS SECTION', 'Personalized Investment Portfolios', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(61, 'upcoming_solutions_feature3_description', 'UPCOMING SOLUTIONS SECTION', 'Receive custom-tailored investment strategies and portfolio management, aligned with your risk tolerance and financial goals.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(62, 'upcoming_solutions_feature4_title', 'UPCOMING SOLUTIONS SECTION', 'Interactive Financial Planning Tools', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(63, 'upcoming_solutions_feature4_description', 'UPCOMING SOLUTIONS SECTION', 'Utilize intuitive tools for budgeting, debt management, and retirement planning, making financial growth accessible.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(64, 'upcoming_solutions_call_to_action', 'UPCOMING SOLUTIONS SECTION', 'Be among the first to experience these innovations! Pre-order or sign up for early access notifications today.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(65, 'contact_us_page_title', 'CONTACT US SECTION', 'FortiFund - Contact Us', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(66, 'contact_us_heading', 'CONTACT US SECTION', 'Get In Touch With FortiFund', NULL, '2025-07-24 05:13:23', '2025-07-29 15:50:10', NULL, NULL, NULL, NULL),
(67, 'contact_us_intro_text', 'CONTACT US SECTION', 'We\'re here to help! Whether you have questions about our services, need support, or want to explore partnership opportunities, feel free to reach out to us through the following channels.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(68, 'contact_us_primary_contact_heading', 'CONTACT US SECTION', 'Primary Contact Methods', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(69, 'contact_us_email_heading', 'CONTACT US SECTION', 'Email Support', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(70, 'contact_us_email_description', 'CONTACT US SECTION', 'For general inquiries, detailed questions, or support requests, our team is ready to assist you via email. We aim to respond within 24-48 business hours.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(71, 'contact_us_email_address', 'CONTACT US SECTION', 'support@fortifund.com', NULL, '2025-07-24 05:13:23', '2025-07-28 12:16:00', NULL, NULL, NULL, NULL),
(72, 'contact_us_call_back_heading', 'CONTACT US SECTION', 'Request a Call Back', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(73, 'contact_us_call_back_description', 'CONTACT US SECTION', 'Prefer to speak with us directly? Fill out this short form, and one of our representatives will call you back at your convenience.', NULL, '2025-07-24 05:13:23', '2025-07-28 07:34:17', NULL, NULL, NULL, NULL),
(74, 'contact_us_request_call_button', 'CONTACT US SECTION', 'Request a Call', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(75, 'modal_call_back_title', 'CONTACT US SECTION', 'Request a Call Back', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(76, 'modal_label_your_name', 'CONTACT US SECTION', 'Your Name', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(77, 'modal_label_phone_number', 'CONTACT US SECTION', 'Phone Number', NULL, '2025-07-24 05:13:23', '2025-07-29 15:50:46', NULL, NULL, NULL, NULL),
(78, 'modal_label_email', 'CONTACT US SECTION', 'Email', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(79, 'modal_label_optional', 'CONTACT US SECTION', 'Optional', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(80, 'modal_label_your_message', 'CONTACT US SECTION', 'Your Message', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(81, 'modal_submit_request_button', 'CONTACT US SECTION', 'Submit Request', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(82, 'preorder_page_title', 'PREORDER SECTION', 'FortiFund - Pre-order Solutions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(83, 'preorder_heading', 'PREORDER SECTION', 'Pre-order Our Next-Gen Solutions', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(84, 'preorder_subheading', 'PREORDER SECTION', 'Express your interest and get early access to our revolutionary financial tools and services designed for your future success.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(85, 'preorder_label_first_name', 'PREORDER SECTION', 'First Name', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(86, 'preorder_label_last_name', 'PREORDER SECTION', 'Last Name', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(87, 'preorder_label_job_title', 'PREORDER SECTION', 'Job Title', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(88, 'preorder_label_company_name', 'PREORDER SECTION', 'Company Name', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(89, 'preorder_label_phone_number', 'PREORDER SECTION', 'Phone Number', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(90, 'preorder_label_email', 'PREORDER SECTION', 'Work Email', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(91, 'preorder_label_industry', 'PREORDER SECTION', 'Industry', NULL, '2025-07-24 05:13:23', '2025-07-29 16:16:19', NULL, NULL, NULL, NULL),
(92, 'preorder_option_please_select', 'PREORDER SECTION', 'Please select...', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(93, 'preorder_option_finance', 'PREORDER SECTION', 'Finance', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(94, 'preorder_option_technology', 'PREORDER SECTION', 'Technology', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(95, 'preorder_option_healthcare', 'PREORDER SECTION', 'Healthcare', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(96, 'preorder_option_retail', 'PREORDER SECTION', 'Retail', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(97, 'preorder_option_manufacturing', 'PREORDER SECTION', 'Manufacturing', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(98, 'preorder_option_other', 'PREORDER SECTION', 'Other', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(99, 'preorder_label_num_employees', 'PREORDER SECTION', 'Number of Employees', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(100, 'preorder_legend_how_can_we_help', 'PREORDER SECTION', 'How can we help your organization?', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(101, 'preorder_radio_business_insurance', 'PREORDER SECTION', 'Business Insurance', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(102, 'preorder_radio_employee_benefits', 'PREORDER SECTION', 'Employee Benefits', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(103, 'preorder_radio_retirement_services', 'PREORDER SECTION', 'Retirement Services', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(104, 'preorder_radio_hr_services', 'PREORDER SECTION', 'HR Services', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(105, 'preorder_radio_personal_lines', 'PREORDER SECTION', 'Personal Lines', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(106, 'preorder_radio_wholesale_benefits', 'PREORDER SECTION', 'Wholesale Benefits', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(107, 'preorder_radio_asset_protection', 'PREORDER SECTION', 'Asset Protection', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(108, 'preorder_label_additional_details', 'PREORDER SECTION', 'Additional Details / Specific Needs (Optional)', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(109, 'preorder_submit_button_text', 'PREORDER SECTION', 'Submit Pre-order Request', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(110, 'preorder_footer_text_part1', 'PREORDER SECTION', 'By clicking \"Submit\", you agree to FortiFund\'s', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(111, 'preorder_footer_link_terms_privacy', 'PREORDER SECTION', 'Terms of Use and Privacy Policy', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(112, 'preorder_footer_text_part2', 'PREORDER SECTION', 'and to receive marketing communications. For information about our privacy practices, please review our', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(113, 'preorder_footer_link_notice_collection', 'PREORDER SECTION', 'Notice at Collection', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(114, 'preorder_footer_text_part3', 'PREORDER SECTION', 'You may adjust your', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(115, 'preorder_footer_link_cookie_preferences', 'PREORDER SECTION', 'Cookie Preferences', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(116, 'preorder_footer_recaptcha_text_part1', 'PREORDER SECTION', 'This site is protected by reCAPTCHA and the Google', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(117, 'preorder_footer_recaptcha_link_privacy', 'PREORDER SECTION', 'Privacy Policy', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(118, 'preorder_footer_recaptcha_text_and', 'PREORDER SECTION', 'and', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(119, 'preorder_footer_recaptcha_link_terms', 'PREORDER SECTION', 'Terms of Service', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL),
(120, 'preorder_footer_recaptcha_text_apply', 'PREORDER SECTION', 'apply.', NULL, '2025-07-24 05:13:23', '2025-07-24 06:32:46', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `content_history`
--
ALTER TABLE `content_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_key` (`content_key`);

--
-- Indexes for table `main_file_content`
--
ALTER TABLE `main_file_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `media_history`
--
ALTER TABLE `media_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `preorders`
--
ALTER TABLE `preorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_content`
--
ALTER TABLE `website_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_key` (`content_key`),
  ADD KEY `fk_image` (`image_id`),
  ADD KEY `fk_video` (`video_id`),
  ADD KEY `fk_content_media` (`media_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content_history`
--
ALTER TABLE `content_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_file_content`
--
ALTER TABLE `main_file_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `media_files`
--
ALTER TABLE `media_files`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `media_history`
--
ALTER TABLE `media_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `preorders`
--
ALTER TABLE `preorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_content`
--
ALTER TABLE `website_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content_history`
--
ALTER TABLE `content_history`
  ADD CONSTRAINT `content_history_ibfk_1` FOREIGN KEY (`content_key`) REFERENCES `website_content` (`content_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media_history`
--
ALTER TABLE `media_history`
  ADD CONSTRAINT `media_history_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `main_file_content` (`id`);

--
-- Constraints for table `website_content`
--
ALTER TABLE `website_content`
  ADD CONSTRAINT `fk_content_media` FOREIGN KEY (`media_id`) REFERENCES `media_files` (`media_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_image` FOREIGN KEY (`image_id`) REFERENCES `media_files` (`media_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_video` FOREIGN KEY (`video_id`) REFERENCES `media_files` (`media_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
