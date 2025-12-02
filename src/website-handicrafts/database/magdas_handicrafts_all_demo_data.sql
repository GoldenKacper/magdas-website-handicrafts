-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2025 at 11:56 PM
-- Wersja serwera: 10.11.14-MariaDB-cll-lve
-- Wersja PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `host108162_magdas_handicrafts`
--

--
-- Zrzut danych tabeli `about_mes`
--

INSERT INTO `about_mes` (`id`, `about_author_image`, `created_at`, `updated_at`) VALUES
(1, 'images/about/magdas_website_home_about_me_author_01_09_2025_demo.png', '2025-09-13 11:28:41', '2025-09-13 11:28:41');

--
-- Zrzut danych tabeli `about_me_translations`
--

INSERT INTO `about_me_translations` (`id`, `about_me_id`, `about_author_image_alt`, `content`, `main_page`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Zdjęcie autorki Magdy', 'Cześć — nazywam się Magda. Tworzę ręcznie robioną biżuterię: małe bransoletki i naszyjniki robione z pasją. Każdy egzemplarz powstaje z dbałością o szczegóły, z wysokiej jakości materiałów — idealny na prezent lub osobisty dodatek. Zapraszam do zapoznania się z moją galerią i skontaktowania się w sprawie zamówień.', 1, 1, 1, 'pl', '2025-09-13 11:28:41', '2025-09-13 11:28:41'),
(2, 1, 'Author\'s portrait photo', 'Hi — I\'m Magda. I handcraft small bracelets and necklaces with care and attention to detail. Each piece is made from quality materials and is perfect as a gift or a personal accessory. Browse my gallery and feel free to contact me for commissions.', 1, 1, 1, 'en', '2025-09-13 11:28:42', '2025-09-13 11:28:42'),
(3, 1, 'Zdjęcie autorki Magdy', 'Cześć — nazywam się Magda. Tworzę ręcznie robioną biżuterię: małe bransoletki i naszyjniki robione z pasją. Każdy egzemplarz powstaje z dbałością o szczegóły, z wysokiej jakości materiałów — idealny na prezent lub osobisty dodatek. Zapraszam do zapoznania się z moją galerią i skontaktowania się w sprawie zamówień.', 0, 2, 1, 'pl', '2025-09-13 11:28:42', '2025-09-13 11:28:42'),
(4, 1, 'Author\'s portrait photo', 'Hi — I\'m Magda. I handcraft small bracelets and necklaces with care and attention to detail. Each piece is made from quality materials and is perfect as a gift or a personal accessory. Browse my gallery and feel free to contact me for commissions.', 0, 2, 1, 'en', '2025-09-13 11:28:42', '2025-09-13 11:28:42'),
(5, 1, 'Zdjęcie autorki Magdy', 'Cześć — nazywam się Magda. Tworzę ręcznie robioną biżuterię: małe bransoletki i naszyjniki robione z pasją. Każdy egzemplarz powstaje z dbałością o szczegóły, z wysokiej jakości materiałów — idealny na prezent lub osobisty dodatek. Zapraszam do zapoznania się z moją galerią i skontaktowania się w sprawie zamówień.', 0, 3, 1, 'pl', '2025-09-13 11:28:42', '2025-09-13 11:28:42'),
(6, 1, 'Author\'s portrait photo', 'Hi — I\'m Magda. I handcraft small bracelets and necklaces with care and attention to detail. Each piece is made from quality materials and is perfect as a gift or a personal accessory. Browse my gallery and feel free to contact me for commissions.', 0, 3, 1, 'en', '2025-09-13 11:28:42', '2025-09-13 11:28:42');

--
-- Zrzut danych tabeli `availabilities`
--

INSERT INTO `availabilities` (`id`, `code`, `label`, `is_active`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'available_pl', 'Dostępny', 1, 'pl', '2025-09-13 13:45:55', '2025-09-13 13:45:55'),
(2, 'available_en', 'Available', 1, 'en', '2025-09-13 13:45:55', '2025-09-13 13:45:55'),
(3, 'unavailable_pl', 'Niedostępny', 1, 'pl', '2025-09-13 13:45:55', '2025-09-13 13:45:55'),
(4, 'unavailable_en', 'Unavailable', 1, 'en', '2025-09-13 13:45:55', '2025-09-13 13:45:55'),
(5, 'temporarily_unavailable_pl', 'Tymczasowo niedostępny ', 1, 'pl', '2025-09-13 13:45:55', '2025-09-13 13:45:55'),
(6, 'temporarily_unavailable_en', 'Temporarily unavailable', 1, 'en', '2025-09-13 13:45:55', '2025-09-13 13:45:55');

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`id`, `image`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'images/categories/magdas_website_offer_bracelet_31_08_2025_demo.png', 'gallery-bracelets', '2025-09-12 07:11:48', '2025-09-12 07:11:48'),
(2, 'images/categories/magdas_website_offer_necklace_31_08_2025_demo.png', 'gallery-necklaces', '2025-09-12 07:15:44', '2025-09-12 07:15:44'),
(3, 'images/categories/magdas_website_offer_earrings_31_08_2025_demo.png', 'gallery-earrings', '2025-09-12 07:17:54', '2025-09-12 07:17:54');

--
-- Zrzut danych tabeli `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `name`, `image_alt`, `label_meta`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bransoletki', 'Bransoletki rękodzieło - zdjęcie tło kategorii', 'Oferta — bransoletki', 1, 1, 'pl', '2025-09-12 07:11:49', '2025-09-12 07:11:49'),
(2, 1, 'Bracelets', 'Bracelets handmade - category background image', 'Offer — bracelets', 1, 1, 'en', '2025-09-12 07:11:49', '2025-09-12 07:11:49'),
(3, 2, 'Naszyjniki', 'Naszyjniki rękodzieło - zdjęcie tło kategorii', 'Oferta — naszyjniki', 2, 1, 'pl', '2025-09-12 07:15:45', '2025-09-12 07:15:45'),
(4, 2, 'Necklaces', 'Necklaces handmade - category background image', 'Offer — necklaces', 2, 1, 'en', '2025-09-12 07:15:45', '2025-09-12 07:15:45'),
(5, 3, 'Kolczyki', 'Kolczyki rękodzieło - zdjęcie tło kategorii', 'Oferta — kolczyki', 3, 1, 'pl', '2025-09-12 07:17:54', '2025-09-12 07:17:54'),
(6, 3, 'Earrings', 'Earrings handmade - category background image', 'Offer — earrings', 3, 1, 'en', '2025-09-12 07:17:54', '2025-09-12 07:17:54');

--
-- Zrzut danych tabeli `faqs`
--

INSERT INTO `faqs` (`id`, `icon`, `created_at`, `updated_at`) VALUES
(1, '<i class=\"fa-solid fa-circle-question faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:50:38', '2025-09-22 18:50:38'),
(2, '<i class=\"fa-solid fa-shipping-fast faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:50:38', '2025-09-22 18:50:38'),
(3, '<i class=\"fa-solid fa-arrows-rotate faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:52:28', '2025-09-22 18:52:29'),
(4, '<i class=\"fa-solid fa-hand-holding-heart faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:52:29', '2025-09-22 18:52:29'),
(5, '<i class=\"fa-solid fa-award faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:53:51', '2025-09-22 18:53:51'),
(6, '<i class=\"fa-solid fa-ruler faq-q-icon\" aria-hidden=\"true\"></i>', '2025-09-22 18:53:51', '2025-09-22 18:53:51');

--
-- Zrzut danych tabeli `faq_translations`
--

INSERT INTO `faq_translations` (`id`, `faq_id`, `question`, `answer`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jak mogę złożyć zamówienie?', 'Możesz zamówić przez formularz kontaktowy lub bezpośrednio w sklepie —  wybierz produkt, dodaj do koszyka i przejdź do płatności. W razie problemów napisz do nas.', 1, 1, 'pl', '2025-09-22 18:55:36', '2025-09-22 18:55:36'),
(2, 1, 'How can I place an order?', 'You can place your order via the contact form or directly in the store — select the product, add it to your cart, and proceed to checkout. If you encounter any problems, please contact us.', 1, 1, 'en', '2025-09-22 18:55:36', '2025-09-22 18:55:36'),
(3, 2, 'Ile trwa wysyłka?', 'Na ogół wysyłka trwa 2–5 dni roboczych. Dokładny termin zależy od opcji wysyłki i lokalizacji klienta.', 2, 1, 'pl', '2025-09-22 18:59:27', '2025-09-22 18:59:27'),
(4, 2, 'How long does shipping take?', 'Shipping generally takes 2–5 business days. The exact delivery time depends on the shipping option and the customer\'s location.', 2, 1, 'en', '2025-09-22 18:59:27', '2025-09-22 18:59:27'),
(5, 3, 'Czy mogę zwrócić produkt?', 'Tak — przyjmujemy zwroty w ciągu 14 dni od otrzymania, jeśli produkt jest w stanie nienaruszonym.', 3, 1, 'pl', '2025-09-22 19:02:15', '2025-09-22 19:02:15'),
(6, 3, 'Can I return the product?', 'Yes — we accept returns within 14 days of receipt, provided the product is in undamaged condition.', 3, 1, 'en', '2025-09-22 19:02:15', '2025-09-22 19:02:15'),
(7, 4, 'Czy oferujesz personalizacje?', 'Tak — oferuję grawer, dobór kolorów i pudełek — skontaktuj się ze mną, żeby omówić szczegóły.', 4, 1, 'pl', '2025-09-22 19:04:05', '2025-09-22 19:04:05'),
(8, 4, 'Do you offer customization?', 'Yes — I offer engraving, color selection, and boxes—contact me to discuss the details.', 4, 1, 'en', '2025-09-22 19:04:05', '2025-09-22 19:04:05'),
(9, 5, 'Czy produkty mają gwarancję?', 'Tak — wszystkie nasze wyroby objęte są 12-miesięczną gwarancją na wady produkcyjne. Jeśli coś się zdarzy, skontaktuj się z nami — omówimy naprawę lub wymianę.', 5, 1, 'pl', '2025-09-22 19:06:45', '2025-09-22 19:06:45'),
(10, 5, 'Do the products come with a warranty?', 'Yes—all our products come with a 12-month warranty against manufacturing defects. If something happens, please contact us—we will discuss repair or replacement.', 5, 1, 'en', '2025-09-22 19:06:45', '2025-09-22 19:06:45'),
(11, 6, 'Jak dobrać właściwy rozmiar bransoletki?', 'Aby dobrać rozmiar: zmierz obwód nadgarstka miękką taśmą krawiecką lub nitką, a następnie dodaj ~1,5–2 cm luzu dla komfortu. W razie wątpliwości podaj nam pomiar — pomożemy dobrać idealny rozmiar.', 6, 1, 'pl', '2025-09-22 19:08:24', '2025-09-22 19:08:24'),
(12, 6, 'How to choose the right bracelet size?', 'To choose the right size: measure the circumference of your wrist with a soft tape measure or string, then add ~1.5–2 cm of slack for comfort. If in doubt, send us your measurement — we will help you choose the perfect size.', 6, 1, 'en', '2025-09-22 19:08:24', '2025-09-22 19:08:24');

--
-- Zrzut danych tabeli `opinions`
--

INSERT INTO `opinions` (`id`, `image`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'images/opinions/magdas_website_home_1_opinion_02_09_2025.png', 'opinion-kacper', '2025-09-22 19:17:17', '2025-09-22 19:17:17'),
(2, 'images/opinions/magdas_website_home_2_opinion_02_09_2025_demo.png', 'opinion-2', '2025-09-22 19:17:17', '2025-09-22 19:17:17'),
(3, 'images/opinions/magdas_website_home_3_opinion_02_09_2025_demo.jpg', 'opinion-3', '2025-09-22 19:20:44', '2025-09-22 19:20:44'),
(4, 'images/opinions/magdas_website_home_4_opinion_02_09_2025_demo.jpg', 'opinion-4', '2025-09-22 19:20:44', '2025-09-22 19:20:44');

--
-- Zrzut danych tabeli `opinion_translations`
--

INSERT INTO `opinion_translations` (`id`, `opinion_id`, `first_name`, `country_code`, `content`, `image_alt`, `label_meta`, `rating`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kacper', 'pl', 'Piękna, staranna robota — dostałem mnóstwo komplementów. Polecam z całego serca!', 'Zdjęcie Kacpra', 'Opinia Kacpra', 5, 1, 1, 'pl', '2025-09-22 19:22:49', '2025-09-22 19:22:49'),
(2, 1, 'Kacper', 'pl', 'Beautiful, meticulous work — I received many compliments. I wholeheartedly recommend it!', 'Kacper\'s photo', 'Kacper\'s opinion', 5, 1, 1, 'en', '2025-09-22 19:22:49', '2025-09-22 19:22:49'),
(5, 2, 'Katarzyna', 'pl', 'Zamówienie przyszło szybko, wykonanie dokładne. Idealny prezent dla przyjaciółki.', 'Zdjęcie Katarzyny', 'Opinia Katarzyny', 5, 2, 1, 'pl', '2025-09-22 19:27:33', '2025-09-22 19:27:33'),
(6, 2, 'Catherine', 'pl', 'The order arrived quickly and was made with precision. The perfect gift for a friend.', 'Catherine\'s photo', 'Catherine\'s opinion', 5, 2, 1, 'en', '2025-09-22 19:27:33', '2025-09-22 19:27:33'),
(7, 3, 'Michał', 'pl', 'Świetny kontakt, ładne opakowanie i bardzo ładna biżuteria — polecam.', 'Zdjęcie Michała', 'Opinia Michała', 5, 3, 1, 'pl', '2025-09-22 19:32:33', '2025-09-22 19:32:33'),
(8, 3, 'Michael', 'pl', 'Great contact, nice packaging, and very pretty jewelry — I recommend it.', 'Michael\'s photo', 'Michael\'s opinion', 5, 3, 1, 'en', '2025-09-22 19:32:33', '2025-09-22 19:32:33'),
(9, 4, 'Ewa', 'pl', 'Czuć rękodzielniczy charakter i dbałość o szczegóły — zamówię ponownie.', 'Zdjęcie Ewy', 'Opinia Ewy', 5, 4, 1, 'pl', '2025-09-22 19:35:50', '2025-09-22 19:35:50'),
(10, 4, 'Ewa', 'pl', 'You can feel the handcrafted character and attention to detail — I will order again.', 'Ewa\'s photo', 'Ewa\'s opinion', 5, 4, 1, 'en', '2025-09-22 19:35:50', '2025-09-22 19:35:50');

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id`, `category_id`, `default_price`, `default_currency`, `stock_quantity`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 50.00, 'pln', 3, 'bracelets-1', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(2, 1, 40.00, 'pln', 2, 'bracelets-2', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(3, 1, 45.99, 'pln', 1, 'bracelets-3', '2025-09-22 19:42:58', '2025-09-22 19:42:58'),
(4, 2, 50.00, 'pln', 3, 'necklace-1', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(5, 2, 40.00, 'pln', 2, 'necklace-2', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(6, 2, 45.99, 'pln', 1, 'necklace-3', '2025-09-22 19:42:58', '2025-09-22 19:42:58'),
(7, 3, 50.00, 'pln', 3, 'earrings-1', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(8, 3, 40.00, 'pln', 2, 'earrings-2', '2025-09-22 19:40:18', '2025-09-22 19:40:18'),
(9, 3, 45.99, 'pln', 1, 'earrings-3', '2025-09-22 19:42:58', '2025-09-22 19:42:58');

--
-- Zrzut danych tabeli `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'images/products/1.png', 1, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(2, 'images/products/2.png', 1, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(3, 'images/products/3.png', 2, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(4, 'images/products/4.png', 2, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(5, 'images/products/5.png', 3, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(6, 'images/products/6.png', 3, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(7, 'images/products/7.png', 4, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(8, 'images/products/8.png', 4, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(9, 'images/products/9.png', 5, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(10, 'images/products/10.png', 5, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(11, 'images/products/11.png', 6, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(12, 'images/products/12.png', 6, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(13, 'images/products/13.png', 7, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(14, 'images/products/14.png', 7, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(15, 'images/products/15.png', 8, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(16, 'images/products/16.png', 8, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(17, 'images/products/17.png', 9, '2025-09-22 20:12:25', '2025-09-22 20:12:25'),
(18, 'images/products/18.png', 9, '2025-09-22 20:12:25', '2025-09-22 20:12:25');

--
-- Zrzut danych tabeli `product_image_translations`
--

INSERT INTO `product_image_translations` (`id`, `product_image_id`, `image_alt`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pierwsze zdjęcie produktu 1', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(2, 1, 'First photo of product 1', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(7, 2, 'Drugie zdjęcie produktu 1', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(8, 2, 'Second photo of product 1', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(9, 3, 'Pierwsze zdjęcie produktu 2', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(10, 3, 'First photo of product 2', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(11, 4, 'Drugie zdjęcie produktu 2', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(12, 4, 'Second photo of product 2', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(13, 5, 'Pierwsze zdjęcie produktu 3', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(14, 5, 'First photo of product 3', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(15, 6, 'Drugie zdjęcie produktu 3', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(16, 6, 'Second photo of product 3', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(17, 7, 'Pierwsze zdjęcie produktu 4', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(18, 7, 'First photo of product 4', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(19, 8, 'Drugie zdjęcie produktu 4', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(20, 8, 'Second photo of product 4', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(21, 9, 'Pierwsze zdjęcie produktu 5', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(22, 9, 'First photo of product 5', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(23, 10, 'Drugie zdjęcie produktu 5', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(24, 10, 'Second photo of product 5', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(25, 11, 'Pierwsze zdjęcie produktu 6', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(26, 11, 'First photo of product 6', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(27, 12, 'Drugie zdjęcie produktu 6', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(28, 12, 'Second photo of product 6', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(29, 13, 'Pierwsze zdjęcie produktu 7', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(30, 13, 'First photo of product 7', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(31, 14, 'Drugie zdjęcie produktu 7', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(32, 14, 'Second photo of product 7', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(33, 15, 'Pierwsze zdjęcie produktu 8', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(34, 15, 'First photo of product 8', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(35, 16, 'Drugie zdjęcie produktu 8', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(36, 16, 'Second photo of product 8', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(37, 17, 'Pierwsze zdjęcie produktu 9', 1, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(38, 17, 'First photo of product 9', 1, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(39, 18, 'Drugie zdjęcie produktu 9', 2, 1, 'pl', '2025-09-22 20:25:59', '2025-09-22 20:25:59'),
(40, 18, 'Second photo of product 9', 2, 1, 'en', '2025-09-22 20:25:59', '2025-09-22 20:25:59');

--
-- Zrzut danych tabeli `product_translations`
--

INSERT INTO `product_translations` (`id`, `product_id`, `availability_id`, `short_name`, `name`, `description`, `price`, `currency`, `order`, `visible`, `locale`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Różowa perła', 'Bransoletka „Różowa perła”', 'Delikatna, ręcznie robiona bransoletka w odcieniach malinowych. Idealna na prezent.', NULL, NULL, 1, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(2, 1, 2, 'Pink pearl', '“Pink Pearl” bracelet', 'A delicate, handmade bracelet in shades of raspberry. Perfect for a gift.', 15.00, 'usd', 1, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(3, 2, 3, 'Różowa perła', 'Bransoletka „Różowa perła”', 'Delikatna, ręcznie robiona bransoletka w odcieniach malinowych. Idealna na prezent.', NULL, NULL, 2, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(4, 2, 4, 'Pink pearl', '“Pink Pearl” bracelet', 'A delicate, handmade bracelet in shades of raspberry. Perfect for a gift.', NULL, NULL, 2, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(5, 3, 5, 'Różowa perła', 'Bransoletka „Różowa perła”', 'Delikatna, ręcznie robiona bransoletka w odcieniach malinowych. Idealna na prezent.', NULL, NULL, 3, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(6, 3, 6, 'Pink pearl', '“Pink Pearl” bracelet', 'A delicate, handmade bracelet in shades of raspberry. Perfect for a gift.', NULL, NULL, 3, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(7, 7, 1, 'Kropla rosy', 'Kolczyki „Kropla rosy”', 'Lekkie i wygodne, ręcznie wykonane kolczyki. Dodają dziewczęcego wdzięku.', NULL, NULL, 1, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(8, 7, 2, 'Drop of dew', '“Dewdrop” earrings', 'Lightweight and comfortable, handmade earrings. They add a touch of girlish charm.', NULL, NULL, 1, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(9, 8, 3, 'Kropla rosy', 'Kolczyki „Kropla rosy”', 'Lekkie i wygodne, ręcznie wykonane kolczyki. Dodają dziewczęcego wdzięku.', NULL, NULL, 2, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(10, 8, 4, 'Drop of dew', '“Dewdrop” earrings', 'Lightweight and comfortable, handmade earrings. They add a touch of girlish charm.', NULL, NULL, 2, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(11, 9, 5, 'Kropla rosy', 'Kolczyki „Kropla rosy”', 'Lekkie i wygodne, ręcznie wykonane kolczyki. Dodają dziewczęcego wdzięku.', NULL, NULL, 3, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(12, 9, 6, 'Drop of dew', '“Dewdrop” earrings', 'Lightweight and comfortable, handmade earrings. They add a touch of girlish charm.', NULL, NULL, 3, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(13, 4, 1, 'Subtelny urok', 'Naszyjnik „Subtelny urok”', 'Minimalistyczny naszyjnik z subtelnym połyskiem. Pasuje do codziennych stylizacji.', NULL, NULL, 1, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(14, 4, 2, 'Subtle charm', '“Subtle Charm” Necklace', 'A minimalist necklace with a subtle sheen. Perfect for everyday outfits.', NULL, NULL, 1, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(15, 5, 3, 'Subtelny urok', 'Naszyjnik „Subtelny urok”', 'Minimalistyczny naszyjnik z subtelnym połyskiem. Pasuje do codziennych stylizacji.', NULL, NULL, 2, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(16, 5, 4, 'Subtle charm', '“Subtle Charm” Necklace', 'A minimalist necklace with a subtle sheen. Perfect for everyday outfits.', NULL, NULL, 2, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(17, 6, 5, 'Subtelny urok', 'Naszyjnik „Subtelny urok”', 'Minimalistyczny naszyjnik z subtelnym połyskiem. Pasuje do codziennych stylizacji.', NULL, NULL, 3, 1, 'pl', '2025-09-22 19:46:50', '2025-09-22 19:46:50'),
(18, 6, 6, 'Subtle charm', '“Subtle Charm” Necklace', 'A minimalist necklace with a subtle sheen. Perfect for everyday outfits.', NULL, NULL, 3, 1, 'en', '2025-09-22 19:46:50', '2025-09-22 19:46:50');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
