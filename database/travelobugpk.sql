-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2022 at 05:35 AM
-- Server version: 10.5.17-MariaDB-1:10.5.17+maria~ubu2004
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ot_travelobugpk`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `address1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `selected` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `profile_image`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Demo Admin', 'admin@demo.test', '$2y$10$HWmFKK8DBtaNf.W/3vnR..33xug1XjdCN8AaBC6jtRH4CbbaZ.Yna', 'profile.png', 'Active', NULL, '2022-09-05 07:40:53', '2022-09-05 09:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `title`, `description`, `symbol`, `type_id`, `status`) VALUES
(1, 'Essentials', 'Towels, bed sheets, soap and toilet paper', 'essentials', 1, 'Active'),
(2, 'TV', '', 'tv', 1, 'Active'),
(3, 'Cable TV', '', 'desktop', 1, 'Active'),
(4, 'Air Conditioning ', '', 'air-conditioning', 1, 'Active'),
(5, 'Heating', 'Heating', 'heating', 1, 'Active'),
(6, 'Kitchen', 'Kitchen', 'meal', 1, 'Active'),
(7, 'Internet', 'Internet', 'internet', 1, 'Active'),
(8, 'Gym', 'Gym', 'gym', 1, 'Active'),
(9, 'Elevator in Building', '', 'elevator', 1, 'Active'),
(10, 'Indoor Fireplace', '', 'fireplace', 1, 'Active'),
(11, 'Buzzer/Wireless Intercom', '', 'intercom', 1, 'Active'),
(12, 'Doorman', '', 'doorman', 1, 'Active'),
(13, 'Shampoo', '', 'smoking', 1, 'Active'),
(14, 'Wireless Internet', 'Wireless Internet', 'wifi', 1, 'Active'),
(15, 'Hot Tub', '', 'hot-tub', 1, 'Active'),
(16, 'Washer', 'Washer', 'washer', 1, 'Active'),
(17, 'Pool', 'Pool', 'pool', 1, 'Active'),
(18, 'Dryer', 'Dryer', 'dryer', 1, 'Active'),
(19, 'Breakfast', 'Breakfast', 'cup', 1, 'Active'),
(20, 'Free Parking on Premises', '', 'parking', 1, 'Active'),
(21, 'Family/Kid Friendly', 'Family/Kid Friendly', 'family', 1, 'Active'),
(22, 'Smoking Allowed', '', 'smoking', 1, 'Active'),
(23, 'Suitable for Events', 'Suitable for Events', 'balloons', 1, 'Active'),
(24, 'Pets Allowed', '', 'paw', 1, 'Active'),
(25, 'Pets live on this property', '', 'ok', 1, 'Active'),
(26, 'Wheelchair Accessible', 'Wheelchair Accessible', 'accessible', 1, 'Active'),
(27, 'Smoke Detector', 'Smoke Detector', 'ok', 2, 'Active'),
(28, 'Carbon Monoxide Detector', 'Carbon Monoxide Detector', 'ok', 2, 'Active'),
(29, 'First Aid Kit', '', 'ok', 2, 'Active'),
(30, 'Safety Card', 'Safety Card', 'ok', 2, 'Active'),
(31, 'Fire Extinguisher', 'Essentials', 'ok', 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `amenity_type`
--

CREATE TABLE `amenity_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenity_type`
--

INSERT INTO `amenity_type` (`id`, `name`, `description`) VALUES
(1, 'Common Amenities', ''),
(2, 'Safety Amenities', '');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iban` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `swift_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routing_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_dates`
--

CREATE TABLE `bank_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `heading` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subheading` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `heading`, `subheading`, `image`, `status`) VALUES
(1, 'Welcome to Hotel', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'banner_1.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `bed_type`
--

CREATE TABLE `bed_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bed_type`
--

INSERT INTO `bed_type` (`id`, `name`) VALUES
(1, 'king'),
(2, 'Queen'),
(3, 'Double'),
(4, 'Single'),
(5, 'Sofa bed'),
(6, 'Sofa'),
(7, 'Sofa bed'),
(8, 'Bunk bed'),
(9, 'Air mattress'),
(10, 'Floor mattress'),
(11, 'Toddler bed'),
(12, 'Crib'),
(13, 'Water bed'),
(14, 'Hammock');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Accepted','Pending','Cancelled','Declined','Expired','Processing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `guest` int(11) NOT NULL DEFAULT 0,
  `total_night` int(11) NOT NULL DEFAULT 0,
  `per_night` double NOT NULL DEFAULT 0,
  `custom_price_dates` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` double NOT NULL DEFAULT 0,
  `cleaning_charge` double NOT NULL DEFAULT 0,
  `guest_charge` double NOT NULL DEFAULT 0,
  `service_charge` double NOT NULL DEFAULT 0,
  `security_money` double NOT NULL DEFAULT 0,
  `iva_tax` double NOT NULL DEFAULT 0,
  `accomodation_tax` double NOT NULL DEFAULT 0,
  `host_fee` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `booking_type` enum('request','instant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'request',
  `currency_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_with_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancellation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method_id` int(11) NOT NULL DEFAULT 0,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `declined_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` enum('Host','Guest') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL,
  `field` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `short_name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `short_name`, `name`, `iso3`, `number_code`, `phone_code`) VALUES
(1, 'AF', 'Afghanistan', 'AFG', '4', '93'),
(2, 'AL', 'Albania', 'ALB', '8', '355'),
(3, 'DZ', 'Algeria', 'DZA', '12', '213'),
(4, 'AS', 'American Samoa', 'ASM', '16', '1684'),
(5, 'AD', 'Andorra', 'AND', '20', '376'),
(6, 'AO', 'Angola', 'AGO', '24', '244'),
(7, 'AI', 'Anguilla', 'AIA', '660', '1264'),
(8, 'AQ', 'Antarctica', NULL, NULL, '0'),
(9, 'AG', 'Antigua and Barbuda', 'ATG', '28', '1268'),
(10, 'AR', 'Argentina', 'ARG', '32', '54'),
(11, 'AM', 'Armenia', 'ARM', '51', '374'),
(12, 'AW', 'Aruba', 'ABW', '533', '297'),
(13, 'AU', 'Australia', 'AUS', '36', '61'),
(14, 'AT', 'Austria', 'AUT', '40', '43'),
(15, 'AZ', 'Azerbaijan', 'AZE', '31', '994'),
(16, 'BS', 'Bahamas', 'BHS', '44', '1242'),
(17, 'BH', 'Bahrain', 'BHR', '48', '973'),
(18, 'BD', 'Bangladesh', 'BGD', '50', '880'),
(19, 'BB', 'Barbados', 'BRB', '52', '1246'),
(20, 'BY', 'Belarus', 'BLR', '112', '375'),
(21, 'BE', 'Belgium', 'BEL', '56', '32'),
(22, 'BZ', 'Belize', 'BLZ', '84', '501'),
(23, 'BJ', 'Benin', 'BEN', '204', '229'),
(24, 'BM', 'Bermuda', 'BMU', '60', '1441'),
(25, 'BT', 'Bhutan', 'BTN', '64', '975'),
(26, 'BO', 'Bolivia', 'BOL', '68', '591'),
(27, 'BA', 'Bosnia and Herzegovina', 'BIH', '70', '387'),
(28, 'BW', 'Botswana', 'BWA', '72', '267'),
(29, 'BV', 'Bouvet Island', NULL, NULL, '0'),
(30, 'BR', 'Brazil', 'BRA', '76', '55'),
(31, 'IO', 'British Indian Ocean Territory', NULL, NULL, '246'),
(32, 'BN', 'Brunei Darussalam', 'BRN', '96', '673'),
(33, 'BG', 'Bulgaria', 'BGR', '100', '359'),
(34, 'BF', 'Burkina Faso', 'BFA', '854', '226'),
(35, 'BI', 'Burundi', 'BDI', '108', '257'),
(36, 'KH', 'Cambodia', 'KHM', '116', '855'),
(37, 'CM', 'Cameroon', 'CMR', '120', '237'),
(38, 'CA', 'Canada', 'CAN', '124', '1'),
(39, 'CV', 'Cape Verde', 'CPV', '132', '238'),
(40, 'KY', 'Cayman Islands', 'CYM', '136', '1345'),
(41, 'CF', 'Central African Republic', 'CAF', '140', '236'),
(42, 'TD', 'Chad', 'TCD', '148', '235'),
(43, 'CL', 'Chile', 'CHL', '152', '56'),
(44, 'CN', 'China', 'CHN', '156', '86'),
(45, 'CX', 'Christmas Island', NULL, NULL, '61'),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, NULL, '672'),
(47, 'CO', 'Colombia', 'COL', '170', '57'),
(48, 'KM', 'Comoros', 'COM', '174', '269'),
(49, 'CG', 'Congo', 'COG', '178', '242'),
(50, 'CD', 'Congo, the Democratic Republic of the', 'COD', '180', '242'),
(51, 'CK', 'Cook Islands', 'COK', '184', '682'),
(52, 'CR', 'Costa Rica', 'CRI', '188', '506'),
(53, 'CI', 'Cote D\'Ivoire', 'CIV', '384', '225'),
(54, 'HR', 'Croatia', 'HRV', '191', '385'),
(55, 'CU', 'Cuba', 'CUB', '192', '53'),
(56, 'CY', 'Cyprus', 'CYP', '196', '357'),
(57, 'CZ', 'Czech Republic', 'CZE', '203', '420'),
(58, 'DK', 'Denmark', 'DNK', '208', '45'),
(59, 'DJ', 'Djibouti', 'DJI', '262', '253'),
(60, 'DM', 'Dominica', 'DMA', '212', '1767'),
(61, 'DO', 'Dominican Republic', 'DOM', '214', '1809'),
(62, 'EC', 'Ecuador', 'ECU', '218', '593'),
(63, 'EG', 'Egypt', 'EGY', '818', '20'),
(64, 'SV', 'El Salvador', 'SLV', '222', '503'),
(65, 'GQ', 'Equatorial Guinea', 'GNQ', '226', '240'),
(66, 'ER', 'Eritrea', 'ERI', '232', '291'),
(67, 'EE', 'Estonia', 'EST', '233', '372'),
(68, 'ET', 'Ethiopia', 'ETH', '231', '251'),
(69, 'FK', 'Falkland Islands (Malvinas)', 'FLK', '238', '500'),
(70, 'FO', 'Faroe Islands', 'FRO', '234', '298'),
(71, 'FJ', 'Fiji', 'FJI', '242', '679'),
(72, 'FI', 'Finland', 'FIN', '246', '358'),
(73, 'FR', 'France', 'FRA', '250', '33'),
(74, 'GF', 'French Guiana', 'GUF', '254', '594'),
(75, 'PF', 'French Polynesia', 'PYF', '258', '689'),
(76, 'TF', 'French Southern Territories', NULL, NULL, '0'),
(77, 'GA', 'Gabon', 'GAB', '266', '241'),
(78, 'GM', 'Gambia', 'GMB', '270', '220'),
(79, 'GE', 'Georgia', 'GEO', '268', '995'),
(80, 'DE', 'Germany', 'DEU', '276', '49'),
(81, 'GH', 'Ghana', 'GHA', '288', '233'),
(82, 'GI', 'Gibraltar', 'GIB', '292', '350'),
(83, 'GR', 'Greece', 'GRC', '300', '30'),
(84, 'GL', 'Greenland', 'GRL', '304', '299'),
(85, 'GD', 'Grenada', 'GRD', '308', '1473'),
(86, 'GP', 'Guadeloupe', 'GLP', '312', '590'),
(87, 'GU', 'Guam', 'GUM', '316', '1671'),
(88, 'GT', 'Guatemala', 'GTM', '320', '502'),
(89, 'GN', 'Guinea', 'GIN', '324', '224'),
(90, 'GW', 'Guinea-Bissau', 'GNB', '624', '245'),
(91, 'GY', 'Guyana', 'GUY', '328', '592'),
(92, 'HT', 'Haiti', 'HTI', '332', '509'),
(93, 'HM', 'Heard Island and Mcdonald Islands', NULL, NULL, '0'),
(94, 'VA', 'Holy See (Vatican City State)', 'VAT', '336', '39'),
(95, 'HN', 'Honduras', 'HND', '340', '504'),
(96, 'HK', 'Hong Kong', 'HKG', '344', '852'),
(97, 'HU', 'Hungary', 'HUN', '348', '36'),
(98, 'IS', 'Iceland', 'ISL', '352', '354'),
(99, 'IN', 'India', 'IND', '356', '91'),
(100, 'ID', 'Indonesia', 'IDN', '360', '62'),
(101, 'IR', 'Iran, Islamic Republic of', 'IRN', '364', '98'),
(102, 'IQ', 'Iraq', 'IRQ', '368', '964'),
(103, 'IE', 'Ireland', 'IRL', '372', '353'),
(104, 'IL', 'Israel', 'ISR', '376', '972'),
(105, 'IT', 'Italy', 'ITA', '380', '39'),
(106, 'JM', 'Jamaica', 'JAM', '388', '1876'),
(107, 'JP', 'Japan', 'JPN', '392', '81'),
(108, 'JO', 'Jordan', 'JOR', '400', '962'),
(109, 'KZ', 'Kazakhstan', 'KAZ', '398', '7'),
(110, 'KE', 'Kenya', 'KEN', '404', '254'),
(111, 'KI', 'Kiribati', 'KIR', '296', '686'),
(112, 'KP', 'Korea, Democratic People\'s Republic of', 'PRK', '408', '850'),
(113, 'KR', 'Korea, Republic of', 'KOR', '410', '82'),
(114, 'KW', 'Kuwait', 'KWT', '414', '965'),
(115, 'KG', 'Kyrgyzstan', 'KGZ', '417', '996'),
(116, 'LA', 'Lao People\'s Democratic Republic', 'LAO', '418', '856'),
(117, 'LV', 'Latvia', 'LVA', '428', '371'),
(118, 'LB', 'Lebanon', 'LBN', '422', '961'),
(119, 'LS', 'Lesotho', 'LSO', '426', '266'),
(120, 'LR', 'Liberia', 'LBR', '430', '231'),
(121, 'LY', 'Libyan Arab Jamahiriya', 'LBY', '434', '218'),
(122, 'LI', 'Liechtenstein', 'LIE', '438', '423'),
(123, 'LT', 'Lithuania', 'LTU', '440', '370'),
(124, 'LU', 'Luxembourg', 'LUX', '442', '352'),
(125, 'MO', 'Macao', 'MAC', '446', '853'),
(126, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '807', '389'),
(127, 'MG', 'Madagascar', 'MDG', '450', '261'),
(128, 'MW', 'Malawi', 'MWI', '454', '265'),
(129, 'MY', 'Malaysia', 'MYS', '458', '60'),
(130, 'MV', 'Maldives', 'MDV', '462', '960'),
(131, 'ML', 'Mali', 'MLI', '466', '223'),
(132, 'MT', 'Malta', 'MLT', '470', '356'),
(133, 'MH', 'Marshall Islands', 'MHL', '584', '692'),
(134, 'MQ', 'Martinique', 'MTQ', '474', '596'),
(135, 'MR', 'Mauritania', 'MRT', '478', '222'),
(136, 'MU', 'Mauritius', 'MUS', '480', '230'),
(137, 'YT', 'Mayotte', NULL, NULL, '269'),
(138, 'MX', 'Mexico', 'MEX', '484', '52'),
(139, 'FM', 'Micronesia, Federated States of', 'FSM', '583', '691'),
(140, 'MD', 'Moldova, Republic of', 'MDA', '498', '373'),
(141, 'MC', 'Monaco', 'MCO', '492', '377'),
(142, 'MN', 'Mongolia', 'MNG', '496', '976'),
(143, 'MS', 'Montserrat', 'MSR', '500', '1664'),
(144, 'MA', 'Morocco', 'MAR', '504', '212'),
(145, 'MZ', 'Mozambique', 'MOZ', '508', '258'),
(146, 'MM', 'Myanmar', 'MMR', '104', '95'),
(147, 'NA', 'Namibia', 'NAM', '516', '264'),
(148, 'NR', 'Nauru', 'NRU', '520', '674'),
(149, 'NP', 'Nepal', 'NPL', '524', '977'),
(150, 'NL', 'Netherlands', 'NLD', '528', '31'),
(151, 'AN', 'Netherlands Antilles', 'ANT', '530', '599'),
(152, 'NC', 'New Caledonia', 'NCL', '540', '687'),
(153, 'NZ', 'New Zealand', 'NZL', '554', '64'),
(154, 'NI', 'Nicaragua', 'NIC', '558', '505'),
(155, 'NE', 'Niger', 'NER', '562', '227'),
(156, 'NG', 'Nigeria', 'NGA', '566', '234'),
(157, 'NU', 'Niue', 'NIU', '570', '683'),
(158, 'NF', 'Norfolk Island', 'NFK', '574', '672'),
(159, 'MP', 'Northern Mariana Islands', 'MNP', '580', '1670'),
(160, 'NO', 'Norway', 'NOR', '578', '47'),
(161, 'OM', 'Oman', 'OMN', '512', '968'),
(162, 'PK', 'Pakistan', 'PAK', '586', '92'),
(163, 'PW', 'Palau', 'PLW', '585', '680'),
(164, 'PS', 'Palestinian Territory, Occupied', NULL, NULL, '970'),
(165, 'PA', 'Panama', 'PAN', '591', '507'),
(166, 'PG', 'Papua New Guinea', 'PNG', '598', '675'),
(167, 'PY', 'Paraguay', 'PRY', '600', '595'),
(168, 'PE', 'Peru', 'PER', '604', '51'),
(169, 'PH', 'Philippines', 'PHL', '608', '63'),
(170, 'PN', 'Pitcairn', 'PCN', '612', '0'),
(171, 'PL', 'Poland', 'POL', '616', '48'),
(172, 'PT', 'Portugal', 'PRT', '620', '351'),
(173, 'PR', 'Puerto Rico', 'PRI', '630', '1787'),
(174, 'QA', 'Qatar', 'QAT', '634', '974'),
(175, 'RE', 'Reunion', 'REU', '638', '262'),
(176, 'RO', 'Romania', 'ROM', '642', '40'),
(177, 'RU', 'Russian Federation', 'RUS', '643', '70'),
(178, 'RW', 'Rwanda', 'RWA', '646', '250'),
(179, 'SH', 'Saint Helena', 'SHN', '654', '290'),
(180, 'KN', 'Saint Kitts and Nevis', 'KNA', '659', '1869'),
(181, 'LC', 'Saint Lucia', 'LCA', '662', '1758'),
(182, 'PM', 'Saint Pierre and Miquelon', 'SPM', '666', '508'),
(183, 'VC', 'Saint Vincent and the Grenadines', 'VCT', '670', '1784'),
(184, 'WS', 'Samoa', 'WSM', '882', '684'),
(185, 'SM', 'San Marino', 'SMR', '674', '378'),
(186, 'ST', 'Sao Tome and Principe', 'STP', '678', '239'),
(187, 'SA', 'Saudi Arabia', 'SAU', '682', '966'),
(188, 'SN', 'Senegal', 'SEN', '686', '221'),
(189, 'CS', 'Serbia and Montenegro', NULL, NULL, '381'),
(190, 'SC', 'Seychelles', 'SYC', '690', '248'),
(191, 'SL', 'Sierra Leone', 'SLE', '694', '232'),
(192, 'SG', 'Singapore', 'SGP', '702', '65'),
(193, 'SK', 'Slovakia', 'SVK', '703', '421'),
(194, 'SI', 'Slovenia', 'SVN', '705', '386'),
(195, 'SB', 'Solomon Islands', 'SLB', '90', '677'),
(196, 'SO', 'Somalia', 'SOM', '706', '252'),
(197, 'ZA', 'South Africa', 'ZAF', '710', '27'),
(198, 'GS', 'South Georgia and the South Sandwich Islands', NULL, NULL, '0'),
(199, 'ES', 'Spain', 'ESP', '724', '34'),
(200, 'LK', 'Sri Lanka', 'LKA', '144', '94'),
(201, 'SD', 'Sudan', 'SDN', '736', '249'),
(202, 'SR', 'Suriname', 'SUR', '740', '597'),
(203, 'SJ', 'Svalbard and Jan Mayen', 'SJM', '744', '47'),
(204, 'SZ', 'Swaziland', 'SWZ', '748', '268'),
(205, 'SE', 'Sweden', 'SWE', '752', '46'),
(206, 'CH', 'Switzerland', 'CHE', '756', '41'),
(207, 'SY', 'Syrian Arab Republic', 'SYR', '760', '963'),
(208, 'TW', 'Taiwan, Province of China', 'TWN', '158', '886'),
(209, 'TJ', 'Tajikistan', 'TJK', '762', '992'),
(210, 'TZ', 'Tanzania, United Republic of', 'TZA', '834', '255'),
(211, 'TH', 'Thailand', 'THA', '764', '66'),
(212, 'TL', 'Timor-Leste', NULL, NULL, '670'),
(213, 'TG', 'Togo', 'TGO', '768', '228'),
(214, 'TK', 'Tokelau', 'TKL', '772', '690'),
(215, 'TO', 'Tonga', 'TON', '776', '676'),
(216, 'TT', 'Trinidad and Tobago', 'TTO', '780', '1868'),
(217, 'TN', 'Tunisia', 'TUN', '788', '216'),
(218, 'TR', 'Turkey', 'TUR', '792', '90'),
(219, 'TM', 'Turkmenistan', 'TKM', '795', '7370'),
(220, 'TC', 'Turks and Caicos Islands', 'TCA', '796', '1649'),
(221, 'TV', 'Tuvalu', 'TUV', '798', '688'),
(222, 'UG', 'Uganda', 'UGA', '800', '256'),
(223, 'UA', 'Ukraine', 'UKR', '804', '380'),
(224, 'AE', 'United Arab Emirates', 'ARE', '784', '971'),
(225, 'GB', 'United Kingdom', 'GBR', '826', '44'),
(226, 'US', 'United States', 'USA', '840', '1'),
(227, 'UM', 'United States Minor Outlying Islands', NULL, NULL, '1'),
(228, 'UY', 'Uruguay', 'URY', '858', '598'),
(229, 'UZ', 'Uzbekistan', 'UZB', '860', '998'),
(230, 'VU', 'Vanuatu', 'VUT', '548', '678'),
(231, 'VE', 'Venezuela', 'VEN', '862', '58'),
(232, 'VN', 'Viet Nam', 'VNM', '704', '84'),
(233, 'VG', 'Virgin Islands, British', 'VGB', '92', '1284'),
(234, 'VI', 'Virgin Islands, U.s.', 'VIR', '850', '1340'),
(235, 'WF', 'Wallis and Futuna', 'WLF', '876', '681'),
(236, 'EH', 'Western Sahara', 'ESH', '732', '212'),
(237, 'YE', 'Yemen', 'YEM', '887', '967'),
(238, 'ZM', 'Zambia', 'ZMB', '894', '260'),
(239, 'ZW', 'Zimbabwe', 'ZWE', '716', '263');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`, `symbol`, `rate`, `status`, `default`) VALUES
(1, 'US Dollar', 'USD', '&#36;', '1.00', 'Active', '1'),
(2, 'Pound Sterling', 'GBP', '&pound;', '0.65', 'Active', '0'),
(3, 'Europe', 'EUR', '&euro;', '0.88', 'Active', '0'),
(4, 'Australian Dollar', 'AUD', '&#36;', '1.41', 'Active', '0'),
(5, 'Singapore', 'SGD', '&#36;', '1.41', 'Active', '0'),
(6, 'Swedish Krona', 'SEK', 'kr', '8.24', 'Active', '0'),
(7, 'Danish Krone', 'DKK', 'kr', '6.58', 'Active', '0'),
(8, 'Mexican Peso', 'MXN', '$', '16.83', 'Active', '0'),
(9, 'Brazilian Real', 'BRL', 'R$', '3.88', 'Active', '0'),
(10, 'Malaysian Ringgit', 'MYR', 'RM', '4.31', 'Active', '0'),
(11, 'Philippine Peso', 'PHP', 'P', '46.73', 'Active', '0'),
(12, 'Swiss Franc', 'CHF', '&euro;', '0.97', 'Active', '0'),
(13, 'India', 'INR', '&#x20B9;', '66.24', 'Active', '0'),
(14, 'Argentine Peso', 'ARS', '&#36;', '9.35', 'Active', '0'),
(15, 'Canadian Dollar', 'CAD', '&#36;', '1.33', 'Active', '0'),
(16, 'Chinese Yuan', 'CNY', '&#165;', '6.37', 'Active', '0'),
(17, 'Czech Republic Koruna', 'CZK', 'K&#269;', '23.91', 'Active', '0'),
(18, 'Hong Kong Dollar', 'HKD', '&#36;', '7.75', 'Active', '0'),
(19, 'Hungarian Forint', 'HUF', 'Ft', '276.41', 'Active', '0'),
(20, 'Indonesian Rupiah', 'IDR', 'Rp', '14249.50', 'Active', '0'),
(21, 'Israeli New Sheqel', 'ILS', '&#8362;', '3.86', 'Active', '0'),
(22, 'Japanese Yen', 'JPY', '&#165;', '120.59', 'Active', '0'),
(23, 'South Korean Won', 'KRW', '&#8361;', '1182.69', 'Active', '0'),
(24, 'Norwegian Krone', 'NOK', 'kr', '8.15', 'Active', '0'),
(25, 'New Zealand Dollar', 'NZD', '&#36;', '1.58', 'Active', '0'),
(26, 'Polish Zloty', 'PLN', 'z&#322;', '3.71', 'Active', '0'),
(27, 'Russian Ruble', 'RUB', 'p', '67.75', 'Active', '0'),
(28, 'Thai Baht', 'THB', '&#3647;', '36.03', 'Active', '0'),
(29, 'Turkish Lira', 'TRY', '&#8378;', '3.05', 'Active', '0'),
(30, 'New Taiwan Dollar', 'TWD', '&#36;', '32.47', 'Active', '0'),
(31, 'Vietnamese Dong', 'VND', '&#8363;', '22471.00', 'Active', '0'),
(32, 'South African Rand', 'ZAR', 'R', '13.55', 'Active', '0');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `temp_id` int(11) NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('email','sms') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `temp_id`, `subject`, `body`, `link_text`, `lang`, `type`, `lang_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Your Payout information has been updated in {site_name}', 'Hi {first_name},\n                            <br><br>\n                            We hope this message finds you well. Your {site_name} payout account information was recently changed on {date_time}. To help keep your account secure, we wanted to reach out to confirm that you made this change. Feel free to disregard this message if you updated your payout account information on {date_time}.\n                            <br><br>\n                            If you did not make this change to your account, please contact us.<br>', NULL, 'en', 'email', 1, NULL, NULL),
(2, 2, 'Your Payout information has been updated in {site_name}', 'Hi {first_name},\n                            <br><br>\n                            Your {site_name} payout information was updated on {date_time}.<br>', NULL, 'en', 'email', 1, NULL, NULL),
(3, 3, 'Your Payout information has been deleted in {site_name}', 'Hi {first_name},\n                            <br><br>\n                            Your {site_name} payout information was deleted on {date_time}.<br>', NULL, 'en', 'email', 1, NULL, NULL),
(4, 4, 'Booking inquiry for {property_name}', 'Hi {owner_first_name},\n                            <br><br>\n            				<h1>Respond to {user_first_name}’s Inquiry</h1>\n            				<br>\n            				{total_night} {night/nights} at {property_name}\n            				<br>\n            				{messages_message}\n            				<br>\n            				Property Name:  {property_name}\n            				<br>\n            				Number of Guest: {total_guest}\n            				<br>\n            				Number of Night: {total_night}\n            				<br>\n                            Check in Time: {start_date}\n                            <br>\n                            Payment Via: {payment_method}', NULL, 'en', 'email', 1, NULL, NULL),
(5, 5, 'Please confirm your e-mail address', 'Hi {first_name},\n                            <br><br>\n                            Welcome to {site_name}! Please confirm your account.', NULL, 'en', 'email', 1, NULL, NULL),
(6, 6, 'Reset your Password', 'Hi {first_name},\n                            <br><br>\n                            Your requested password reset link is below. If you didn\'t make the request, just ignore this email.', NULL, 'en', 'email', 1, NULL, NULL),
(7, 7, 'Please set a payment account', 'Hi {first_name},\n                            <br><br>\n                            Amount {currency_symbol}{payout_amount} is waiting for you but you did not add any payout account to send the money. Please add a payout method.', NULL, 'en', 'email', 1, NULL, NULL),
(8, 8, 'Payout Sent', 'Hi {first_name},\n                            <br><br>\n                            We\'ve issued you a payout of  {currency_symbol}{payout_amount} via PayPal. This payout should arrive in your account, taking into consideration weekends and holidays.', NULL, 'en', 'email', 1, NULL, NULL),
(9, 9, 'Booking Cancelled', 'Hi {owner_first_name},\n                            <br><br>\n                            {user_first_name} cancelled booking of {property_name}.<br>', NULL, 'en', 'email', 1, NULL, NULL),
(10, 10, 'Booking {Accepted/Declined}', 'Hi {guest_first_name},\n                            <br><br>\n                            {host_first_name} {Accepted/Declined} the booking of {property_name}.<br>', NULL, 'en', 'email', 1, NULL, NULL),
(11, 11, 'Booking request send for {property_name}', 'Hi {user_first_name},\n                            <br><br>\n                            <h1>Booking request send to {owner_first_name}</h1>\n                            <br>\n                            {total_night} {night/nights} at {property_name}\n                            <br>\n                            Property Name:  {property_name}\n                            <br>\n                            Number of Guest: {total_guest}\n                            <br>\n                            Number of Night: {total_night}\n                            <br>\n                            Check in Time: {start_date}', NULL, 'en', 'email', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `short_name`, `status`, `default`) VALUES
(1, 'English', 'en', 'Active', '1'),
(2, 'عربى', 'ar', 'Active', '0'),
(3, '中文 (繁體)', 'ch', 'Active', '0'),
(4, 'Français', 'fr', 'Active', '0'),
(5, 'Português', 'pt', 'Active', '0'),
(6, 'Русский', 'ru', 'Active', '0'),
(7, 'Español', 'es', 'Active', '0'),
(8, 'Türkçe', 'tr', 'Active', '0');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `read` int(11) NOT NULL DEFAULT 0,
  `archive` int(11) NOT NULL DEFAULT 0,
  `star` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE `message_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`id`, `name`, `description`) VALUES
(1, 'query', NULL),
(2, 'guest_cancellation', NULL),
(3, 'host_cancellation', NULL),
(4, 'booking_request', NULL),
(5, 'booking_accecpt', NULL),
(6, 'booking_decline', NULL),
(7, 'booking_expire', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2015_09_26_161159_entrust_setup_tables', 1),
(4, '2015_10_05_153204_create_timezone_table', 1),
(5, '2017_02_08_044609_create_accounts_table', 1),
(6, '2017_02_08_045108_create_pages_table', 1),
(7, '2017_02_08_045204_create_reports_table', 1),
(8, '2017_02_08_045412_create_country_table', 1),
(9, '2017_02_08_045643_create_language_table', 1),
(10, '2017_02_08_045745_create_currency_table', 1),
(11, '2017_02_23_110333_create_backup_table', 1),
(12, '2017_02_27_124315_create_seo_metas_table', 1),
(13, '2017_03_01_130507_create_user_details_table', 1),
(14, '2017_03_29_070352_create_payment_methods_table', 1),
(15, '2017_04_02_110016_create_notification_table', 1),
(16, '2017_05_04_102846_create_admin_table', 1),
(17, '2017_05_04_103841_create_property_type_table', 1),
(18, '2017_05_04_104010_create_amenities_table', 1),
(19, '2017_05_04_104406_create_amenity_type_table', 1),
(20, '2017_05_04_104509_create_rules_table', 1),
(21, '2017_05_04_105120_create_settings_table', 1),
(22, '2017_05_04_105515_create_properties_table', 1),
(23, '2017_05_04_105605_create_property_description_table', 1),
(24, '2017_05_04_105636_create_property_price_table', 1),
(25, '2017_05_04_105726_create_property_address_table', 1),
(26, '2017_05_04_105742_create_property_photos_table', 1),
(27, '2017_05_04_105800_create_property_details_table', 1),
(28, '2017_05_04_112613_create_property_dates_table', 1),
(29, '2017_05_04_112728_create_property_rules_table', 1),
(30, '2017_05_04_112954_create_property_fees_table', 1),
(31, '2017_05_04_113049_create_bookings_table', 1),
(32, '2017_05_04_113223_create_penalty_table', 1),
(33, '2017_05_04_113243_create_payout_table', 1),
(34, '2017_05_04_113355_create_payout_penalties_table', 1),
(35, '2017_05_04_113622_create_booking_details_table', 1),
(36, '2017_05_04_114011_create_reviews_table', 1),
(37, '2017_05_04_114131_create_messages_table', 1),
(38, '2017_05_04_114152_create_bed_types_table', 1),
(39, '2017_05_04_114215_create_banners_table', 1),
(40, '2017_05_04_114238_create_starting_cities_table', 1),
(41, '2017_05_07_133954_create_message_type_table', 1),
(42, '2017_05_08_073511_create_property_beds_table', 1),
(43, '2017_05_13_055552_create_space_type_table', 1),
(44, '2017_05_18_121707_create_property_steps_table', 1),
(45, '2017_06_18_080440_create_table_user_verification', 1),
(46, '2019_02_02_111427_create_email_templates_table', 1),
(47, '2019_03_03_100404_create_property_icalimports_table', 1),
(48, '2019_08_19_000000_create_failed_jobs_table', 1),
(49, '2020_08_06_062818_create_testimonials_table', 1),
(50, '2020_11_19_082447_create_wallets_table', 1),
(51, '2020_11_19_084031_create_withdrawals_table', 1),
(52, '2020_11_19_102628_create_payout_settings_table', 1),
(53, '2021_12_13_090445_create_favourites_table', 1),
(54, '2021_12_18_072520_create_banks_table', 1),
(55, '2021_12_20_053832_add_attachment_to_bookings_table', 1),
(56, '2021_12_22_082809_create_bank_dates_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('read','unread') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `url`, `content`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Help', 'help', '<h2>Help</h2><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'first', 'Active', NULL, NULL),
(2, 'About', 'about', '<h2>About</h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'first', 'Active', NULL, NULL),
(3, 'Policies', 'policies', '<h2>Policies</h2><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 'second', 'Active', NULL, NULL),
(4, 'Privacy', 'privacy', '<h2><strong>Privacy</strong></h2><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>&nbsp;</p>', 'second', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `status`) VALUES
(1, 'Paypal', 'Active'),
(2, 'Stripe', 'Active'),
(3, 'Wallet', 'Active'),
(4, 'Bank', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_type` enum('Host','Guest') COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `penalty_amount` double NOT NULL DEFAULT 0,
  `status` enum('Completed','Future') COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_penalties`
--

CREATE TABLE `payout_penalties` (
  `id` int(10) UNSIGNED NOT NULL,
  `payout_id` int(11) NOT NULL,
  `penalty_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_settings`
--

CREATE TABLE `payout_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `swift_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `selected` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('Host','Guest') COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `remaining_penalty` double NOT NULL DEFAULT 0,
  `reason` enum('cancelation','demurrage','violation_of_rules') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'manage_admin', 'Manage Admin', 'Manage Admin Users', NULL, NULL),
(2, 'customers', 'View Customers', 'View Customer', NULL, NULL),
(3, 'add_customer', 'Add Customer', 'Add Customer', NULL, NULL),
(4, 'edit_customer', 'Edit Customer', 'Edit Customer', NULL, NULL),
(5, 'properties', 'View Properties', 'View Properties', NULL, NULL),
(6, 'add_properties', 'Add Properties', 'Add Properties', NULL, NULL),
(7, 'edit_properties', 'Edit Properties', 'Edit Properties', NULL, NULL),
(8, 'delete_property', 'Delete Property', 'Delete Property', NULL, NULL),
(9, 'manage_bookings', 'Manage Bookings', 'Manage Bookings', NULL, NULL),
(10, 'manage_email_template', 'Manage Email Template', 'Manage Email Template', NULL, NULL),
(11, 'view_payouts', 'View Payouts', 'View Payouts', NULL, NULL),
(12, 'manage_amenities', 'Manage Amenities', 'Manage Amenities', NULL, NULL),
(13, 'manage_pages', 'Manage Pages', 'Manage Pages', NULL, NULL),
(14, 'manage_reviews', 'Manage Reviews', 'Manage Reviews', NULL, NULL),
(15, 'view_reports', 'View Reports', 'View Reports', NULL, NULL),
(16, 'general_setting', 'Settings', 'Settings', NULL, NULL),
(17, 'preference', 'Preference', 'Preference', NULL, NULL),
(18, 'manage_banners', 'Manage Banners', 'Manage Banners', NULL, NULL),
(19, 'starting_cities_settings', 'Starting Cities Settings', 'Starting Cities Settings', NULL, NULL),
(20, 'manage_property_type', 'Manage Property Type', 'Manage Property Type', NULL, NULL),
(21, 'space_type_setting', 'Space Type Setting', 'Space Type Setting', NULL, NULL),
(22, 'manage_bed_type', 'Manage Bed Type', 'Manage Bed Type', NULL, NULL),
(23, 'manage_currency', 'Manage Currency', 'Manage Currency', NULL, NULL),
(24, 'manage_country', 'Manage Country', 'Manage Country', NULL, NULL),
(25, 'manage_amenities_type', 'Manage Amenities Type', 'Manage Amenities Type', NULL, NULL),
(26, 'email_settings', 'Email Settings', 'Email Settings', NULL, NULL),
(27, 'manage_fees', 'Manage Fees', 'Manage Fees', NULL, NULL),
(28, 'manage_language', 'Manage Language', 'Manage Language', NULL, NULL),
(29, 'manage_metas', 'Manage Metas', 'Manage Metas', NULL, NULL),
(30, 'api_informations', 'Api Credentials', 'Api Credentials', NULL, NULL),
(31, 'payment_settings', 'Payment Settings', 'Payment Settings', NULL, NULL),
(32, 'social_links', 'Social Links', 'Social Links', NULL, NULL),
(33, 'manage_roles', 'Manage Roles', 'Manage Roles', NULL, NULL),
(34, 'database_backup', 'Database Backup', 'Database Backup', NULL, NULL),
(35, 'manage_sms', 'Manage SMS', 'Manage SMS', NULL, NULL),
(36, 'manage_messages', 'Manage Messages', 'Manage Messages', NULL, NULL),
(37, 'edit_messages', 'Edit Messages', 'Edit Messages', NULL, NULL),
(38, 'manage_testimonial', 'Manage Testimonial', 'Manage Testimonial', NULL, NULL),
(39, 'add_testimonial', 'Add Testimonial', 'Add Testimonial', NULL, NULL),
(40, 'edit_testimonial', 'Edit Testimonial', 'Edit Testimonial', NULL, NULL),
(41, 'delete_testimonial', 'Delete Testimonial', 'Delete Testimonial', NULL, NULL),
(42, 'social_logins', 'Social Logins', 'Manage Social Logins', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host_id` int(11) NOT NULL,
  `bedrooms` tinyint(4) DEFAULT NULL,
  `beds` tinyint(4) DEFAULT NULL,
  `bed_type` int(10) UNSIGNED DEFAULT NULL,
  `bathrooms` double(8,2) DEFAULT NULL,
  `amenities` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_type` int(11) NOT NULL DEFAULT 0,
  `space_type` int(11) NOT NULL DEFAULT 0,
  `accommodates` tinyint(4) DEFAULT NULL,
  `booking_type` enum('instant','request') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'request',
  `cancellation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Flexible',
  `status` enum('Unlisted','Listed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unlisted',
  `recomended` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `slug`, `url_name`, `host_id`, `bedrooms`, `beds`, `bed_type`, `bathrooms`, `amenities`, `property_type`, `space_type`, `accommodates`, `booking_type`, `cancellation`, `status`, `recomended`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Private room', 'private-room-1', NULL, 1, 1, 1, 1, 0.50, '1,2,3,4,6,7,14,21,26,27,29,31', 1, 2, 2, 'request', 'Flexible', 'Listed', 0, NULL, '2022-09-05 07:56:15', '2022-09-05 09:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `property_address`
--

CREATE TABLE `property_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_address`
--

INSERT INTO `property_address` (`id`, `property_id`, `address_line_1`, `address_line_2`, `latitude`, `longitude`, `city`, `state`, `country`, `postal_code`) VALUES
(1, 1, '141 Worth St, New York, NY 10013, USA', NULL, '40.7127753', '-74.0059728', 'New York', 'New York', 'US', '10013');

-- --------------------------------------------------------

--
-- Table structure for table `property_beds`
--

CREATE TABLE `property_beds` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `bed_type_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_dates`
--

CREATE TABLE `property_dates` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `status` enum('Available','Not available') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Available',
  `price` int(11) NOT NULL DEFAULT 0,
  `min_stay` tinyint(4) NOT NULL DEFAULT 0,
  `min_day` int(11) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `color` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('calendar','normal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_dates`
--

INSERT INTO `property_dates` (`id`, `property_id`, `status`, `price`, `min_stay`, `min_day`, `date`, `color`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'Not available', 35, 0, 0, '2022-09-05', NULL, 'normal', '2022-09-05 09:52:38', '2022-09-05 09:52:38'),
(2, 1, 'Not available', 35, 0, 0, '2022-09-06', NULL, 'normal', '2022-09-05 09:52:38', '2022-09-05 09:52:38'),
(3, 1, 'Not available', 35, 0, 0, '2022-09-07', NULL, 'normal', '2022-09-05 09:52:38', '2022-09-05 09:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `property_description`
--

CREATE TABLE `property_description` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_is_great_for` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_place` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_can_access` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interaction_guests` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_neighborhood` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_around` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_description`
--

INSERT INTO `property_description` (`id`, `property_id`, `summary`, `place_is_great_for`, `about_place`, `guest_can_access`, `interaction_guests`, `other`, `about_neighborhood`, `get_around`) VALUES
(1, 1, 'Asperiores laborum Sopoline Melendez', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_details`
--

CREATE TABLE `property_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_fees`
--

CREATE TABLE `property_fees` (
  `id` int(10) UNSIGNED NOT NULL,
  `field` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_fees`
--

INSERT INTO `property_fees` (`id`, `field`, `value`) VALUES
(1, 'more_then_seven', '0'),
(2, 'less_then_seven', '0'),
(3, 'host_service_charge', '0'),
(4, 'guest_service_charge', '5'),
(5, 'cancel_limit', '0'),
(6, 'currency', 'USD'),
(7, 'host_penalty', '0'),
(8, 'iva_tax', '0'),
(9, 'accomodation_tax', '0');

-- --------------------------------------------------------

--
-- Table structure for table `property_icalimports`
--

CREATE TABLE `property_icalimports` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `icalendar_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icalendar_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icalendar_last_sync` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_photos`
--

CREATE TABLE `property_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(105) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_photo` int(11) NOT NULL DEFAULT 0,
  `serial` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_photos`
--

INSERT INTO `property_photos` (`id`, `property_id`, `photo`, `message`, `cover_photo`, `serial`) VALUES
(2, 1, '1662393001_pexels-binyamin-mellish-106399.jpg', NULL, 1, 1),
(3, 1, '1662393043_pexels-binyamin-mellish-186077_(1).jpg', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `property_price`
--

CREATE TABLE `property_price` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `cleaning_fee` int(11) NOT NULL DEFAULT 0,
  `guest_after` int(11) NOT NULL DEFAULT 0,
  `guest_fee` int(11) NOT NULL DEFAULT 0,
  `security_fee` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `weekend_price` int(11) NOT NULL DEFAULT 0,
  `weekly_discount` int(11) NOT NULL DEFAULT 0,
  `monthly_discount` int(11) NOT NULL DEFAULT 0,
  `currency_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_price`
--

INSERT INTO `property_price` (`id`, `property_id`, `cleaning_fee`, `guest_after`, `guest_fee`, `security_fee`, `price`, `weekend_price`, `weekly_discount`, `monthly_discount`, `currency_code`) VALUES
(1, 1, 5, 1, 5, 0, 35, 0, 0, 0, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `property_rules`
--

CREATE TABLE `property_rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_steps`
--

CREATE TABLE `property_steps` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `basics` int(11) NOT NULL DEFAULT 0,
  `description` int(11) NOT NULL DEFAULT 0,
  `location` int(11) NOT NULL DEFAULT 0,
  `photos` int(11) NOT NULL DEFAULT 0,
  `pricing` int(11) NOT NULL DEFAULT 0,
  `booking` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_steps`
--

INSERT INTO `property_steps` (`id`, `property_id`, `basics`, `description`, `location`, `photos`, `pricing`, `booking`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `name`, `description`, `status`) VALUES
(1, 'Apartment', 'Apartment', 'Active'),
(2, 'House', 'House', 'Active'),
(3, 'Bed & Break Fast', 'Bed & Break Fast', 'Active'),
(4, 'Loft', 'Loft', 'Active'),
(5, 'Townhouse', 'Townhouse', 'Active'),
(6, 'Condominium', 'Condominium', 'Active'),
(7, 'Bungalow', 'Bungalow', 'Active'),
(8, 'Cabin', 'Cabin', 'Active'),
(9, 'Villa', 'Villa', 'Active'),
(10, 'Castle', 'Castle', 'Active'),
(11, 'Dorm', 'Dorm', 'Active'),
(12, 'Treehouse', 'Treehouse', 'Active'),
(13, 'Boat', 'Boat', 'Active'),
(14, 'Plane', 'Plane', 'Active'),
(15, 'Camper/RV', 'Camper/RV', 'Active'),
(16, 'Lgloo', 'Lgloo', 'Active'),
(17, 'Lighthouse', 'Lighthouse', 'Active'),
(18, 'Yurt', 'Yurt', 'Active'),
(19, 'Tipi', 'Tipi', 'Active'),
(20, 'Cave', 'Cave', 'Active'),
(21, 'Island', 'Island', 'Active'),
(22, 'Chalet', 'Chalet', 'Active'),
(23, 'Earth House', 'Earth House', 'Active'),
(24, 'Hut', 'Hut', 'Active'),
(25, 'Train', 'Train', 'Active'),
(26, 'Tent', 'Tent', 'Active'),
(27, 'Other', 'Other', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('unsolved','solved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unsolved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `reviewer` enum('guest','host') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `improve_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `accuracy` int(11) DEFAULT NULL,
  `accuracy_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `location_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `communication` int(11) DEFAULT NULL,
  `communication_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin` int(11) DEFAULT NULL,
  `checkin_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cleanliness` int(11) DEFAULT NULL,
  `cleanliness_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amenities` int(11) DEFAULT NULL,
  `amenities_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `value_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_rules` int(11) DEFAULT NULL,
  `recommend` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'Admin User', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_admin`
--

CREATE TABLE `role_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_admin`
--

INSERT INTO `role_admin` (`admin_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `message`, `status`) VALUES
(1, 'Suitable for children (2-12 years)', 'Active'),
(2, 'Suitable for infants (Under 2 years)', 'Active'),
(3, 'Suitable for pets', 'Active'),
(4, 'Smoking allowed', 'Active'),
(5, 'Events or parties allowed', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `seo_metas`
--

CREATE TABLE `seo_metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_metas`
--

INSERT INTO `seo_metas` (`id`, `url`, `title`, `description`, `keywords`) VALUES
(1, '/', 'Home | Travelobug Home', 'Vacation Rentals, Cabins, Beach Houses, Unique Homes & Experiences', ''),
(2, 'login', 'Log In', 'Log In', ''),
(3, 'register', 'Register', 'Register', ''),
(4, 'newest', 'Newest Photos', 'Newest Photos', ''),
(5, 'forgot_password', 'Forgot Password', 'Forgot Password', ''),
(6, 'dashboard', 'Feeds', 'Feeds', ''),
(7, 'uploads', 'Uploads', 'Uploads', ''),
(8, 'notification', 'Notification', 'Notification', ''),
(9, 'profile', 'Profile', 'Profile', ''),
(10, 'profile/{id}', 'Profile', 'Profile', ''),
(11, 'manage-photos', 'Manage Photos', 'Manage Photos', ''),
(12, 'earning', 'Earning', 'Earning', ''),
(13, 'purchase', 'Purchase', 'Purchase', ''),
(14, 'settings', 'Settings', 'Settings', ''),
(15, 'settings/account', 'Settings', 'Settings', ''),
(16, 'settings/payment', 'Settings', 'Settings', ''),
(17, 'photo/single/{id}', 'Photo Single', 'Photo Single', ''),
(18, 'payments/success', 'Payment Success', 'Payment Success', ''),
(19, 'payments/cancel', 'Payment Cancel', 'Payment Cancel', ''),
(20, 'profile-uploads/{type}', 'Profile Uploads', 'Profile Uploads', ''),
(21, 'photo-details/{id}', 'Photo Details', 'Photo Details', ''),
(22, 'withdraws', 'Withdraws', 'Withdraws', ''),
(23, 'photos/download/{id}', 'Photos Download', 'Photos Download', ''),
(24, 'users/reset_password/{secret?}', 'Reset Password', 'Reset Password', ''),
(25, 'search/{word}', 'Search Result', 'Search Result', ''),
(26, 'search/user/{word}', 'Search User Result', 'Search User Result', ''),
(27, 'signup', 'Signup', 'Signup', ''),
(28, 'property/create', 'Create New Property', 'Create New Property', ''),
(29, 'listing/{id}/{step}', 'Property Listing', 'Property Listing', ''),
(30, 'properties', 'Properties', 'Properties', ''),
(31, 'my_bookings', 'My Bookings', 'My Bookings', ''),
(32, 'trips/active', 'Your Trips', 'Your Trips', ''),
(33, 'users/profile', 'Edit Profile', 'Edit Profile', ''),
(34, 'users/account_preferences', 'Account Preferences', 'Account Preferences', ''),
(35, 'users/transaction_history', 'Transaction History', 'Transaction History', ''),
(36, 'users/security', 'Security', 'Security', ''),
(37, 'search', 'Search', 'Search', ''),
(38, 'inbox', 'Inbox', 'Inbox', ''),
(39, 'users/profile/media', 'Profile Photo', 'Profile Photo', ''),
(40, 'booking/requested', 'Payment Completed', 'Payment Completed', ''),
(41, 'user/favourite', 'Favourite List', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`) VALUES
(1, 'name', 'Travelobug', 'general'),
(2, 'email', 'stockpile@techvill.net', 'general'),
(3, 'logo', 'logo.png', 'general'),
(4, 'favicon', 'favicon.png', 'general'),
(5, 'head_code', '', 'general'),
(6, 'default_currency', '1', 'general'),
(7, 'default_language', '1', 'general'),
(8, 'email_logo', 'email_logo.png', 'general'),
(9, 'username', 'techvillage_business_api1.gmail.com', 'PayPal'),
(10, 'password', '9DDYZX2JLA6QL668', 'PayPal'),
(11, 'signature', 'AFcWxV21C7fd0v3bYYYRCpSSRl31ABayz5pdk84jno7.Udj6-U8ffwbT', 'PayPal'),
(12, 'mode', 'sandbox', 'PayPal'),
(13, 'paypal_status', '1', 'PayPal'),
(14, 'publishable', 'pk_test_c2TDWXsjPkimdM8PIltO6d8H', 'Stripe'),
(15, 'secret', 'sk_test_UWTgGYIdj8igmbVMgTi0ILPm', 'Stripe'),
(16, 'stripe_status', '1', 'Stripe'),
(17, 'driver', 'sendmail', 'email'),
(18, 'host', 'mail.techvill.net', 'email'),
(19, 'port', '587', 'email'),
(20, 'from_address', 'stockpile@techvill.net', 'email'),
(21, 'from_name', 'Travelobug', 'email'),
(22, 'encryption', 'tls', 'email'),
(23, 'username', 'stockpile@techvill.net', 'email'),
(24, 'password', 'nT4HD2XEdRUX', 'email'),
(25, 'facebook', '#', 'join_us'),
(26, 'google_plus', '#', 'join_us'),
(27, 'twitter', '#', 'join_us'),
(28, 'linkedin', '#', 'join_us'),
(29, 'pinterest', '#', 'join_us'),
(30, 'youtube', '#', 'join_us'),
(31, 'instagram', '#', 'join_us'),
(32, 'key', 'AIzaSyBcGrzAfHeQj5pKCuU23zXDlRTngClwWT4', 'googleMap'),
(33, 'client_id', '155732176097-s2b8liiqj6v8l39r25baq31vm3adg8uv.apps.googleusercontent.com', 'google'),
(34, 'client_secret', 'ltyqX9vFSqkaRjo4-rxphynm', 'google'),
(35, 'client_id', '166441230733266', 'facebook'),
(36, 'client_secret', '0787364d54422d8ff0bbb646c7f3231e', 'facebook'),
(37, 'email_status', '0', 'email'),
(38, 'row_per_page', '25', 'preferences'),
(39, 'date_separator', '-', 'preferences'),
(40, 'date_format', '2', 'preferences'),
(41, 'dflt_timezone', 'Asia/Dhaka', 'preferences'),
(42, 'money_format', 'before', 'preferences'),
(43, 'date_format_type', 'mm-dd-yyyy', 'preferences'),
(44, 'front_date_format_type', 'mm-dd-yy', 'preferences'),
(45, 'search_date_format_type', 'm-d-yy', 'preferences'),
(46, 'min_search_price', '1', 'preferences'),
(47, 'max_search_price', '1000', 'preferences'),
(48, 'facebook_login', '1', 'social'),
(49, 'google_login', '1', 'social');

-- --------------------------------------------------------

--
-- Table structure for table `space_type`
--

CREATE TABLE `space_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `space_type`
--

INSERT INTO `space_type` (`id`, `name`, `description`, `status`) VALUES
(1, 'Entire home/apt', 'Entire home/apt', 'Active'),
(2, 'Private room', 'Private room', 'Active'),
(3, 'Shared room', 'Shared room', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `starting_cities`
--

CREATE TABLE `starting_cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `starting_cities`
--

INSERT INTO `starting_cities` (`id`, `name`, `image`, `status`) VALUES
(1, 'New York', 'starting_city_1.jpg', 'Active'),
(2, 'Sydney', 'starting_city_2.jpg', 'Active'),
(3, 'Paris', 'starting_city_3.jpg', 'Active'),
(4, 'Barcelona', 'starting_city_4.jpg', 'Active'),
(5, 'Berlin', 'starting_city_5.jpg', 'Active'),
(6, 'Budapest', 'starting_city_6.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` int(11) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `image`, `description`, `review`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'Traveller', 'testimonial_1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 5, 'Active', NULL, NULL),
(2, 'Adam Smith', 'Traveller', 'testimonial_2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 5, 'Active', NULL, NULL),
(3, 'Alysa', 'Photographer', 'testimonial_3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 5, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

CREATE TABLE `timezone` (
  `id` int(10) UNSIGNED NOT NULL,
  `zone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezone`
--

INSERT INTO `timezone` (`id`, `zone`, `value`) VALUES
(1, '(GMT-11:00) International Date Line West', 'Pacific/Kwajalein'),
(2, '(GMT-11:00) Midway Island', 'Pacific/Midway'),
(3, '(GMT-11:00) Samoa', 'Pacific/Samoa'),
(4, '(GMT-10:00) Hawaii', 'Pacific/Honolulu'),
(5, '(GMT-10:00) Pacific/Honolulu', 'Pacific/Honolulu'),
(6, '(GMT-09:00) Alaska', 'US/Alaska'),
(7, '(GMT-08:00) America/Los_Angeles', 'America/Los_Angeles'),
(8, '(GMT-08:00) Pacific Time (US &amp; Canada)', 'America/Los_Angeles'),
(9, '(GMT-08:00) Tijuana', 'America/Tijuana'),
(10, '(GMT-07:00) America/Denver', 'America/Denver'),
(11, '(GMT-07:00) America/Phoenix', 'America/Phoenix'),
(12, '(GMT-07:00) Arizona', 'US/Arizona'),
(13, '(GMT-07:00) Chihuahua', 'America/Chihuahua'),
(14, '(GMT-07:00) Mazatlan', 'America/Mazatlan'),
(15, '(GMT-07:00) Mountain Time (US &amp; Canada)', 'US/Mountain'),
(16, '(GMT-06:00) America/Chicago', 'America/Chicago'),
(17, '(GMT-06:00) America/Mexico_City', 'America/Mexico_City'),
(18, '(GMT-06:00) Central America', 'America/Managua'),
(19, '(GMT-06:00) Central Time (US &amp; Canada)', 'US/Central'),
(20, '(GMT-06:00) Guadalajara', 'America/Mexico_City'),
(21, '(GMT-06:00) Mexico City', 'America/Mexico_City'),
(22, '(GMT-06:00) Monterrey', 'America/Monterrey'),
(23, '(GMT-06:00) Saskatchewan', 'Canada/Saskatchewan'),
(24, '(GMT-05:00) America/Nassau', 'America/Nassau'),
(25, '(GMT-05:00) America/New_York', 'America/New_York'),
(26, '(GMT-05:00) America/Port-au-Prince', 'America/Port-au-Prince'),
(27, '(GMT-05:00) America/Toronto', 'America/Toronto'),
(28, '(GMT-05:00) Bogota', 'America/Bogota'),
(29, '(GMT-05:00) Eastern Time (US &amp; Canada)', 'US/Eastern'),
(30, '(GMT-05:00) Indiana (East)', 'US/East-Indiana'),
(31, '(GMT-05:00) Lima', 'America/Lima'),
(32, '(GMT-05:00) Quito', 'America/Bogota'),
(33, '(GMT-04:30) Caracas', 'America/Caracas'),
(34, '(GMT-04:00) Atlantic Time (Canada)', 'Canada/Atlantic'),
(35, '(GMT-04:00) Georgetown', 'America/Argentina/Buenos_Aires'),
(36, '(GMT-04:00) La Paz', 'America/La_Paz'),
(37, '(GMT-03:30) Newfoundland', 'Canada/Newfoundland'),
(38, '(GMT-03:00) America/Argentina/Buenos_Aires', 'America/Argentina/Buenos_Aires'),
(39, '(GMT-03:00) America/Cordoba', 'America/Cordoba'),
(40, '(GMT-03:00) America/Fortaleza', 'America/Fortaleza'),
(41, '(GMT-03:00) America/Montevideo', 'America/Montevideo'),
(42, '(GMT-03:00) America/Santiago', 'America/Santiago'),
(43, '(GMT-03:00) America/Sao_Paulo', 'America/Sao_Paulo'),
(44, '(GMT-03:00) Brasilia', 'America/Sao_Paulo'),
(45, '(GMT-03:00) Buenos Aires', 'America/Argentina/Buenos_Aires'),
(46, '(GMT-03:00) Greenland', 'America/Godthab'),
(47, '(GMT-03:00) Santiago', 'America/Santiago'),
(48, '(GMT-02:00) Mid-Atlantic', 'America/Noronha'),
(49, '(GMT-01:00) Azores', 'Atlantic/Azores'),
(50, '(GMT-01:00) Cape Verde Is.', 'Atlantic/Cape_Verde'),
(51, '(GMT+00:00) Africa/Casablanca', 'Africa/Casablanca'),
(52, '(GMT+00:00) Atlantic/Canary', 'Atlantic/Canary'),
(53, '(GMT+00:00) Atlantic/Reykjavik', 'Atlantic/Reykjavik'),
(54, '(GMT+00:00) Casablanca', 'Africa/Casablanca'),
(55, '(GMT+00:00) Dublin', 'Etc/Greenwich'),
(56, '(GMT+00:00) Edinburgh', 'Europe/London'),
(57, '(GMT+00:00) Europe/Dublin', 'Europe/Dublin'),
(58, '(GMT+00:00) Europe/Lisbon', 'Europe/Lisbon'),
(59, '(GMT+00:00) Europe/London', 'Europe/London'),
(60, '(GMT+00:00) Lisbon', 'Europe/Lisbon'),
(61, '(GMT+00:00) London', 'Europe/London'),
(62, '(GMT+00:00) Monrovia', 'Africa/Monrovia'),
(63, '(GMT+00:00) UTC', 'UTC'),
(64, '(GMT+01:00) Amsterdam', 'Europe/Amsterdam'),
(65, '(GMT+01:00) Belgrade', 'Europe/Belgrade'),
(66, '(GMT+01:00) Berlin', 'Europe/Berlin'),
(67, '(GMT+01:00) Bern', 'Europe/Berlin'),
(68, '(GMT+01:00) Bratislava', 'Europe/Bratislava'),
(69, '(GMT+01:00) Brussels', 'Europe/Brussels'),
(70, '(GMT+01:00) Budapest', 'Europe/Budapest'),
(71, '(GMT+01:00) Copenhagen', 'Europe/Copenhagen'),
(72, '(GMT+01:00) Europe/Amsterdam', 'Europe/Amsterdam'),
(73, '(GMT+01:00) Europe/Belgrade', 'Europe/Belgrade'),
(74, '(GMT+01:00) Europe/Berlin', 'Europe/Berlin'),
(75, '(GMT+01:00) Europe/Bratislava', 'Europe/Bratislava'),
(76, '(GMT+01:00) Europe/Brussels', 'Europe/Brussels'),
(77, '(GMT+01:00) Europe/Budapest', 'Europe/Budapest'),
(78, '(GMT+01:00) Europe/Copenhagen', 'Europe/Copenhagen'),
(79, '(GMT+01:00) Europe/Ljubljana', 'Europe/Ljubljana'),
(80, '(GMT+01:00) Europe/Madrid', 'Europe/Madrid'),
(81, '(GMT+01:00) Europe/Monaco', 'Europe/Monaco'),
(82, '(GMT+01:00) Europe/Oslo', 'Europe/Oslo'),
(83, '(GMT+01:00) Europe/Paris', 'Europe/Paris'),
(84, '(GMT+01:00) Europe/Podgorica', 'Europe/Podgorica'),
(85, '(GMT+01:00) Europe/Prague', 'Europe/Prague'),
(86, '(GMT+01:00) Europe/Rome', 'Europe/Rome'),
(87, '(GMT+01:00) Europe/Stockholm', 'Europe/Stockholm'),
(88, '(GMT+01:00) Europe/Tirane', 'Europe/Tirane'),
(89, '(GMT+01:00) Europe/Vienna', 'Europe/Vienna'),
(90, '(GMT+01:00) Europe/Warsaw', 'Europe/Warsaw'),
(91, '(GMT+01:00) Europe/Zagreb', 'Europe/Zagreb'),
(92, '(GMT+01:00) Europe/Zurich', 'Europe/Zurich'),
(93, '(GMT+01:00) Ljubljana', 'Europe/Ljubljana'),
(94, '(GMT+01:00) Madrid', 'Europe/Madrid'),
(95, '(GMT+01:00) Paris', 'Europe/Paris'),
(96, '(GMT+01:00) Prague', 'Europe/Prague'),
(97, '(GMT+01:00) Rome', 'Europe/Rome'),
(98, '(GMT+01:00) Sarajevo', 'Europe/Sarajevo'),
(99, '(GMT+01:00) Skopje', 'Europe/Skopje'),
(100, '(GMT+01:00) Stockholm', 'Europe/Stockholm'),
(101, '(GMT+01:00) Vienna', 'Europe/Vienna'),
(102, '(GMT+01:00) Warsaw', 'Europe/Warsaw'),
(103, '(GMT+01:00) West Central Africa', 'Africa/Lagos'),
(104, '(GMT+01:00) Zagreb', 'Europe/Zagreb'),
(105, '(GMT+02:00) Asia/Beirut', 'Asia/Beirut'),
(106, '(GMT+02:00) Asia/Jerusalem', 'Asia/Jerusalem'),
(107, '(GMT+02:00) Asia/Nicosia', 'Asia/Nicosia'),
(108, '(GMT+02:00) Athens', 'Europe/Athens'),
(109, '(GMT+02:00) Bucharest', 'Europe/Bucharest'),
(110, '(GMT+02:00) Cairo', 'Africa/Cairo'),
(111, '(GMT+02:00) Europe/Athens', 'Europe/Athens'),
(112, '(GMT+02:00) Europe/Helsinki', 'Europe/Helsinki'),
(113, '(GMT+02:00) Europe/Istanbul', 'Europe/Istanbul'),
(114, '(GMT+02:00) Europe/Riga', 'Europe/Riga'),
(115, '(GMT+02:00) Europe/Sofia', 'Europe/Sofia'),
(116, '(GMT+02:00) Harare', 'Africa/Harare'),
(117, '(GMT+02:00) Helsinki', 'Europe/Helsinki'),
(118, '(GMT+02:00) Istanbul', 'Europe/Istanbul'),
(119, '(GMT+02:00) Jerusalem', 'Asia/Jerusalem'),
(120, '(GMT+02:00) Kyiv', 'Europe/Helsinki'),
(121, '(GMT+02:00) Pretoria', 'Africa/Johannesburg'),
(122, '(GMT+02:00) Riga', 'Europe/Riga'),
(123, '(GMT+02:00) Sofia', 'Europe/Sofia'),
(124, '(GMT+02:00) Tallinn', 'Europe/Tallinn'),
(125, '(GMT+02:00) Vilnius', 'Europe/Vilnius'),
(126, '(GMT+03:00) Baghdad', 'Asia/Baghdad'),
(127, '(GMT+03:00) Europe/Minsk', 'Europe/Minsk'),
(128, '(GMT+03:00) Europe/Moscow', 'Europe/Moscow'),
(129, '(GMT+03:00) Kuwait', 'Asia/Kuwait'),
(130, '(GMT+03:00) Minsk', 'Europe/Minsk'),
(131, '(GMT+03:00) Moscow', 'Europe/Moscow'),
(132, '(GMT+03:00) Nairobi', 'Africa/Nairobi'),
(133, '(GMT+03:00) Riyadh', 'Asia/Riyadh'),
(134, '(GMT+03:00) St. Petersburg', 'Europe/Moscow'),
(135, '(GMT+03:00) Volgograd', 'Europe/Volgograd'),
(136, '(GMT+03:30) Tehran', 'Asia/Tehran'),
(137, '(GMT+04:00) Abu Dhabi', 'Asia/Muscat'),
(138, '(GMT+04:00) Asia/Dubai', 'Asia/Dubai'),
(139, '(GMT+04:00) Asia/Tbilisi', 'Asia/Tbilisi'),
(140, '(GMT+04:00) Baku', 'Asia/Baku'),
(141, '(GMT+04:00) Muscat', 'Asia/Muscat'),
(142, '(GMT+04:00) Tbilisi', 'Asia/Tbilisi'),
(143, '(GMT+04:00) Yerevan', 'Asia/Yerevan'),
(144, '(GMT+04:30) Kabul', 'Asia/Kabul'),
(145, '(GMT+05:00) Ekaterinburg', 'Asia/Yekaterinburg'),
(146, '(GMT+05:00) Indian/Maldives', 'Indian/Maldives'),
(147, '(GMT+05:00) Islamabad', 'Asia/Karachi'),
(148, '(GMT+05:00) Karachi', 'Asia/Karachi'),
(149, '(GMT+05:00) Tashkent', 'Asia/Tashkent'),
(150, '(GMT+05:30) Asia/Calcutta', 'Asia/Calcutta'),
(151, '(GMT+05:30) Asia/Colombo', 'Asia/Colombo'),
(152, '(GMT+05:30) Chennai', 'Asia/Calcutta'),
(153, '(GMT+05:30) Kolkata', 'Asia/Kolkata'),
(154, '(GMT+05:30) Mumbai', 'Asia/Calcutta'),
(155, '(GMT+05:30) New Delhi', 'Asia/Calcutta'),
(156, '(GMT+05:30) Sri Jayawardenepura', 'Asia/Calcutta'),
(157, '(GMT+05:45) Kathmandu', 'Asia/Katmandu'),
(158, '(GMT+06:00) Almaty', 'Asia/Almaty'),
(159, '(GMT+06:00) Astana', 'Asia/Dhaka'),
(160, '(GMT+06:00) Dhaka', 'Asia/Dhaka'),
(161, '(GMT+06:00) Novosibirsk', 'Asia/Novosibirsk'),
(162, '(GMT+06:00) Urumqi', 'Asia/Urumqi'),
(163, '(GMT+06:30) Rangoon', 'Asia/Rangoon'),
(164, '(GMT+07:00) Asia/Bangkok', 'Asia/Bangkok'),
(165, '(GMT+07:00) Asia/Jakarta', 'Asia/Jakarta'),
(166, '(GMT+07:00) Bangkok', 'Asia/Bangkok'),
(167, '(GMT+07:00) Hanoi', 'Asia/Bangkok'),
(168, '(GMT+07:00) Jakarta', 'Asia/Jakarta'),
(169, '(GMT+07:00) Krasnoyarsk', 'Asia/Krasnoyarsk'),
(170, '(GMT+08:00) Asia/Chongqing', 'Asia/Chongqing'),
(171, '(GMT+08:00) Asia/Hong_Kong', 'Asia/Hong_Kong'),
(172, '(GMT+08:00) Asia/Kuala_Lumpur', 'Asia/Kuala_Lumpur'),
(173, '(GMT+08:00) Asia/Macau', 'Asia/Macau'),
(174, '(GMT+08:00) Asia/Makassar', 'Asia/Makassar'),
(175, '(GMT+08:00) Asia/Shanghai', 'Asia/Shanghai'),
(176, '(GMT+08:00) Asia/Taipei', 'Asia/Taipei'),
(177, '(GMT+08:00) Beijing', 'Asia/Hong_Kong'),
(178, '(GMT+08:00) Chongqing', 'Asia/Chongqing'),
(179, '(GMT+08:00) Hong Kong', 'Asia/Hong_Kong'),
(180, '(GMT+08:00) Irkutsk', 'Asia/Irkutsk'),
(181, '(GMT+08:00) Kuala Lumpur', 'Asia/Kuala_Lumpur'),
(182, '(GMT+08:00) Perth', 'Australia/Perth'),
(183, '(GMT+08:00) Singapore', 'Asia/Singapore'),
(184, '(GMT+08:00) Taipei', 'Asia/Taipei'),
(185, '(GMT+08:00) Ulaan Bataar', 'Asia/Ulan_Bator'),
(186, '(GMT+09:00) Asia/Seoul', 'Asia/Seoul'),
(187, '(GMT+09:00) Asia/Tokyo', 'Asia/Tokyo'),
(188, '(GMT+09:00) Osaka', 'Asia/Tokyo'),
(189, '(GMT+09:00) Sapporo', 'Asia/Tokyo'),
(190, '(GMT+09:00) Seoul', 'Asia/Seoul'),
(191, '(GMT+09:00) Tokyo', 'Asia/Tokyo'),
(192, '(GMT+09:00) Yakutsk', 'Asia/Yakutsk'),
(193, '(GMT+09:30) Adelaide', 'Australia/Adelaide'),
(194, '(GMT+09:30) Darwin', 'Australia/Darwin'),
(195, '(GMT+10:00) Australia/Brisbane', 'Australia/Brisbane'),
(196, '(GMT+10:00) Australia/Hobart', 'Australia/Hobart'),
(197, '(GMT+10:00) Australia/Melbourne', 'Australia/Melbourne'),
(198, '(GMT+10:00) Australia/Sydney', 'Australia/Sydney'),
(199, '(GMT+10:00) Brisbane', 'Australia/Brisbane'),
(200, '(GMT+10:00) Canberra', 'Australia/Canberra'),
(201, '(GMT+10:00) Guam', 'Pacific/Guam'),
(202, '(GMT+10:00) Hobart', 'Australia/Hobart'),
(203, '(GMT+10:00) Magadan', 'Asia/Magadan'),
(204, '(GMT+10:00) Melbourne', 'Australia/Melbourne'),
(205, '(GMT+10:00) Port Moresby', 'Pacific/Port_Moresby'),
(206, '(GMT+10:00) Solomon Is.', 'Asia/Magadan'),
(207, '(GMT+10:00) Sydney', 'Australia/Sydney'),
(208, '(GMT+10:00) Vladivostok', 'Asia/Vladivostok'),
(209, '(GMT+11:00) New Caledonia', 'Asia/Magadan'),
(210, '(GMT+12:00) Auckland', 'Pacific/Auckland'),
(211, '(GMT+12:00) Fiji', 'Pacific/Fiji'),
(212, '(GMT+12:00) Kamchatka', 'Asia/Kamchatka'),
(213, '(GMT+12:00) Marshall Is.', 'Pacific/Fiji'),
(214, '(GMT+12:00) Pacific/Auckland', 'Pacific/Auckland'),
(215, '(GMT+12:00) Wellington', 'Pacific/Auckland'),
(216, '(GMT+13:00) Nuku&#39;alofa', 'Pacific/Tongatapu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formatted_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `formatted_phone`, `carrier_code`, `default_country`, `password`, `profile_image`, `balance`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Lev', 'Hatfield', 'mihuga@mailinator.com', '2489616652', '+12489616652', '1', 'us', '$2y$10$FOwK0RrV1g2QIaJ4/vCSEeTEjWzZQFEO5mW1jW1YpNQ4x65UTvgja', NULL, 0, 'Active', NULL, '2022-09-05 07:55:22', '2022-09-05 07:55:22'),
(2, 'Merritt', 'Reid', 'hyveqahexe@mailinator.com', '2319416628', '+12319416628', '1', 'us', '$2y$10$YvvWtfVxjy4YfWgM/7uA2uzgOS0Y.TiLCGkTL9HcVCcU34QMYx.rG', NULL, 0, 'Active', NULL, '2022-09-05 07:55:38', '2022-09-05 09:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `users_verification`
--

CREATE TABLE `users_verification` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `facebook` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `google` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `linkedin` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `phone` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `fb_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_verification`
--

INSERT INTO `users_verification` (`id`, `user_id`, `email`, `facebook`, `google`, `linkedin`, `phone`, `fb_id`, `google_id`, `linkedin_id`) VALUES
(1, 1, 'no', 'no', 'no', 'no', 'no', NULL, NULL, NULL),
(2, 2, 'no', 'no', 'no', 'no', 'no', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `field` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `balance` decimal(8,2) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `currency_id`, `balance`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0.00', 1, '2022-09-05 07:55:22', '2022-09-05 07:55:22'),
(2, 2, 1, '0.00', 1, '2022-09-05 07:55:38', '2022-09-05 07:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payout_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `uuid` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `payment_method_info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `swift_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Success','Refund','Blocked') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username_unique` (`username`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_type`
--
ALTER TABLE `amenity_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_dates`
--
ALTER TABLE `bank_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bed_type`
--
ALTER TABLE `bed_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_short_name_unique` (`short_name`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency_code_unique` (`code`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_type`
--
ALTER TABLE `message_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout_penalties`
--
ALTER TABLE `payout_penalties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout_settings`
--
ALTER TABLE `payout_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_address`
--
ALTER TABLE `property_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_beds`
--
ALTER TABLE `property_beds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_dates`
--
ALTER TABLE `property_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_description`
--
ALTER TABLE `property_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_details`
--
ALTER TABLE `property_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_fees`
--
ALTER TABLE `property_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_icalimports`
--
ALTER TABLE `property_icalimports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_photos`
--
ALTER TABLE `property_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_price`
--
ALTER TABLE `property_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_rules`
--
ALTER TABLE `property_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_steps`
--
ALTER TABLE `property_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_admin`
--
ALTER TABLE `role_admin`
  ADD PRIMARY KEY (`admin_id`,`role_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_metas`
--
ALTER TABLE `seo_metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `space_type`
--
ALTER TABLE `space_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `starting_cities`
--
ALTER TABLE `starting_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezone`
--
ALTER TABLE `timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_verification`
--
ALTER TABLE `users_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `amenity_type`
--
ALTER TABLE `amenity_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_dates`
--
ALTER TABLE `bank_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_type`
--
ALTER TABLE `message_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payout_penalties`
--
ALTER TABLE `payout_penalties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payout_settings`
--
ALTER TABLE `payout_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_address`
--
ALTER TABLE `property_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_beds`
--
ALTER TABLE `property_beds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_dates`
--
ALTER TABLE `property_dates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_description`
--
ALTER TABLE `property_description`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_details`
--
ALTER TABLE `property_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_fees`
--
ALTER TABLE `property_fees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `property_icalimports`
--
ALTER TABLE `property_icalimports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_photos`
--
ALTER TABLE `property_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_price`
--
ALTER TABLE `property_price`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_rules`
--
ALTER TABLE `property_rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_steps`
--
ALTER TABLE `property_steps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seo_metas`
--
ALTER TABLE `seo_metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `space_type`
--
ALTER TABLE `space_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `starting_cities`
--
ALTER TABLE `starting_cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timezone`
--
ALTER TABLE `timezone`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_verification`
--
ALTER TABLE `users_verification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
