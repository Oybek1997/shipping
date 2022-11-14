-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 14 2021 г., 11:29
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d20`
--

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `model_name` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('008c4e8d25b788f48ac9b16ac1f9476e31495e7ab7a46cb412590ee9e1cbac022d1412bb55812bad', 1, 2, NULL, '[]', 0, '2021-02-25 04:52:30', '2021-02-25 04:52:30', '2022-02-25 09:52:30'),
('0290049d68ab30954713a67d5488cd710113d90eb806c1c74cb6e1d0dc0ebc0696cae2a7bfa11be7', 1, 2, NULL, '[]', 0, '2021-02-25 04:21:35', '2021-02-25 04:21:35', '2022-02-25 09:21:35'),
('05e68dd973d383fcd0462339a844a73534243167bf1063ab535f655aa8e795526586ffcda78401b5', 1, 2, NULL, '[]', 0, '2021-02-25 05:28:13', '2021-02-25 05:28:13', '2022-02-25 10:28:13'),
('07847a1e1dfa27e27c1619c373500dc2c1a0029c2797030e6a09f1856f70597cba5f4308f4c19335', 1, 2, NULL, '[]', 0, '2021-02-25 05:27:29', '2021-02-25 05:27:29', '2022-02-25 10:27:29'),
('0a2c127b77d0d7f3a17dd063fa46bf896dbe6cfdd3e8e6e71bb6229a70970235c00c4b1f8836e5f4', 1, 2, NULL, '[]', 0, '2021-02-25 04:54:07', '2021-02-25 04:54:07', '2022-02-25 09:54:07'),
('0fc06f807339e4196be7663cabada2945d0dcde5cf301b9a615994f2d13ae2a53dcd514c2203bc5a', 5, 2, NULL, '[]', 0, '2021-03-04 05:06:30', '2021-03-04 05:06:30', '2022-03-04 10:06:30'),
('0ffb282b61d3c4e100a5f93f273c9125f74de860093f3d4232e69d0353f4102938824703d12d5bee', 1, 2, NULL, '[]', 0, '2021-02-26 00:05:55', '2021-02-26 00:05:55', '2022-02-26 05:05:55'),
('16a9134f5269789829a1f326b5931cb631e2bc864bed14fcf0a2ca48db668d5a15f152930f1a5635', 1, 2, NULL, '[]', 0, '2021-02-26 01:53:03', '2021-02-26 01:53:03', '2022-02-26 06:53:03'),
('1baa835c789f05a0b428ca38a15227ae35046bacc2394c1a3b4b6ac2c0ebc838a9515bd2dd01494c', 1, 2, NULL, '[]', 0, '2021-02-25 06:48:22', '2021-02-25 06:48:22', '2022-02-25 11:48:22'),
('219114b12863b6caa7367dee8f29bbc39b4f71f2893a102ba895b591ceeab2983f40a896d6e2286a', 1, 2, NULL, '[]', 0, '2021-02-25 04:18:58', '2021-02-25 04:18:58', '2022-02-25 09:18:58'),
('21990a2c202a7e445dfc934ab3b4fc2fee037b198f97b41249957edc155f3560cea8fb978ae2edb4', 1, 2, NULL, '[]', 0, '2021-02-25 04:23:57', '2021-02-25 04:23:57', '2022-02-25 09:23:57'),
('2560c9eff142bf9eb9b73d035109a348f3a5438853c37bf8365cde09bb073970eb04f514d1eb4fa6', 1, 2, NULL, '[]', 0, '2021-02-25 06:46:10', '2021-02-25 06:46:10', '2022-02-25 11:46:10'),
('29362c785312d2fe9595169f93d7bea1544844ef69dfc04b8f6316f6fb79732ddb4679b177421bec', 1, 2, NULL, '[]', 0, '2021-03-03 22:01:15', '2021-03-03 22:01:15', '2022-03-04 03:01:15'),
('3154c3c84ff08b67f0cc56234fdf9733f577eeece6ee8174a0b90728ca1e987cf1f17bfc30671b5e', 1, 2, NULL, '[]', 0, '2021-02-25 06:28:16', '2021-02-25 06:28:16', '2022-02-25 11:28:16'),
('3ed97f61bd48e699b4eea85ba61c4ef4ca6ccab096dbc7d57ab6a3e5a56e7844351f133db145fc60', 1, 2, NULL, '[]', 0, '2021-02-25 06:46:15', '2021-02-25 06:46:15', '2022-02-25 11:46:15'),
('3fe18d2bec5262778c200be1f8b43e9b32171ae20a86eeabdf5c22eee57182c7abfa65db6f5df2b1', 1, 2, NULL, '[]', 0, '2021-02-25 05:42:06', '2021-02-25 05:42:06', '2022-02-25 10:42:06'),
('43dd5615505bb7790ec74449b2e730de155503729964d380dba68becfc48573d0bd86e4276d4e6ce', 1, 2, NULL, '[]', 0, '2021-02-25 05:41:56', '2021-02-25 05:41:56', '2022-02-25 10:41:56'),
('450bbad9d1bb09fcd794a95d2e0998a3b64d58306e6ec12745e8c800ec72ecc8658f7ce65729d8b1', 5, 2, NULL, '[]', 0, '2021-06-10 01:48:19', '2021-06-10 01:48:19', '2022-06-10 06:48:19'),
('45311741f81aa48618a9d2eb1473fdcfe45ba753fd75f43eb3548deec47c9fc402394735297b0658', 1, 2, NULL, '[]', 0, '2021-02-25 06:47:13', '2021-02-25 06:47:13', '2022-02-25 11:47:13'),
('4ada730dbea7483492483812bc64e9b39db57aead75341c33a79368c3e5f616e498920ca74455a6e', 1, 2, NULL, '[]', 0, '2021-02-25 23:32:34', '2021-02-25 23:32:34', '2022-02-26 04:32:34'),
('4b09267bbca42cc26a2c21aa38bc071271f4335641e2814d80c136a2743ca0c57f2018943b723359', 1, 2, NULL, '[]', 0, '2021-02-25 23:01:36', '2021-02-25 23:01:36', '2022-02-26 04:01:36'),
('507a020f6dd1c68ecfb12bd7817896798b554938ea85ea77332c76cdd066fcf5f2f8145f8c6ec989', 1, 2, NULL, '[]', 0, '2021-02-25 23:21:12', '2021-02-25 23:21:12', '2022-02-26 04:21:12'),
('5136455bcca5338ea638542c649fa0ed65b71178530948dfd0781029f4a61a80079ae7a47e9e27fc', 1, 2, NULL, '[]', 0, '2021-02-25 22:18:30', '2021-02-25 22:18:30', '2022-02-26 03:18:30'),
('5804a06b2c76ae87d6310dddb5676c49f3739bd88de3324170c5231476d597035cecb30f38e070e0', 1, 2, NULL, '[]', 0, '2021-02-25 04:18:54', '2021-02-25 04:18:54', '2022-02-25 09:18:54'),
('5b2e818086d59302d14a3681e93d4ce35d0271a257069cd71c2475c7517dd756e9eed8372d908549', 1, 2, NULL, '[]', 0, '2021-03-01 22:39:02', '2021-03-01 22:39:02', '2022-03-02 03:39:02'),
('5bc0e1238a86a601cc874723d9553c6bc5e207a9ab0324efbea63b9290233e15084ebffc3373cc5e', 1, 2, NULL, '[]', 0, '2021-02-25 04:46:09', '2021-02-25 04:46:09', '2022-02-25 09:46:09'),
('63c85edebe0297abd247903cf9fa6a589fbe4399ae099e3bd6d3cb9ab1f71f8f02645f0e69ba8f16', 1, 2, NULL, '[]', 0, '2021-02-25 04:16:30', '2021-02-25 04:16:30', '2022-02-25 09:16:30'),
('6555a4a33547268c76019344b92729823ea2005d338e4a61c7ef65e7ca10429af037bb500e0a8431', 1, 2, NULL, '[]', 0, '2021-02-25 04:50:30', '2021-02-25 04:50:30', '2022-02-25 09:50:30'),
('65e87cba0544a6dd94aef4007fbc65875eecfc8c407e3f8567944f7227af6489b618b05271052b7f', 1, 2, NULL, '[]', 0, '2021-02-25 22:41:18', '2021-02-25 22:41:18', '2022-02-26 03:41:18'),
('6b34c21a3dccb9ddcf69fae90ce17dca7d2df486f0c6740f65e561afd63e9dabad33fcc2b4196539', 1, 2, NULL, '[]', 0, '2021-03-02 03:50:56', '2021-03-02 03:50:56', '2022-03-02 08:50:56'),
('6cdb6ac8bc6f87830c8214519f8160ba2197493425b1cf7fc17e8f9ba9c1320ec036e01ba970df9a', 1, 2, NULL, '[]', 0, '2021-02-25 04:54:14', '2021-02-25 04:54:14', '2022-02-25 09:54:14'),
('796fa2168d1856731ff505dcbc771d452d5d96d27dd8922ccec74f9297a7fe89c3cd5a17de6b14c4', 1, 2, NULL, '[]', 0, '2021-02-25 03:48:06', '2021-02-25 03:48:06', '2022-02-25 08:48:06'),
('799645cbc4219bea1332ca9cb1eadaa7b16260db70651087cad46c1fbc320e4192e6bc517fc0b095', 5, 2, NULL, '[]', 0, '2021-03-04 22:20:40', '2021-03-04 22:20:40', '2022-03-05 03:20:40'),
('808b2bc8ebcb6f1a53e215be3cd251a91f643e10c49ba072a1560ccc75ce21e5609c5728b1197c52', 5, 2, NULL, '[]', 0, '2021-07-03 05:19:30', '2021-07-03 05:19:30', '2022-07-03 10:19:30'),
('8414a81def0b7a3625da65e37b491f5849da2c8a5912c8f1e892c3cd0db85cf52381cdc486291c02', 5, 2, NULL, '[]', 0, '2021-04-06 09:20:35', '2021-04-06 09:20:35', '2022-04-06 14:20:35'),
('8a7e1c333a6d077443264454a0c21c6ef3da068b1646c58ef371422de14411ce3b9c508102b8c098', 1, 2, NULL, '[]', 0, '2021-02-25 06:20:09', '2021-02-25 06:20:09', '2022-02-25 11:20:09'),
('923a65dbb880da1ed2dc9489aca0467e5eab6483bde6dcefcc69d9d352a664d4c46fc23314c8f0c2', 1, 2, NULL, '[]', 0, '2021-02-25 23:26:22', '2021-02-25 23:26:22', '2022-02-26 04:26:22'),
('97839a2aa72e8911e829123468d755bb7a550023e8c4615f8bdde3230f9c8ed802cc4605e4c1bf80', 5, 2, NULL, '[]', 0, '2021-04-06 09:20:53', '2021-04-06 09:20:53', '2022-04-06 14:20:53'),
('985b8ad638574241023932efc72852274db8a33559ed10b44860165362e9f32233cadc1c2ba10f20', 1, 2, NULL, '[]', 0, '2021-02-25 04:14:13', '2021-02-25 04:14:13', '2022-02-25 09:14:13'),
('9af5754722b8eb00642eff55a57bab9db8f7b51a4e518c22e942240b72908e57bd839e6b511f35d3', 5, 2, NULL, '[]', 0, '2021-03-04 00:22:38', '2021-03-04 00:22:38', '2022-03-04 05:22:38'),
('9af63cf536d4e5ff440e8803a74bc082d5ef5529ff9c125ac8bd82811afce4efecb840456a3921d4', 1, 2, NULL, '[]', 0, '2021-02-25 07:01:51', '2021-02-25 07:01:51', '2022-02-25 12:01:51'),
('9db133fb5c0d557d78ad5a5b2ad2ca957a96ac849bafbe91e641785e532516bbff280d30b7f3faa3', 1, 2, NULL, '[]', 0, '2021-02-25 07:07:49', '2021-02-25 07:07:49', '2022-02-25 12:07:49'),
('a1790274946f6051d13f369ab9bf0ce33e6f2f5638e36b568aac2488544d6b1140d71d13ec3582ec', 1, 2, NULL, '[]', 0, '2021-02-25 04:06:34', '2021-02-25 04:06:34', '2022-02-25 09:06:34'),
('a17c3700af6294aa4f4a9cf6ed370f9e67f382d132ed0795377bcdac0f76043922a911f9cc96e60b', 1, 2, NULL, '[]', 0, '2021-02-25 04:55:02', '2021-02-25 04:55:02', '2022-02-25 09:55:02'),
('a5ae917b57662f0345346bb6590f0cbb2fd69493de1b7f24b748df689cc84c4800ad2ce5a55c518d', 1, 2, NULL, '[]', 0, '2021-02-25 04:06:38', '2021-02-25 04:06:38', '2022-02-25 09:06:38'),
('a878001161e16f7dffada78a98035471eacad7a4cfc80051e5bda5ade5d3f974bc72b780fb6f8d49', 1, 2, NULL, '[]', 0, '2021-02-25 04:41:06', '2021-02-25 04:41:06', '2022-02-25 09:41:06'),
('aa9b66b4080002f973e898e0fa61f0428392c3efe16dbb56f06714650e2323a12bc213a64dbb3898', 1, 2, NULL, '[]', 0, '2021-02-25 05:51:23', '2021-02-25 05:51:23', '2022-02-25 10:51:23'),
('ae3601d10ca55c6bd91603e76d9311f016c2efd2d63d64511db0c82db840c65a0a13c4ad8e531605', 1, 2, NULL, '[]', 0, '2021-02-25 05:41:06', '2021-02-25 05:41:06', '2022-02-25 10:41:06'),
('b3848e323ceca4044e411c33c5f8ea569dc9bed11027a71af0df25e27567d195b0ae55f87578d19e', 1, 2, NULL, '[]', 0, '2021-02-25 04:53:49', '2021-02-25 04:53:49', '2022-02-25 09:53:49'),
('b3bfa75b21b812fd6664cb4ad424e34a204b30282395741b862a200699522cba3688b08c46d6e67c', 1, 2, NULL, '[]', 0, '2021-02-25 05:49:23', '2021-02-25 05:49:23', '2022-02-25 10:49:23'),
('b4367c7a409fc1ece6e8eb41079981dd78a1ab75f24564db2fc5053c0cdb4d02f652de53cc144ff8', 1, 2, NULL, '[]', 0, '2021-03-02 05:02:33', '2021-03-02 05:02:33', '2022-03-02 10:02:33'),
('b64045bb41268f411f8cad9a96f82d3c0063b62aa0a2652dc1c124fa6f536edd739d9b5eb9fa170f', 1, 2, NULL, '[]', 0, '2021-02-25 06:28:57', '2021-02-25 06:28:57', '2022-02-25 11:28:57'),
('b81616413f8b402bdc82bd417fd40fb9e05b709e98c10d983cd90ffa5a213a1bec0a9525786048a0', 1, 2, NULL, '[]', 0, '2021-02-25 04:55:21', '2021-02-25 04:55:21', '2022-02-25 09:55:21'),
('bc4b47ca42af478c804eb934d2fc09bc77b958b88646224206e8a0ad70bc43d5db3026ffe0f09c25', 1, 2, NULL, '[]', 0, '2021-02-25 23:33:00', '2021-02-25 23:33:00', '2022-02-26 04:33:00'),
('cc1c50c55ffdeb374a605371e3c48210f9a10905b97bc6aae210738a4ce9c5cfb73482d4d26843de', 1, 2, NULL, '[]', 0, '2021-02-25 04:49:48', '2021-02-25 04:49:48', '2022-02-25 09:49:48'),
('ce346e1cc26cd9072726bed7b2014661f1b001a0bff80f1afce2f2e7dc284f6b56cf1181d23d509e', 5, 2, NULL, '[]', 0, '2021-04-22 01:15:39', '2021-04-22 01:15:39', '2022-04-22 06:15:39'),
('d1dd62fed1ebb88538fa5016dee5207fc1eef09ce4da4ae846b5b7c0d26175eab109b9b4b1933c3f', 1, 2, NULL, '[]', 0, '2021-03-02 22:02:31', '2021-03-02 22:02:31', '2022-03-03 03:02:31'),
('d7ab1995c4794fe3b65475e7a761432e59aefbd0678d9138570dad1a76dd8c14b4847019d5b8bc2a', 1, 2, NULL, '[]', 0, '2021-02-25 04:26:41', '2021-02-25 04:26:41', '2022-02-25 09:26:41'),
('d94a82616631b633b30eb3b615cc8b1ac2d74defdd247697f0b38709956d7f44b58e2c7463536f59', 5, 2, NULL, '[]', 0, '2021-07-03 05:19:41', '2021-07-03 05:19:41', '2022-07-03 10:19:41'),
('db42f288e5306c936b0a6bbf6d2a75738cc85f9b3af392a1540322361980ed18f0aa0e24dcf5ed41', 1, 2, NULL, '[]', 0, '2021-02-25 04:54:13', '2021-02-25 04:54:13', '2022-02-25 09:54:13'),
('e26579d7674d6079de2c4ec9cff5b338d809cb9defccf442e00aab28442dfeb9f327b921d120cebd', 1, 2, NULL, '[]', 0, '2021-02-25 06:36:13', '2021-02-25 06:36:13', '2022-02-25 11:36:13'),
('e6e509b766501ffd4e36f5c924af25102c7ea3f0b8fd5b6ab4a8ab5da8af57761ac6428dc67b7475', 1, 2, NULL, '[]', 0, '2021-02-25 00:17:54', '2021-02-25 00:17:54', '2022-02-25 05:17:54'),
('ed3c937d7d43899294513887fb196d3f2db39ac6e7bbf47bcbe7eee26d6b8b782acfbd95caa24208', 13, 2, NULL, '[]', 0, '2021-03-04 08:52:53', '2021-03-04 08:52:53', '2022-03-04 13:52:53'),
('ee45e5c57f09fec04b15150f050ff3777ebc9df9e74b0cae9484efbcd4769c4aea6c2c191550cfc0', 5, 2, NULL, '[]', 0, '2021-04-29 01:49:30', '2021-04-29 01:49:30', '2022-04-29 06:49:30'),
('f82bbb9ec3147d7f076be9618ce909b111aa3ee2b1506d7a6492b22ca40670b81419f5976c304902', 1, 2, NULL, '[]', 0, '2021-02-25 05:51:05', '2021-02-25 05:51:05', '2022-02-25 10:51:05'),
('fe989b23bbe3b16258bae6fc7cb0deef7386063d13ca6fa78e5f1dbfe52ba34f65baf77e90589580', 1, 2, NULL, '[]', 0, '2021-02-25 06:18:12', '2021-02-25 06:18:12', '2022-02-25 11:18:12'),
('fee20a649a5c4779ef3926a38ba569bb7653bb0d3631e420141e158c73c1d1c3d0ccd58fee8a414d', 1, 2, NULL, '[]', 0, '2021-02-25 06:47:18', '2021-02-25 06:47:18', '2022-02-25 11:47:18');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'X0S8dpGbT4XMBQ07b6swbGEENks71rJPJ20S6ijk', NULL, 'http://localhost', 1, 0, 0, '2021-02-23 06:13:54', '2021-02-23 06:13:54'),
(2, NULL, 'Laravel Password Grant Client', 'UO2wcThDc5rIf7NhZ2Xx7p4pOySAKrokGio6GniT', 'users', 'http://localhost', 0, 1, 0, '2021-02-23 06:13:54', '2021-02-23 06:13:54');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-02-23 06:13:54', '2021-02-23 06:13:54');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('0152b11fce1a3342844b5c32592acca93b81622751f2719957f1bdb4f0b2979fef4d4584c6045b1f', '2560c9eff142bf9eb9b73d035109a348f3a5438853c37bf8365cde09bb073970eb04f514d1eb4fa6', 0, '2022-02-25 11:46:10'),
('042c0ab333fa6bebe915a1b8fd2c5aff02e15134ee9228064f1764f0dfde64ccf6065233367996e4', '9db133fb5c0d557d78ad5a5b2ad2ca957a96ac849bafbe91e641785e532516bbff280d30b7f3faa3', 0, '2022-02-25 12:07:49'),
('0a2c7538fc22aac089f74583fe030992546f29a956dde952f9fe359499016a13494226c9a5c86bc3', '8a7e1c333a6d077443264454a0c21c6ef3da068b1646c58ef371422de14411ce3b9c508102b8c098', 0, '2022-02-25 11:20:09'),
('0b2233d8edf9db65b5a857cd83508c3f91d1c28e8d712f26620bb9476a798b49b1b3d24143f493db', '796fa2168d1856731ff505dcbc771d452d5d96d27dd8922ccec74f9297a7fe89c3cd5a17de6b14c4', 0, '2022-02-25 08:48:06'),
('10921c302100ca0efd8d2e9f1752442ebdaec2c1e5a3377426e653b6275a9daa64840bb46094cf34', 'a878001161e16f7dffada78a98035471eacad7a4cfc80051e5bda5ade5d3f974bc72b780fb6f8d49', 0, '2022-02-25 09:41:06'),
('24aaa088fda2b7db52e6ef54725500ba1d8d4b28c43efc2994fa5ce3b7b713a10100d889d730af88', 'ee45e5c57f09fec04b15150f050ff3777ebc9df9e74b0cae9484efbcd4769c4aea6c2c191550cfc0', 0, '2022-04-29 06:49:30'),
('25c2becf9e6b043fba011852aa366e7894940add7778260c823a56cbeab72cc7b3e0cf476cba69de', '8414a81def0b7a3625da65e37b491f5849da2c8a5912c8f1e892c3cd0db85cf52381cdc486291c02', 0, '2022-04-06 14:20:35'),
('25d9c5cf10e07f1a44dd9a19e28c6110358e4b013ad2b157946937a6cddef8739a602b20e05b87c6', '4b09267bbca42cc26a2c21aa38bc071271f4335641e2814d80c136a2743ca0c57f2018943b723359', 0, '2022-02-26 04:01:36'),
('27cdceede6130549094bb5514075ee9c7546a232c777ac8d211cb33886a2f40dde196cf3d99f4047', 'b4367c7a409fc1ece6e8eb41079981dd78a1ab75f24564db2fc5053c0cdb4d02f652de53cc144ff8', 0, '2022-03-02 10:02:33'),
('3239d631a3c426da1ec2da14ac31f8e3aa20e853661c08890d151ba6a18cfc4f80fe9ad89b75e9ea', 'b64045bb41268f411f8cad9a96f82d3c0063b62aa0a2652dc1c124fa6f536edd739d9b5eb9fa170f', 0, '2022-02-25 11:28:57'),
('329192ce04858c223f6c50091a44d02693f8fe97cc7c1d9392d34a05fbb05179a410eff4a4007e28', '0290049d68ab30954713a67d5488cd710113d90eb806c1c74cb6e1d0dc0ebc0696cae2a7bfa11be7', 0, '2022-02-25 09:21:35'),
('33d46458045849b75a5a5513fe523253adda9dd0aef038b95c0d5766e76c5b3b7cf72bf53c72e882', '05e68dd973d383fcd0462339a844a73534243167bf1063ab535f655aa8e795526586ffcda78401b5', 0, '2022-02-25 10:28:13'),
('34533c89631c47f621ed24e35314e8699d93585490936e2d5acdc60e3fca7ef6c609f55fef0ea0b5', '5b2e818086d59302d14a3681e93d4ce35d0271a257069cd71c2475c7517dd756e9eed8372d908549', 0, '2022-03-02 03:39:02'),
('38f13f5e3089d2b2c1fcb11230c7dd0386434079bdfa01218505aec704f4f3be3bf7ede8abd62acc', 'ed3c937d7d43899294513887fb196d3f2db39ac6e7bbf47bcbe7eee26d6b8b782acfbd95caa24208', 0, '2022-03-04 13:52:53'),
('3a1f065720e4589ced99173cbcf5921f7b92daa25ea0ef9ea880589dea5e3295ffd05b9085d9c43e', '3fe18d2bec5262778c200be1f8b43e9b32171ae20a86eeabdf5c22eee57182c7abfa65db6f5df2b1', 0, '2022-02-25 10:42:06'),
('3ba58efb3ec13864b26d3ec7d0f8c8d74c94756358f238b37da4866ebe84381d4561a26a27e4b831', '5136455bcca5338ea638542c649fa0ed65b71178530948dfd0781029f4a61a80079ae7a47e9e27fc', 0, '2022-02-26 03:18:30'),
('411a266d475aef44dcefbdd4a67ee3ff9a7f1086f9261a6e80ea6bcc0df09f290ad275bb58a36b0c', 'f82bbb9ec3147d7f076be9618ce909b111aa3ee2b1506d7a6492b22ca40670b81419f5976c304902', 0, '2022-02-25 10:51:05'),
('49f0f385fb6f8a5080f11aeadb39319b5f9b002da98867cca774c1a456c423922dfeac7af9b77eb1', '1baa835c789f05a0b428ca38a15227ae35046bacc2394c1a3b4b6ac2c0ebc838a9515bd2dd01494c', 0, '2022-02-25 11:48:22'),
('4b3cbd4fd880df607cce14581a9ff1dc2fed8382189f9ac33b274343530b0821e188b7d07a4aafa6', '45311741f81aa48618a9d2eb1473fdcfe45ba753fd75f43eb3548deec47c9fc402394735297b0658', 0, '2022-02-25 11:47:13'),
('52602860d1fefe584889c6b559356b14c7e6167ba61500ae22d6aaa6e011232bf8255c1efe97af50', 'ce346e1cc26cd9072726bed7b2014661f1b001a0bff80f1afce2f2e7dc284f6b56cf1181d23d509e', 0, '2022-04-22 06:15:39'),
('577836e7ac39cb6562d33d115d41d175db823df19e1350a4f735d3c68724c1761ede7ec2f9caa1d1', '5804a06b2c76ae87d6310dddb5676c49f3739bd88de3324170c5231476d597035cecb30f38e070e0', 0, '2022-02-25 09:18:54'),
('5fd821656a4006d743e31a8841d7a22a6ef8132717e18e7fbab32bd1e837d4b1e92eae9da704b829', '5bc0e1238a86a601cc874723d9553c6bc5e207a9ab0324efbea63b9290233e15084ebffc3373cc5e', 0, '2022-02-25 09:46:09'),
('6054e85d9294460360719861781efa694a3639dbcbdbc25e41920946dc78d1b63d263f63f05f6bde', 'a1790274946f6051d13f369ab9bf0ce33e6f2f5638e36b568aac2488544d6b1140d71d13ec3582ec', 0, '2022-02-25 09:06:34'),
('6670d311cd5f51d455d793015c961b754883ea48db7d22aefc3c597a77855710e4afbf331fb446bb', 'cc1c50c55ffdeb374a605371e3c48210f9a10905b97bc6aae210738a4ce9c5cfb73482d4d26843de', 0, '2022-02-25 09:49:48'),
('699f279547dee5ff49588fd48cc49ee17c753b57a13b9104c3b7e0f59dfeab570c5278d201b4211b', '0a2c127b77d0d7f3a17dd063fa46bf896dbe6cfdd3e8e6e71bb6229a70970235c00c4b1f8836e5f4', 0, '2022-02-25 09:54:07'),
('6bc4d14863211176289ee1754300b683becf64a2375612192bc3f77c33f52e3fd3c26897533f8149', '29362c785312d2fe9595169f93d7bea1544844ef69dfc04b8f6316f6fb79732ddb4679b177421bec', 0, '2022-03-04 03:01:15'),
('6de31135ebf012f7728a802d8e36aadacc9e8179c43324587c281a6d12847888c7b931521f501241', 'b81616413f8b402bdc82bd417fd40fb9e05b709e98c10d983cd90ffa5a213a1bec0a9525786048a0', 0, '2022-02-25 09:55:21'),
('6e706e95249ce80711fa2b466dd19d6b081dead324ef2915a2d0b2ca290c177f49761b6d2577e15c', '985b8ad638574241023932efc72852274db8a33559ed10b44860165362e9f32233cadc1c2ba10f20', 0, '2022-02-25 09:14:13'),
('6f6ed6248007b0987f744c55967e0dae25e7b638bbf3c4526bed79dbb81f3c96ed4de8492650ab13', '07847a1e1dfa27e27c1619c373500dc2c1a0029c2797030e6a09f1856f70597cba5f4308f4c19335', 0, '2022-02-25 10:27:29'),
('73a406a49889f79b074b94380d7769ebfaf5e7c5943af09d0c9962dfb0f77388dc2e310e73f8fe7d', '97839a2aa72e8911e829123468d755bb7a550023e8c4615f8bdde3230f9c8ed802cc4605e4c1bf80', 0, '2022-04-06 14:20:53'),
('7839c904f712e9a93ce9b42234fde00c1a627bd4f8cbc64aeea1503d5c47b602a11099cd47bc4544', 'db42f288e5306c936b0a6bbf6d2a75738cc85f9b3af392a1540322361980ed18f0aa0e24dcf5ed41', 0, '2022-02-25 09:54:13'),
('7f32f59532f405ef8af2b97ba209a1fdbffe9ed8f367fe907ee06d3f2c19556e3cb0610414cee1e0', '0fc06f807339e4196be7663cabada2945d0dcde5cf301b9a615994f2d13ae2a53dcd514c2203bc5a', 0, '2022-03-04 10:06:30'),
('7faed1af01719d886360c2c4e06819bd1355fab0962317f1a9fd9aa78f827c650867d58a07fc4399', '9af63cf536d4e5ff440e8803a74bc082d5ef5529ff9c125ac8bd82811afce4efecb840456a3921d4', 0, '2022-02-25 12:01:51'),
('81310bd548c0a5eb97ec7d7f59807c58142c6f317ecaec7d0043c8dbd72f10deafb2b002188b721a', '008c4e8d25b788f48ac9b16ac1f9476e31495e7ab7a46cb412590ee9e1cbac022d1412bb55812bad', 0, '2022-02-25 09:52:30'),
('829be643448d71731c350ab2d81fb8b14dc39463b2f38a48c2d837e908eaae7dd9190de1618b02a9', 'a5ae917b57662f0345346bb6590f0cbb2fd69493de1b7f24b748df689cc84c4800ad2ce5a55c518d', 0, '2022-02-25 09:06:38'),
('833f3245371367dcae576479ccd3ff7c67cc632680db02997fbe233d0ffdb4e55507a1d3a32dc1af', '6555a4a33547268c76019344b92729823ea2005d338e4a61c7ef65e7ca10429af037bb500e0a8431', 0, '2022-02-25 09:50:30'),
('841e205b4cb5b2f8a3ad48d88f8416b689ac3b9fb2eea9b1513bb76b5e087ee8f2e1b026f1ac7997', 'b3bfa75b21b812fd6664cb4ad424e34a204b30282395741b862a200699522cba3688b08c46d6e67c', 0, '2022-02-25 10:49:23'),
('84fe7d50040ba0ecaab13c63d85f9c792620a780fa174de3effd1b8792aa6489a799aebb9792a2c4', '923a65dbb880da1ed2dc9489aca0467e5eab6483bde6dcefcc69d9d352a664d4c46fc23314c8f0c2', 0, '2022-02-26 04:26:22'),
('8983af86951521d8805422b4cf039d32173816b3bf600cb5cd440c271b07d5bb9bec8355644c3b02', 'ae3601d10ca55c6bd91603e76d9311f016c2efd2d63d64511db0c82db840c65a0a13c4ad8e531605', 0, '2022-02-25 10:41:06'),
('9517711eb0122194552a04fe4b4ea8b9daadf12ca81f77a651eb42519589b9176688616ffe1446da', 'fe989b23bbe3b16258bae6fc7cb0deef7386063d13ca6fa78e5f1dbfe52ba34f65baf77e90589580', 0, '2022-02-25 11:18:12'),
('981f06932a80b2cfad273c5b3626d7509349415f3f6950b56d4a6464384b0378e0736b21d2ab6319', '6cdb6ac8bc6f87830c8214519f8160ba2197493425b1cf7fc17e8f9ba9c1320ec036e01ba970df9a', 0, '2022-02-25 09:54:14'),
('9e5cf1401c0d78b69cc14777569c0f37932550a6ac8223675d7765316936f501066845b6be842ed0', '507a020f6dd1c68ecfb12bd7817896798b554938ea85ea77332c76cdd066fcf5f2f8145f8c6ec989', 0, '2022-02-26 04:21:12'),
('a6729eb23124f956e389a3ad8de40b76d199057dfef9cb9489e0068aae6cd4d54cab3500360e5428', '63c85edebe0297abd247903cf9fa6a589fbe4399ae099e3bd6d3cb9ab1f71f8f02645f0e69ba8f16', 0, '2022-02-25 09:16:30'),
('a736785cb39ba8b12bee7db02a11e6b916db60318cd2332421dd579974b594b5518b29b4028c126d', '16a9134f5269789829a1f326b5931cb631e2bc864bed14fcf0a2ca48db668d5a15f152930f1a5635', 0, '2022-02-26 06:53:03'),
('ab4b4b869990b1d1d71326bf99f87bd944a0664d5018ed89b05b1bbb50224180376b0688731b37dd', 'd1dd62fed1ebb88538fa5016dee5207fc1eef09ce4da4ae846b5b7c0d26175eab109b9b4b1933c3f', 0, '2022-03-03 03:02:31'),
('ab96d7e46a590b98092198d6a107dd4b231869638fdb61aa65d924df8b0ba9c9b757fae6d97a3a66', '219114b12863b6caa7367dee8f29bbc39b4f71f2893a102ba895b591ceeab2983f40a896d6e2286a', 0, '2022-02-25 09:18:58'),
('ac027d72dc8d6986e8dc857894e3140fdfe2ce3a1b56f9476fda3b490a190da0814cb750b80a3576', '21990a2c202a7e445dfc934ab3b4fc2fee037b198f97b41249957edc155f3560cea8fb978ae2edb4', 0, '2022-02-25 09:23:57'),
('ad3bc71c50aad535b71725b5034be05070153bb57e3b0beb4a815b296d588992c0e05c5481488420', 'aa9b66b4080002f973e898e0fa61f0428392c3efe16dbb56f06714650e2323a12bc213a64dbb3898', 0, '2022-02-25 10:51:23'),
('b59e85cd192a0313612813994a6d83781ba73a193bd0ab8d52bdfa78bd6b5b92f4f218013c2e6f13', '3ed97f61bd48e699b4eea85ba61c4ef4ca6ccab096dbc7d57ab6a3e5a56e7844351f133db145fc60', 0, '2022-02-25 11:46:15'),
('b6b480a440e711585268767312de48abc6de9a2acdd01841a9d30170cda876d468919f601f446d48', '6b34c21a3dccb9ddcf69fae90ce17dca7d2df486f0c6740f65e561afd63e9dabad33fcc2b4196539', 0, '2022-03-02 08:50:56'),
('bdb4c292b4ff4931139f266358831fb6100e49e5d2cf87df844f066b3ffca2981ffaaf0d2446f291', '808b2bc8ebcb6f1a53e215be3cd251a91f643e10c49ba072a1560ccc75ce21e5609c5728b1197c52', 0, '2022-07-03 10:19:31'),
('bdea6a297723250adc3961cd86c1fffcb37eaafb11862b9a6e8ad87c27982a87258621e8aabf7ae3', '0ffb282b61d3c4e100a5f93f273c9125f74de860093f3d4232e69d0353f4102938824703d12d5bee', 0, '2022-02-26 05:05:55'),
('c290ed056a4cca065e24e92462f1f59afa0f2300260522a635c91465da7ab2c4714eea3a06f729ac', 'e6e509b766501ffd4e36f5c924af25102c7ea3f0b8fd5b6ab4a8ab5da8af57761ac6428dc67b7475', 0, '2022-02-25 05:17:54'),
('d0bfb66606bfe95c257810b294f77d8dbb9964537b5d16f8c018be5eeb101facd93788c1f5ebab0a', 'a17c3700af6294aa4f4a9cf6ed370f9e67f382d132ed0795377bcdac0f76043922a911f9cc96e60b', 0, '2022-02-25 09:55:02'),
('d433969c86df5296912777de031d3b4b4e77d9eb9763c3c2201b8961b77cf09404e1579bb410a1f5', 'b3848e323ceca4044e411c33c5f8ea569dc9bed11027a71af0df25e27567d195b0ae55f87578d19e', 0, '2022-02-25 09:53:49'),
('daad5c335d20393bc849a91d3615a798afd28636a9205539d8f43867c661b8a9eb6f1f738d177fb5', '43dd5615505bb7790ec74449b2e730de155503729964d380dba68becfc48573d0bd86e4276d4e6ce', 0, '2022-02-25 10:41:56'),
('db0ecf7ca44cc21e9345fbe294d1955b9eb02500bed48a402c8b50a74b7ee2a1ffe4137c24e193c0', '3154c3c84ff08b67f0cc56234fdf9733f577eeece6ee8174a0b90728ca1e987cf1f17bfc30671b5e', 0, '2022-02-25 11:28:16'),
('db56dcbe0de3675b702f9e18d902e05a1599147afa06b98ec57b0713524ccb3e4f18810d29e9fe30', '4ada730dbea7483492483812bc64e9b39db57aead75341c33a79368c3e5f616e498920ca74455a6e', 0, '2022-02-26 04:32:34'),
('dbc3dfb30be51a0a29d8140b3f80d859d8c41ce05a97d6d79f0e6a31f9fcf1577374ef9b883c1b84', 'd7ab1995c4794fe3b65475e7a761432e59aefbd0678d9138570dad1a76dd8c14b4847019d5b8bc2a', 0, '2022-02-25 09:26:41'),
('e104200160307827f9eef9f4d096723887a08b466e9fc0b5d9f7332a02316a8ede65c58f6535fb30', 'bc4b47ca42af478c804eb934d2fc09bc77b958b88646224206e8a0ad70bc43d5db3026ffe0f09c25', 0, '2022-02-26 04:33:00'),
('e49db502821858c7725a58c28d847fd49f65e6c3597c512d915e0419bca48917193092e0e706d0d3', 'e26579d7674d6079de2c4ec9cff5b338d809cb9defccf442e00aab28442dfeb9f327b921d120cebd', 0, '2022-02-25 11:36:13'),
('ea6f13e812b536e36cd50f735460eb810a108a1bd6419f14a1efda570f781825722cefc69ea38dbf', '65e87cba0544a6dd94aef4007fbc65875eecfc8c407e3f8567944f7227af6489b618b05271052b7f', 0, '2022-02-26 03:41:19'),
('ebf2b069e2c12cc57d77570d8e3602b3882133f5940d999913d9f99affa88ada485146fe9f91c5e4', '799645cbc4219bea1332ca9cb1eadaa7b16260db70651087cad46c1fbc320e4192e6bc517fc0b095', 0, '2022-03-05 03:20:40'),
('ee205a4c03fac3092f1a020ecf2fafc0dc522f81422d3959087503d3d43b4e10dce18055a11b6af2', '450bbad9d1bb09fcd794a95d2e0998a3b64d58306e6ec12745e8c800ec72ecc8658f7ce65729d8b1', 0, '2022-06-10 06:48:20'),
('f38598b811cf5850bd7b354d2265f0a8c18fdd3a6b210a65630cd023ea1269e8215723ba6c2b7ade', 'd94a82616631b633b30eb3b615cc8b1ac2d74defdd247697f0b38709956d7f44b58e2c7463536f59', 0, '2022-07-03 10:19:41'),
('fd34afdd442d9e8e55f6cd3f0802d25d50c81d5bb9fe4eb45c718879d45bd10770175fe5034ac6e1', '9af5754722b8eb00642eff55a57bab9db8f7b51a4e518c22e942240b72908e57bd839e6b511f35d3', 0, '2022-03-04 05:22:38'),
('fed8b41e0a7f316e1088fb4782c18dac5285e60620c8a62256cccb0af1c2448f51cc519d2df888e1', 'fee20a649a5c4779ef3926a38ba569bb7653bb0d3631e420141e158c73c1d1c3d0ccd58fee8a414d', 0, '2022-02-25 11:47:18');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'SD6566', 'Sardor Dexkonov', 'Sardor.Dexkonov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 00:14:10', '2021-03-04 00:14:10'),
(10, 'AK6565', 'Anvarjon Komilov', 'Anvarjon.Komilov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 00:24:12', '2021-03-04 00:24:12'),
(11, 'EQ6563', 'Erkinjon Qaxxarov', 'Erkinjon.Qaxxarov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 00:26:01', '2021-03-04 00:26:01'),
(13, 'IMB727', 'Islombek Makhkamov', 'Islombek.Makhkamov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 08:52:35', '2021-03-04 08:52:35'),
(14, 'SA6567', 'Shoxrux Azimjonov', 'Shoxrux.Azimjonov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 08:54:01', '2021-03-04 08:54:01'),
(15, 'DK6564', 'Doniyorbek Karimov', 'Doniyorbek.Karimov@uzautomotors.com', NULL, NULL, NULL, '2021-03-04 08:54:19', '2021-03-04 08:54:19'),
(16, 'QG9592', 'Qodirjon Gofurjonov', 'qodirjon.gofurjonov@uzautomotors.com', NULL, NULL, NULL, '2021-04-06 09:21:53', '2021-04-06 09:21:53'),
(17, 'NO5595', 'Nozimjon Olimov', 'Nozimjon.Olimov@uzautomotors.com', NULL, NULL, NULL, '2021-04-06 09:22:39', '2021-04-06 09:22:39');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
