-- Sample Data for FLASH E-Commerce Database
-- Insert this data into your MySQL database

-- Clear existing data (optional - comment out if you want to keep existing data)
-- DELETE FROM sub_cat;
-- DELETE FROM cat;

-- Insert Categories
INSERT INTO cat (cat_id, name, img) VALUES
(1, 'Electronics', 'electronics.jpg'),
(2, 'Fashion', 'fashion.jpg'),
(3, 'Home & Garden', 'home.jpg'),
(4, 'Books', 'books.jpg'),
(5, 'Sports', 'sports.jpg'),
(6, 'Beauty', 'beauty.jpg'),
(7, 'Toys', 'toys.jpg'),
(8, 'Automotive', 'auto.jpg'),
(9, 'Pet Supplies', 'pets.jpg'),
(10, 'Kitchen', 'kitchen.jpg'),
(11, 'Furniture', 'furniture.jpg'),
(12, 'Gaming', 'gaming.jpg'),
(13, 'Office Supplies', 'office.jpg'),
(14, 'Travel', 'travel.jpg'),
(15, 'Fitness', 'fitness.jpg'),
(16, 'Music', 'music.jpg');

-- Insert Products (Sub-categories)
INSERT INTO sub_cat (subcat_id, cat_id, name, img, dis, price) VALUES

-- Electronics Category (cat_id = 1)
(1, 1, 'Wireless Headphones Pro', '1.jfif', 'Premium noise-cancelling wireless headphones with 30-hour battery life, Bluetooth 5.0, and premium sound quality. Perfect for music lovers and professionals.', 2499),
(2, 1, 'USB-C Fast Charger', '2.jfif', 'High-speed USB-C charger supporting up to 65W power delivery. Compatible with all USB-C devices. Compact and travel-friendly design.', 599),
(3, 1, 'Smart Phone Stand', '3.jfif', 'Adjustable phone stand made of premium aluminum. Perfect for video calls, streaming, and content creation. Supports all phone sizes.', 299),
(4, 1, 'Portable Power Bank 20000mAh', '5.jfif', 'Fast charging power bank with dual USB-A and USB-C ports. Powers your devices multiple times. LED digital display shows battery percentage.', 1299),

-- Fashion Category (cat_id = 2)
(5, 2, 'Cotton T-Shirt Pack', '7.jfif', 'Set of 3 premium quality 100% cotton t-shirts. Comfortable, durable, and perfect for everyday wear. Available in various colors.', 799),
(6, 2, 'Formal Dress Shirt', '9.jfif', 'High-quality formal shirt made from premium cotton blend. Perfect for office and formal occasions. Easy to maintain and comfortable.', 1299),
(7, 2, 'Running Sports Shoes', '17.jfif', 'Professional running shoes with advanced cushioning technology. Lightweight, breathable, and designed for long-distance running and everyday use.', 3499),
(8, 2, 'Winter Jacket', '19.jfif', 'Warm and stylish winter jacket with water-resistant outer layer and soft fleece lining. Perfect for cold weather protection.', 2999),

-- Home & Garden Category (cat_id = 3)
(9, 3, 'LED Table Lamp', '1.jfif', 'Modern LED table lamp with adjustable brightness and color temperature. Energy-efficient and perfect for study or work areas.', 899),
(10, 3, 'Indoor Plant Pot Set', '5.jfif', 'Set of 5 beautiful ceramic plant pots with drainage holes. Perfect for indoor gardening and home decoration.', 1599),
(11, 3, 'Wall Clock Modern Design', '7.jfif', 'Contemporary wall clock with minimalist design. Silent mechanism, battery-operated, and adds elegance to any room.', 749),
(12, 3, 'Door Mat Rubber', '9.jfif', 'Non-slip rubber door mat with attractive pattern. Durable, weather-resistant, and easy to clean. Perfect for indoor and outdoor use.', 349),

-- Books Category (cat_id = 4)
(13, 4, 'Programming in Python', '1.jfif', 'Comprehensive guide to Python programming for beginners and intermediate learners. Includes practical examples and projects.', 599),
(14, 4, 'The Art of Web Design', '5.jfif', 'Learn professional web design principles and best practices. Covers UI/UX, responsive design, and modern frameworks.', 699),
(15, 4, 'Business Strategy Guide', '7.jfif', 'Essential strategies for building and growing a successful business. Real-world case studies and actionable insights.', 549),
(16, 4, 'Digital Marketing Handbook', '9.jfif', 'Complete guide to digital marketing including SEO, social media, email marketing, and analytics. Practical tips for modern marketers.', 799),

-- Sports Category (cat_id = 5)
(17, 5, 'Yoga Mat Premium', '1.jfif', 'Non-slip yoga mat made from eco-friendly material. Perfect for yoga, pilates, and floor exercises. Comes with carrying strap.', 1199),
(18, 5, 'Dumbbells Set 20kg', '5.jfif', 'Adjustable dumbbell set with comfortable grip handles. Ideal for home gym training. Professional grade quality.', 2299),
(19, 5, 'Resistance Bands Set', '7.jfif', 'Complete set of 5 resistance bands for strength training and rehabilitation. Color-coded by resistance level.', 449),
(20, 5, 'Fitness Tracker Watch', '9.jfif', 'Advanced fitness tracker with heart rate monitor, sleep tracking, and step counter. Water-resistant design for all activities.', 1899),

-- Beauty Category (cat_id = 6)
(21, 6, 'Face Wash 100ml', '1.jfif', 'Gentle yet effective face wash for all skin types. With natural ingredients that cleanse without drying the skin.', 299),
(22, 6, 'Moisturizer Cream 50g', '5.jfif', 'Lightweight daily moisturizer with SPF 30 protection. Keeps skin hydrated and protected from sun damage.', 499),
(23, 6, 'Sunscreen SPF 50 100ml', '7.jfif', 'Water-resistant sunscreen for daily UV protection. Suitable for all skin types including sensitive skin.', 399),
(24, 6, 'Hair Oil Premium 200ml', '9.jfif', 'Nourishing hair oil made from natural ingredients. Helps reduce hair fall and promotes hair growth.', 349),

-- Toys Category (cat_id = 7)
(25, 7, 'Educational Robot Kit', '1.jfif', 'STEM learning robot kit for kids aged 8+. Teaches programming and robotics through interactive play.', 1999),
(26, 7, 'Building Blocks Set 500pcs', '5.jfif', 'Colorful building blocks for creative play. Safe, non-toxic, and develops motor skills and imagination.', 899),
(27, 7, 'Remote Control Car', '7.jfif', 'Fast RC car with 30-minute battery life and 100m range. Perfect for outdoor adventures and racing fun.', 1299),
(28, 7, 'Puzzle Games Collection', '9.jfif', 'Set of 6 logic puzzle games for kids and adults. Develops problem-solving and critical thinking skills.', 599),

-- Automotive Category (cat_id = 8)
(29, 8, 'Car Phone Mount', '1.jfif', 'Adjustable car phone mount with strong suction cup. Secure hold for safe navigation while driving.', 299),
(30, 8, 'Dash Cam 1080P', '5.jfif', 'Full HD dash camera with night vision and loop recording. Provides safety and evidence for accidents.', 1899),
(31, 8, 'Car Air Freshener', '7.jfif', 'Long-lasting car air freshener with fresh scent. Eliminates odors and freshens your car interior.', 149),
(32, 8, 'Car Cleaning Kit', '9.jfif', 'Complete car cleaning kit with microfiber cloths, brushes, and cleaning solutions. Keep your car sparkling clean.', 699),

-- Pet Supplies Category (cat_id = 9)
(33, 9, 'Dog Bed Comfortable', '1.jfif', 'Soft and comfortable dog bed with memory foam. Perfect for dogs of all sizes to rest and sleep.', 1299),
(34, 9, 'Pet Food Bowl Set', '5.jfif', 'Stainless steel food and water bowls for pets. Easy to clean and dishwasher safe.', 249),
(35, 9, 'Dog Collar Leash Set', '7.jfif', 'Durable nylon collar and leash set with reflective strips for safety. Adjustable to fit all dog sizes.', 399),
(36, 9, 'Pet Toy Ball', '9.jfif', 'Interactive pet toys that bounce and roll. Made from safe rubber material. Hours of entertainment for pets.', 199),

-- Kitchen Category (cat_id = 10)
(37, 10, 'Non-Stick Cookware Set', '1.jfif', 'Complete non-stick cookware set with 4 pieces. Heat-resistant handles and even heat distribution.', 1599),
(38, 10, 'Electric Blender', '5.jfif', 'Powerful blender for smoothies, juices, and shakes. 3 speed settings and stainless steel blades.', 1299),
(39, 10, 'Stainless Steel Utensils', '7.jfif', 'Set of 12 essential cooking utensils made from stainless steel. Durable and easy to clean.', 499),
(40, 10, 'Glass Storage Container Set', '9.jfif', 'Microwave-safe glass containers with airtight lids. Perfect for food storage and meal prep.', 699),

-- Furniture Category (cat_id = 11)
(41, 11, 'Office Chair Ergonomic', '1.jfif', 'Comfortable ergonomic office chair with lumbar support. Promotes good posture and reduces back pain.', 3999),
(42, 11, 'Coffee Table Modern', '5.jfif', 'Sleek modern coffee table with solid wood construction. Perfect for living rooms and adds elegance.', 2499),
(43, 11, 'Bookshelf 5 Shelf', '7.jfif', 'Tall bookshelf with 5 spacious shelves. Sturdy construction and modern design for organized storage.', 2299),
(44, 11, 'Bed Sheet Set Cotton', '9.jfif', 'Premium quality cotton bed sheet set with 2 pillows. Soft, breathable, and durable for comfortable sleep.', 1299),

-- Gaming Category (cat_id = 12)
(45, 12, 'Gaming Headset', '1.jfif', 'Professional gaming headset with crystal clear audio and noise-cancelling mic. Compatible with all gaming platforms.', 1799),
(46, 12, 'Mechanical Keyboard', '5.jfif', 'RGB gaming keyboard with mechanical switches. Responsive keys and customizable lighting effects.', 2199),
(47, 12, 'Gaming Mouse Wireless', '7.jfif', 'High-precision wireless gaming mouse with adjustable DPI. Ergonomic design and long battery life.', 1299),
(48, 12, 'Controller Game Pad', '9.jfif', 'Universal game controller compatible with PC, console, and mobile. Comfortable grip and responsive buttons.', 999),

-- Office Supplies Category (cat_id = 13)
(49, 13, 'A4 Paper Ream', '1.jfif', 'Pack of 500 sheets A4 premium quality paper. Perfect for printing and copying. Bright white color.', 199),
(50, 13, 'Pen Set 50 pieces', '5.jfif', 'Set of 50 ballpoint pens in assorted colors. Smooth writing and long-lasting ink.', 299),
(51, 13, 'Desk Organizer', '7.jfif', 'Multi-compartment desk organizer for pens, papers, and supplies. Keeps your workspace organized and neat.', 399),
(52, 13, 'Stapler and Puncher', '9.jfif', 'Heavy-duty stapler and hole puncher combo set. Perfect for office and school use. Easy to refill.', 349),

-- Travel Category (cat_id = 14)
(53, 14, 'Travel Backpack 40L', '1.jfif', 'Spacious 40L travel backpack with multiple compartments. Waterproof material and ergonomic design for comfort.', 1999),
(54, 14, 'Luggage Bag Set', '5.jfif', 'Set of 3 durable luggage bags in different sizes. Lightweight but sturdy construction with smooth wheels.', 3499),
(55, 14, 'Travel Pillow Memory Foam', '7.jfif', 'Comfortable U-shaped travel pillow for neck support. Portable and perfect for long flights or car rides.', 599),
(56, 14, 'Travel Organizer Pouch', '9.jfif', 'Multi-pocket travel organizer for cables, documents, and essentials. Keep everything organized and accessible.', 299),

-- Fitness Category (cat_id = 15)
(57, 15, 'Treadmill Electric', '1.jfif', 'Home treadmill with adjustable speed and incline. LCD display shows distance, time, and calories burned.', 9999),
(58, 15, 'Skipping Rope Professional', '5.jfif', 'Adjustable speed rope with ball bearings. Perfect for cardio training and improving coordination.', 299),
(59, 15, 'Push-up Bar', '7.jfif', 'Push-up bars for comfortable and effective upper body training. Reduces strain on wrists and joints.', 399),
(60, 15, 'Gym Weight Plate 5kg', '9.jfif', 'Cast iron weight plates for strength training. Durable and suitable for all types of weightlifting bars.', 249),

-- Music Category (cat_id = 16)
(61, 16, 'Acoustic Guitar', '1.jfif', 'Beginner-friendly acoustic guitar with 6 strings. Includes tuner and learning guide for new players.', 2999),
(62, 16, 'Ukulele Soprano', '5.jfif', 'Compact ukulele perfect for learning or casual playing. Comes with pick and instruction booklet.', 1299),
(63, 16, 'Digital Piano 88 Keys', '7.jfif', 'Full 88-key digital piano with weighted keys. Professional sound quality and multiple built-in rhythms.', 8999),
(64, 16, 'DJ Headphones', '9.jfif', 'Professional DJ headphones with 40mm drivers. Excellent sound isolation and comfort for long listening sessions.', 1999);

-- Note: Run this SQL to insert all the data
-- You can run this in phpMyAdmin or MySQL command line
-- mysql -u root -p ecommerce < sample_data.sql
