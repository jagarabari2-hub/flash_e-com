-- FLASH E-Commerce Database Schema and Sample Data
-- Import this file into phpMyAdmin or MySQL command line to set up the complete database

-- ============================================================================
-- CREATE TABLES
-- ============================================================================

-- Create Categories Table
CREATE TABLE IF NOT EXISTS `cat` (
  `cat_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Products Table (Sub-categories)
CREATE TABLE IF NOT EXISTS `sub_cat` (
  `subcat_id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `dis` text,
  `price` int NOT NULL,
  PRIMARY KEY (`subcat_id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `sub_cat_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Users Table (Login)
CREATE TABLE IF NOT EXISTS `log_in` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `c_pass` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- INSERT CATEGORIES
-- ============================================================================

INSERT INTO `cat` (`cat_id`, `name`, `img`) VALUES
(1, 'Electronics', 'Electronics.jpg'),
(2, 'Fashion', 'Fashion.jpg'),
(3, 'Home & Garden', 'HomeandGarden.jpg'),
(4, 'Books', 'Books.jpg'),
(5, 'Sports', 'Sports.jpg'),
(6, 'Beauty', 'Beauty.jpg'),
(7, 'Toys', 'ToysAll.jpg'),
(8, 'Automotive', 'Automotive.jpg'),
(9, 'Pet Supplies', 'Pet Supplies.jpg'),
(10, 'Kitchen', 'Kitchen.jpg'),
(11, 'Furniture', 'Furniture.jpg'),
(12, 'Gaming', 'Gaming.jpg'),
(13, 'Office Supplies', 'Office Supplies.jpg'),
(14, 'Travel', 'Travel.jpg'),
(15, 'Fitness', 'Fitness.jpg'),
(16, 'Music', 'Music.jpg');

-- ============================================================================
-- INSERT PRODUCTS (SAMPLE DATA)
-- ============================================================================

-- Electronics Category (cat_id = 1)
INSERT INTO `sub_cat` (`cat_id`, `name`, `img`, `dis`, `price`) VALUES
(1, 'Wireless Headphones Pro', '1.jfif', 'Premium noise-cancelling wireless headphones with 30-hour battery life, Bluetooth 5.0, and premium sound quality. Perfect for music lovers and professionals.', 2499),
(2, 'USB-C Fast Charger', '5.jfif', 'High-speed USB-C charger supporting up to 65W power delivery. Compatible with all USB-C devices. Compact and travel-friendly design.', 599),
(3, 'Smart Phone Stand', '7.jfif', 'Adjustable phone stand made from premium aluminum. Perfect for video calls, streaming, and content creation. Supports all phone sizes.', 299),
(4, 'Portable Power Bank 20000mAh', '9.jfif', 'Fast charging power bank with dual USB-A and USB-C ports. Powers your devices multiple times. LED digital display shows battery percentage.', 1299),

-- Fashion Category (cat_id = 2)
(5, 'Cotton T-Shirt Pack', '1.jfif', 'Set of 3 premium quality 100% cotton t-shirts. Comfortable, durable, and perfect for everyday wear. Available in various colors.', 799),
(6, 'Formal Dress Shirt', '5.jfif', 'High-quality formal shirt made from premium cotton blend. Perfect for office and formal occasions. Easy to maintain and comfortable.', 1299),
(7, 'Running Sports Shoes', '7.jfif', 'Professional running shoes with advanced cushioning technology. Lightweight, breathable, and designed for long-distance running.', 3499),
(8, 'Winter Jacket', '9.jfif', 'Warm and stylish winter jacket with water-resistant outer layer and soft fleece lining. Perfect for cold weather protection.', 2999),

-- Home & Garden Category (cat_id = 3)
(9, 'LED Table Lamp', '1.jfif', 'Modern LED table lamp with adjustable brightness and color temperature. Energy-efficient and perfect for study or work areas.', 899),
(10, 'Indoor Plant Pot Set', '5.jfif', 'Set of 5 beautiful ceramic plant pots with drainage holes. Perfect for indoor gardening and home decoration.', 1599),
(11, 'Wall Clock Modern Design', '7.jfif', 'Contemporary wall clock with minimalist design. Silent mechanism, battery-operated, and adds elegance to any room.', 749),
(12, 'Door Mat Rubber', '9.jfif', 'Non-slip rubber door mat with attractive pattern. Durable, weather-resistant, and easy to clean.', 349),

-- Books Category (cat_id = 4)
(13, 'Programming in Python', '1.jfif', 'Comprehensive guide to Python programming for beginners and intermediate learners. Includes practical examples and projects.', 599),
(14, 'The Art of Web Design', '5.jfif', 'Learn professional web design principles and best practices. Covers UI/UX, responsive design, and modern frameworks.', 699),
(15, 'Business Strategy Guide', '7.jfif', 'Essential strategies for building a successful business. Real-world case studies and practical insights included.', 549),
(16, 'Digital Marketing Handbook', '9.jfif', 'Complete guide to digital marketing including SEO and social media strategies. Learn proven techniques.', 799),

-- Sports Category (cat_id = 5)
(17, 'Yoga Mat Premium', '1.jfif', 'Non-slip yoga mat made from eco-friendly material. Comes with carrying strap. Perfect for yoga and pilates.', 1199),
(18, 'Dumbbells Set 20kg', '5.jfif', 'Adjustable dumbbell set with comfortable grip handles. Professional grade quality for home gym.', 2299),
(19, 'Resistance Bands Set', '7.jfif', 'Complete set of 5 resistance bands for strength training. Color-coded by resistance level.', 449),
(20, 'Fitness Tracker Watch', '9.jfif', 'Advanced fitness tracker with heart rate monitor and sleep tracking. Water-resistant design.', 1899),

-- Beauty Category (cat_id = 6)
(21, 'Face Wash 100ml', '1.jfif', 'Gentle face wash for all skin types. With natural ingredients that cleanse without drying or irritation.', 299),
(22, 'Moisturizer Cream 50g', '5.jfif', 'Lightweight daily moisturizer with SPF 30 protection. Keeps skin hydrated throughout the day.', 499),
(23, 'Sunscreen SPF 50 100ml', '7.jfif', 'Water-resistant sunscreen for daily UV protection. Suitable for sensitive skin and all weather.', 399),
(24, 'Hair Oil Premium 200ml', '9.jfif', 'Nourishing hair oil made from natural ingredients. Helps reduce hair fall and improves scalp health.', 349),

-- Toys Category (cat_id = 7)
(25, 'Educational Robot Kit', '1.jfif', 'STEM learning robot kit for kids aged 8+. Teaches programming and robotics basics.', 1999),
(26, 'Building Blocks Set 500pcs', '5.jfif', 'Colorful building blocks for creative play. Safe and non-toxic material for children.', 899),
(27, 'Remote Control Car', '7.jfif', 'Fast RC car with 30-minute battery life and 100m range. Perfect for outdoor fun and racing.', 1299),
(28, 'Puzzle Games Collection', '9.jfif', 'Set of 6 logic puzzle games. Develops problem-solving and critical thinking skills.', 599),

-- Automotive Category (cat_id = 8)
(29, 'Car Phone Mount', '1.jfif', 'Adjustable car phone mount with strong suction cup. Secure hold for safe navigation and calls.', 299),
(30, 'Dash Cam 1080P', '5.jfif', 'Full HD dash camera with night vision and loop recording. Essential evidence for accidents.', 1899),
(31, 'Car Air Freshener', '7.jfif', 'Long-lasting car air freshener with fresh scent. Eliminates odors effectively.', 149),
(32, 'Car Cleaning Kit', '9.jfif', 'Complete car cleaning kit with cloths, brushes, and cleaning solutions.', 699),

-- Pet Supplies Category (cat_id = 9)
(33, 'Dog Bed Comfortable', '1.jfif', 'Soft dog bed with memory foam. Perfect for dogs of all sizes for comfortable rest.', 1299),
(34, 'Pet Food Bowl Set', '5.jfif', 'Stainless steel food and water bowls for pets. Easy to clean and dishwasher safe.', 249),
(35, 'Dog Collar Leash Set', '7.jfif', 'Durable nylon collar and leash with reflective strips for safety and visibility.', 399),
(36, 'Pet Toy Ball', '9.jfif', 'Interactive pet toys that bounce and roll. Made from safe non-toxic rubber.', 199),

-- Kitchen Category (cat_id = 10)
(37, 'Non-Stick Cookware Set', '1.jfif', 'Complete non-stick cookware set with 4 pieces. Even heat distribution for perfect cooking.', 1599),
(38, 'Electric Blender', '5.jfif', 'Powerful blender for smoothies and juices. 3 speed settings and stainless steel blades.', 1299),
(39, 'Stainless Steel Utensils', '7.jfif', 'Set of 12 essential cooking utensils made from premium stainless steel.', 499),
(40, 'Glass Storage Container Set', '9.jfif', 'Microwave-safe glass containers with airtight lids. Perfect for meal prep storage.', 699),

-- Furniture Category (cat_id = 11)
(41, 'Office Chair Ergonomic', '1.jfif', 'Comfortable ergonomic office chair with lumbar support and adjustable height.', 3999),
(42, 'Coffee Table Modern', '5.jfif', 'Sleek modern coffee table with solid wood construction and contemporary design.', 2499),
(43, 'Bookshelf 5 Shelf', '7.jfif', 'Tall bookshelf with 5 spacious shelves. Sturdy construction and modern finish.', 2299),
(44, 'Bed Sheet Set Cotton', '9.jfif', 'Premium quality cotton bed sheet set including 2 pillows. Soft and durable.', 1299),

-- Gaming Category (cat_id = 12)
(45, 'Gaming Mouse Wireless', '1.jfif', 'Precision gaming mouse with customizable DPI and wireless technology for smooth gameplay.', 999),
(46, 'Mechanical Keyboard RGB', '5.jfif', 'Professional mechanical keyboard with RGB lighting and mechanical switches.', 1599),
(47, 'Gaming Headset', '7.jfif', 'Surround sound gaming headset with noise-cancelling microphone for competitive gaming.', 1299),
(48, 'Gaming Monitor 24 inch', '9.jfif', '144Hz gaming monitor with 1ms response time. Perfect for FPS and fast-paced games.', 4999),

-- Office Supplies Category (cat_id = 13)
(49, 'Stationery Set Pack', '1.jfif', 'Complete stationery set with pens, pencils, erasers, and notebooks for office use.', 399),
(50, 'Desk Organizer Holder', '5.jfif', 'Multi-compartment desk organizer for pens, clips, and small office items. Keeps workspace tidy.', 599),
(51, 'A4 Printer Paper Ream', '7.jfif', 'Pack of 500 sheets of premium A4 printer paper. Smooth finish for quality printing.', 249),
(52, 'Desk Lamp LED', '9.jfif', 'Bright LED desk lamp with adjustable angle and intensity. Energy-efficient and long-lasting.', 749),

-- Travel Category (cat_id = 14)
(53, 'Travel Luggage Set', '1.jfif', 'Lightweight luggage set with TSA locks and spinner wheels. Perfect for business and leisure travel.', 4499),
(54, 'Travel Pillow Memory Foam', '5.jfif', 'Ergonomic memory foam travel pillow for neck support during flights and long journeys.', 699),
(55, 'Travel Adapter Universal', '7.jfif', 'Universal travel adapter compatible with 150+ countries. Supports multiple plug types.', 399),
(56, 'Travel Organizer Bag', '9.jfif', 'Multi-pocket travel organizer for documents, cards, and essentials. Compact and lightweight.', 549),

-- Fitness Category (cat_id = 15)
(57, 'Treadmill Home Gym', '1.jfif', 'Electric treadmill with digital display and multiple speed settings for home workouts.', 9999),
(58, 'Yoga Fitness Mat', '5.jfif', 'Premium yoga mat with non-slip surface and carrying handle. Perfect for fitness routines.', 899),
(59, 'Push-up Bar Set', '7.jfif', 'Ergonomic push-up bars with non-slip handles for effective chest and arm exercises.', 299),
(60, 'Kettlebell Set 10kg', '9.jfif', 'Cast iron kettlebell set for functional training and strength building exercises.', 1299),

-- Music Category (cat_id = 16)
(61, 'Acoustic Guitar', '1.jfif', 'High-quality acoustic guitar with resonant wood construction and clear sound.', 2999),
(62, 'Ukulele Beginner Kit', '5.jfif', 'Complete ukulele beginner kit with tuner and instruction guide for easy learning.', 799),
(63, 'Digital Piano 88 Keys', '7.jfif', 'Full-sized digital piano with 88 weighted keys and premium sound samples.', 5999),
(64, 'Microphone USB Studio', '9.jfif', 'Professional USB studio microphone for recording podcasts, music, and voiceovers.', 1899);

-- ============================================================================
-- SAMPLE USER (optional)
-- ============================================================================

-- Sample login credentials (email: test@example.com, password: password)
INSERT INTO `log_in` (`email`, `pass`, `c_pass`) VALUES
('test@example.com', 'password', 'password');

-- ============================================================================
-- DONE
-- ============================================================================
-- Database setup complete! You can now:
-- 1. Register new users in the website
-- 2. Login with test@example.com / password
-- 3. Start shopping with 64 sample products
