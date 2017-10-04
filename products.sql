SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` text NOT NULL,
  `product_code` varchar(60) NOT NULL,
  `product_image` varchar(60) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `current_rating` int(11) NOT NULL,
  `people_rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products` (`id`, `product_name`, `product_desc`, `product_code`, `product_image`, `product_price`, `current_rating`,`people_rating`) VALUES
(1, 'Apple', 'best apple demo, this is my apple demo description.', 'APPLE1322323', 'apple_image_by_esmael.jpg', '0.30', 0,1),
(2, 'beer', 'this is a beer demo description', 'beer_code_242', 'beer_pic_by_esmael.jpg', '2.00', 0,1),
(3, 'Water', 'This is a demo water description', 'water_75537', 'water_pic.jpg', '1.00', 0,1),
(4, 'Cheese', 'cheese demo description', 'cheese55', 'cheese_pic.jpg', '3.74', 0,1);
