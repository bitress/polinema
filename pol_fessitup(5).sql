-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 23, 2022 at 08:02 AM
-- Server version: 8.0.31-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pol_fessitup`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `user_id`, `quantity`) VALUES
(30, 40, 2, '1'),
(36, 128, 6, '1'),
(37, 55, 3, '1'),
(38, 59, 3, '1'),
(39, 3, 1, '10'),
(40, 19, 1, '4'),
(41, 62, 7, '1'),
(42, 84, 7, '1');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Foods & Beverages'),
(2, 'Clothing'),
(3, 'Footwear'),
(4, 'Electronics & Computers'),
(5, 'Accessories'),
(6, 'Personal Care'),
(7, 'Condoms & Lubricants');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `user_id`, `cart_id`, `datetime`) VALUES
(1, 1, 36, '2022-12-23 09:36:19'),
(2, 1, 37, '2022-12-23 09:36:19'),
(3, 3, 37, '2022-12-23 05:57:26'),
(4, 3, 38, '2022-12-23 05:57:26'),
(5, 7, 41, '2022-12-23 06:15:02'),
(6, 7, 42, '2022-12-23 06:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `category` int NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_price`, `category`, `product_image`) VALUES
(1, 'C2', '12', 1, 'products/c2.jpg'),
(2, 'Presto Creams', '7', 1, 'products/presto.jpg'),
(3, 'iPhone 14 Pro Max', '84990', 4, 'products/uploaded_15b4bb7631157d6007cf62df3e23b5a97c3fbc9f.jpg'),
(12, 'Dowee Donut', '70', 1, 'products/OIP (2).jpg'),
(19, 'Toblerone', '200', 1, 'products/OIP (6).jpg'),
(20, 'Skittles', '35', 1, 'products/R (3).jpg'),
(26, 'Durex Sensual Strawberry Condoms 3s', '36', 7, 'products/received_457136083090078.webp'),
(27, 'Durex Naughty Chocolate 3s', '36', 7, 'products/received_1910132239338546.webp'),
(28, 'Durex Invisible Extra Thin, Extra Sensitive Condoms 3s', '144', 7, 'products/received_887791718914929.webp'),
(29, 'Durex Love Basic Condoms 3s', '45', 7, 'products/received_826085312011294.webp'),
(31, 'Durex Performa Condoms Extended Pleasure 3s', '113', 7, 'products/received_532131105628278.webp'),
(32, 'Durex Fetherlite Thinner Condoms 3s', '125', 7, 'products/received_1327178124710744.webp'),
(33, 'Durex Pleasuremax Condoms Extra Stimulation 3s', '119', 7, 'products/received_1188592855090922.webp'),
(36, 'Durex Play Strawberry Lubricant 50ml (x2)', '442', 7, 'products/IMG_20221222_201157.jpg'),
(37, 'Durex Play Feel Pleasure Lubricant Gel 50ml (x2)', '442', 7, 'products/320107150_1107250906633369_2389548738749280124_n.jpg'),
(38, 'Durex KY Lubricant Jelly 100g', '524', 7, 'products/321645918_3412748602347028_4481669275826752370_n.jpg'),
(39, 'Mom Jeans ', '250', 2, 'products/321118978_934367287549822_4768334774197467525_n.jpg'),
(40, 'SS Nicole Polo and Shirt Terno', '189', 2, 'products/2be35678e5c5e0701d93071725d192e5.jpeg'),
(41, 'SS Khazz Terno Sleeveless Crop Top and Shorts ', '125', 2, 'products/321484394_671354111337888_7258583973040495417_n.jpg'),
(42, 'Polo Blouse Tops for Women', '199', 2, 'products/321420258_1586674241761200_1009579670052788140_n.jpg'),
(43, 'Black Polo Blouse Tops for Women', '199', 2, 'products/320676541_1294303751140542_3155691721110300091_n.jpg'),
(44, '2n1 Korean Style Two Tone Blazer with Inner', '168', 2, 'products/321077497_703686677838062_3515073088530281973_n.jpg'),
(45, 'SS Faye Sweetheart Neck Puff Sleeve Knit Tee', '75', 2, 'products/320407016_1134820910551611_7413452454447720127_n.jpg'),
(46, 'Cargo Pants', '140', 2, 'products/320559501_3429824827250895_2306990639421239383_n.jpg'),
(47, 'INSPI Tie Dye ', '100', 2, 'products/320690378_2343909405769143_2271120252407592126_n.jpg'),
(48, 'INSPI Wave Splash T-shirt ', '229', 2, 'products/320552944_854253349193106_3360717839844669749_n.jpg'),
(49, 'INSPI Warrior T-shirt ', '229', 2, 'products/320395823_550859689958636_1158557486731326174_n.jpg'),
(50, 'INSPI Plain T-shirt ', '130', 2, 'products/321420886_1327575311348247_3653434756740596287_n.jpg'),
(51, 'INSPI Brown Short', '99', 2, 'products/321244389_1350862382399584_2462585864971745532_n.jpg'),
(52, 'SS Vee Crop Top Jacket and Shorts Terno', '125', 2, 'products/320620423_1206690076926134_8627517404470090895_n.jpg'),
(53, 'SS 2n1 Short/Skirt ', '89', 2, 'products/320331369_1583503185443735_8888907162025147745_n.jpg'),
(55, 'Hongfa Sandals', '179', 3, 'products/320879201_588237339807467_337079402783513612_n.jpg'),
(56, 'Braided Strap Ladies footwear ', '125', 3, 'products/319969447_3511479849072482_8002508996419720143_n.jpg'),
(57, 'Korean Fashionable Slippers ', '146', 3, 'products/320513455_518837890017423_8980858025527184294_n.jpg'),
(59, 'Lala Comfy rubber slippers', '78', 3, 'products/320913815_610592327540241_6343880433311271977_n.jpg'),
(60, 'Pandora Beads & Pave Bracelet', '650', 5, 'products/beads & pave bracelet.jpeg'),
(61, 'Korean Chunky Sandals', '219', 3, 'products/320785544_1371516516917348_3260911909669755714_n.jpg'),
(62, 'Pandora Black Spinel Earrings', '1200', 5, 'products/black spinel earrings.jpg'),
(64, 'Nike Summer Slippers ', '120', 3, 'products/320627969_1334908557312892_409382980939022985_n.jpg'),
(67, 'Sandugo Slippers ', '215', 3, 'products/321040659_680346950304591_7951071727607291215_n.jpg'),
(68, 'Pandora Rosegold Necklace', '2000', 5, 'products/pandora rosegold necklace.jpg'),
(69, 'Nike Fashion Trend Slippers ', '79', 3, 'products/320323381_882440149561301_8807435645029511988_n.jpg'),
(70, 'Pandora Shooting Star Ring', '1300', 5, 'products/pandora shooting star ring.jpg'),
(72, 'Pandora Pure Watch', '3200', 5, 'products/pure watch.jpg'),
(73, 'Pandora Silver Necklace', '1600', 5, 'products/silver necklace.jpg'),
(74, 'Pandora Square Sparkle Earrings', '800', 5, 'products/square sparkle.jpg'),
(76, 'Pandora Round Sparkle Earrings', '950', 5, 'products/pandora-round-sparkle-halo-stud-earrings.jpg'),
(77, 'AirForce1', '699', 3, 'products/320257635_663242325588302_4088610227115404818_n.jpg'),
(78, 'Air Force Sneakers ', '398', 3, 'products/320564570_2086350758232547_276821724074613671_n.jpg'),
(79, 'YM Casual Top Sneakers ', '283', 3, 'products/320614157_588671153095351_609639493662840324_n.jpg'),
(80, 'BS Korean White Shoes ', '299', 3, 'products/320888149_1311269973055966_1028082005151249759_n.jpg'),
(81, 'AirForce1 for women', '359', 3, 'products/320210540_1085926675407648_6630322393685818884_n.jpg'),
(82, 'LDS Sneakers ', '365', 3, 'products/320510214_6031912890161056_4382385494106811287_n.jpg'),
(83, 'Korean Fashion Sandals ', '125', 3, 'products/320423433_674951487605667_569830053434201865_n.jpg'),
(84, 'DERE V14s ', '20299', 4, 'products/321799808_1473893843104084_2041007394744592432_n.jpg'),
(85, 'DERE V10', '30000', 4, 'products/320851225_1256894208257737_2040179084801481545_n.jpg'),
(86, 'VIVO V21 5g', '23999', 4, 'products/319919577_462817062687950_2562028657386368247_n.jpg'),
(87, 'VIVO V21e', '17999', 4, 'products/320676840_1507639512981604_6270597999926148698_n.jpg'),
(90, 'Baby Dove Liquid Soap', '167', 6, 'products/baby dove liquid soap.jpg'),
(91, 'Colgate Charcoal Toothbrush', '35', 6, 'products/charcoal toothbrush.jpg'),
(92, 'Colgate Toothpaste', '70', 6, 'products/colgate toothpaste.jpg'),
(93, 'Dove Body Wash Sensitive Skin', '210', 6, 'products/dove body wash sensitive skin.jpeg'),
(94, 'Dove Soap Original', '45', 6, 'products/dove soap original.jpg'),
(95, 'Nivea Body Lotion', '199', 6, 'products/nivea body lotion.jpg'),
(96, 'Nivea Deodorant Roll On', '150', 6, 'products/nivea deodoroant antipersperant roll on men.jpg'),
(97, 'Palmolive Shampoo', '99', 6, 'products/palmolive shampoo.jpg'),
(98, 'Royal Baby Wipes', '135', 6, 'products/royal baby wipes tub.jpg'),
(99, 'Dairy Milk', '40', 1, 'products/Dairy milk.jpg'),
(101, 'Apple Smart Watch Series2', '10000', 4, 'products/Apple Smart Watch Series 2.jpeg'),
(102, 'HP Wired Mouse', '500', 4, 'products/HP wired mouse.jpg'),
(103, 'Studio2 Wireless Headphones', '300', 4, 'products/Studio2 Wireless Headphomes.jpg'),
(104, 'Wired Earphones', '150', 4, 'products/Wired Earphones.jpg'),
(105, 'Wireless Optical Mouse', '499', 4, 'products/Wireless Optical Mouse.jpeg'),
(106, 'Samyang 3x', '55', 1, 'products/321418397_683068196527899_5747187039352439371_n.jpg'),
(107, 'Binggrae Banana Milk', '50', 1, 'products/319503714_544303500915993_8169038307472662854_n.jpg'),
(108, 'Binggrae Melon Milk', '50', 1, 'products/320657651_3004083846560839_898764401956277473_n.jpg'),
(109, 'Binggrae Strawberry Milk', '50', 1, 'products/320428266_709118397399172_6640297505326911532_n.jpg'),
(110, 'Binggrae Lychee and Peach Milk', '50', 1, 'products/319468477_868678177590708_8699534185123041843_n.jpg'),
(111, 'Jjajangmyun', '56', 1, 'products/320006432_703808271350453_2881151519084108310_n.jpg'),
(112, 'Samyang Buldak Ramen', '85', 1, 'products/320929798_1644155199320271_7370612422441631272_n.jpg'),
(113, 'Beef Bulgogi', '54', 1, 'products/320140425_694152722331474_4270205034202441374_n.jpg'),
(114, 'Nongshim Shin ', '49', 1, 'products/320778745_1763341490717719_7876463558026764401_n.jpg'),
(115, 'Jin Ramen', '34', 1, 'products/321297583_1237684790114502_8660759744290848013_n.jpg'),
(116, 'Yeokbokki', '99', 1, 'products/321183167_558552922411318_1766914969129899883_n.jpg'),
(117, 'Nutri Boost', '27', 1, 'products/320797541_906075500389008_4690799497605228476_n.jpg'),
(118, 'Coca cola ', '20', 1, 'products/319756553_5885178478205944_2566721377754323363_n.jpg'),
(119, 'Minute Maid Mango', '10', 1, 'products/320931236_655246849718880_8436794125873809734_n.jpg'),
(120, 'Real Leaf Frutchy Apple', '17', 1, 'products/320513457_558168679154564_7946367034936745618_n.jpg'),
(121, 'Sprite 1.5L', '60', 1, 'products/319543887_2734218606713225_1716259271537386707_n.jpg'),
(122, 'Royal 1.5L', '60', 1, 'products/320092099_670544574730266_1609043164478832956_n.jpg'),
(123, 'Coca cola Light', '20', 1, 'products/320140425_1224467208136997_2843719144472723939_n.jpg'),
(124, 'Wilkins Sparkling Water', '23', 1, 'products/321301699_521206926735327_6058384087416755317_n.jpg'),
(125, 'Wilkins Pure Water', '20', 1, 'products/320680984_703276411174214_4540866960367679964_n.jpg'),
(127, 'Pandora Bracelet Charms', '500', 5, 'products/bracelet charms.jpg'),
(128, 'Pandora Charms Silver Watch', '2500', 5, 'products/charms silver.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `firstname`, `middlename`, `lastname`, `address`) VALUES
(1, 'customer', '91ec1f9324753048c0096d036a694f86', 'customer', 'Customer', 'Customer', 'Customer', 'IDK'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Admin', 'Admin', 'Admin', ''),
(3, 'user001', '24c9e15e52afc47c225b757e7bee1f9d', 'customer', 'user', 'userr', 'userrr', 'london'),
(4, 'cyanneheart', '58b13f575773f4b5dfb56a2fa80b9b4e', 'customer', 'Cyanne', 'L', 'Vega', 'Bio'),
(5, 'Oyy', 'fbda23e6d183454f8a9644b9fd97936e', 'customer', 'Russel', 'De Guzman', 'Caponga', 'russelgueccsgvdhbvdhfbv@gmail.com'),
(6, 'Marvin45', 'a4b52080d7530cb78315e67596e66620', 'customer', 'Marvin', 'Ancheta', 'Ragunton', 'Salcedo'),
(7, 'harry', '5f4dcc3b5aa765d61d8327deb882cf99', 'customer', 'Harry', 'P', 'Potter', 'London');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
