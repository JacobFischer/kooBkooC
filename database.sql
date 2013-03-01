-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2013 at 07:02 PM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `koobkooc`
--
CREATE DATABASE `koobkooc` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `koobkooc`;

-- --------------------------------------------------------

--
-- Table structure for table `Allergies`
--

CREATE TABLE IF NOT EXISTS `Allergies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Allergies`
--

INSERT INTO `Allergies` (`ID`, `Name`, `Description`) VALUES
(1, 'Dairy', 'Milk related products: milk, lactose, yogurt, cheese, cream, etc.'),
(2, 'Eggs', 'Bird Eggs'),
(3, 'Peanuts', 'Peanut products: peanut butter, peanut oil, etc.'),
(4, 'Tree Nuts', 'almonds, Brazil nuts, cashews, chestnuts, filberts/hazelnuts, macadamia nuts, coconut, pecans, pine nuts (pignolia nuts), pistachios, and walnuts.'),
(5, 'Seafood', 'Seafood in general: shellfish, scaly fish or crustaceans'),
(6, 'Shellfish', 'shrimp, lobster crawfish, clams, mussels, oysters, etc.'),
(7, 'Soy', 'shoyu sauce, soy (soy albumin, soy fiber, soy flour, soy grits, soy milk, soy nuts, soy sprouts),  soya,  soybean (curd, granules), soybean butter,  soy protein, soy milk, soy sauce, textured vegetable protein (TVP)'),
(8, 'Wheat', 'bread, maltodextrin, bran, couscous, cracker meal, enriched flour, gluten, high-gluten flour, high-protein flour, vital gluten, wheat bran, wheat germ, wheat gluten, wheat malt, wheat starch, wheat flour');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UsersID` int(11) NOT NULL,
  `ParentCommentsID` int(11) DEFAULT NULL,
  `RecipesID` int(11) NOT NULL,
  `Text` text COLLATE utf8_unicode_ci NOT NULL,
  `Time` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `UsersID` (`UsersID`,`ParentCommentsID`),
  KEY `ParentCommentsID` (`ParentCommentsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`ID`, `UsersID`, `ParentCommentsID`, `RecipesID`, `Text`, `Time`) VALUES
(24, 16, NULL, 1, 'Very simple, and can be made with _minimal_ burns', '2012-04-06 19:53:10'),
(25, 18, NULL, 13, 'I''ve had tacos before and I enjoy them', '2012-04-10 18:59:14'),
(26, 16, NULL, 1, 'my very favorite.', '2012-04-12 20:17:26'),
(27, 16, NULL, 20, 'I love when the Havener cafeteria has this.', '2012-04-12 20:58:02'),
(28, 16, NULL, 20, 'I love when the Havener cafeteria has this.', '2012-04-12 20:58:29'),
(29, 16, NULL, 20, 'I love when the Havener cafeteria has this.', '2012-04-12 21:01:27'),
(30, 16, NULL, 20, 'data is good', '2012-04-12 21:02:59'),
(31, 20, NULL, 1, 'the best sandwich', '2012-04-17 16:47:28'),
(32, 20, NULL, 3, 'it''s good', '2012-04-17 17:39:54'),
(33, 22, NULL, 7, 'hey', '2012-04-18 15:40:39'),
(34, 22, NULL, 33, 'uboiub', '2012-04-18 15:41:04'),
(35, 22, NULL, 12, 'uohiohj', '2012-04-18 15:41:11'),
(36, 22, NULL, 9, 'hhhiii', '2012-04-18 15:41:19'),
(37, 14, NULL, 20, 'POTAPO SOUP IS APESOMEPS', '2012-04-18 16:55:35'),
(38, 24, NULL, 35, 'shit on a plate ', '2012-04-19 15:56:36'),
(39, 24, NULL, 35, 'its terrible', '2012-04-19 15:57:19'),
(40, 20, NULL, 1, 'woot', '2012-04-19 15:58:04'),
(41, 20, NULL, 1, 'woot', '2012-04-19 15:58:21'),
(42, 24, NULL, 35, 'woot', '2012-04-19 15:58:38'),
(43, 20, NULL, 3, 'woot', '2012-04-19 16:16:46'),
(44, 25, NULL, 31, 'hi', '2012-04-19 16:18:17'),
(45, 25, NULL, 35, 'lol', '2012-04-19 16:19:04'),
(46, 20, NULL, 19, 'ack', '2012-04-19 17:22:48'),
(47, 20, NULL, 30, '_italic_ text', '2012-04-19 17:25:54'),
(48, 19, NULL, 50, 'I would eat this if I liked asparagus', '2012-04-25 15:57:38'),
(49, 16, NULL, 3, 'it''s the cheesiest!', '2012-04-25 16:25:51'),
(50, 20, NULL, 55, 'woot', '2012-04-25 16:30:00'),
(51, 19, NULL, 54, 'The picture makes it look especially delicious', '2012-04-25 16:30:34'),
(52, 19, NULL, 7, 'Hey Mike. ', '2012-04-25 16:34:30'),
(53, 25, NULL, 54, 'what the... tacos 4l', '2012-04-25 16:40:55'),
(54, 21, NULL, 54, 'WTH is that?', '2012-04-25 16:41:26'),
(55, 23, NULL, 54, 'This is the worst recipe and picture ever. Who ever submitted this is bad and should feel bad. They are the scum of the earth and a disgrace to all of humanity. ', '2012-04-25 16:45:19'),
(56, 23, NULL, 54, 'I hate this', '2012-04-25 16:46:22'),
(57, 16, NULL, 3, 'Test with ! mark', '2012-04-25 16:47:10'),
(58, 19, NULL, 30, 'I really like food!', '2012-04-25 16:49:16'),
(59, 34, NULL, 1, 'Excellent recipe!  :D', '2012-04-26 19:28:31'),
(60, 35, NULL, 1, 'Hi Billy.', '2012-04-26 19:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `Cookware`
--

CREATE TABLE IF NOT EXISTS `Cookware` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ImageURL` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `Cookware`
--

INSERT INTO `Cookware` (`ID`, `Name`, `Description`, `ImageURL`) VALUES
(1, 'Blender', 'A blender, no Bender from Futurama', NULL),
(2, 'Spork', 'The best thing ever', NULL),
(3, 'Skillet', 'Frying pan (cast-iron, stainless, non-stick)', NULL),
(4, 'Pot', 'Standard boiling pot', NULL),
(5, 'Crock pot', 'Large Pot (self-heating, lid): typically used for stews and sauces', NULL),
(6, 'Baking sheet', 'Flat shallow sheet, used for baking', NULL),
(7, 'Pizza Pan', 'Round baking sheet', NULL),
(8, 'Spatula', 'Flat surface with a long handle, used for lifting and flipping hot foods.', NULL),
(9, 'Mixing Bowl', 'Bowl used for mixing wet or dry ingredients.', NULL),
(10, 'Whisk', 'long narrow handle w/ a series of wire loops joined at the end, used to blend ingredients or aerate a mixture.', NULL),
(11, 'Ladle', 'Deep spoon w/ long handle, used for serving hot liquids', NULL),
(12, 'Plate', 'Flat surface used to serve food.', NULL),
(13, 'Pressure Cooker', 'Large air-tight pot, increases boiling point of water allowing liquids to rise to higher temperature w/out boiling.', NULL),
(14, 'Oven Roaster', 'deep roasting pan with lid, for large portions of meat', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Favorites`
--

CREATE TABLE IF NOT EXISTS `Favorites` (
  `UsersID` int(11) NOT NULL,
  `RecipesID` int(11) NOT NULL,
  PRIMARY KEY (`UsersID`,`RecipesID`),
  KEY `RecipesID` (`RecipesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Favorites`
--

INSERT INTO `Favorites` (`UsersID`, `RecipesID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Followings`
--

CREATE TABLE IF NOT EXISTS `Followings` (
  `StalkingUsersID` int(11) NOT NULL,
  `StalkerUsersID` int(11) NOT NULL,
  PRIMARY KEY (`StalkingUsersID`,`StalkerUsersID`),
  KEY `StalkerUsersID` (`StalkerUsersID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Followings`
--

INSERT INTO `Followings` (`StalkingUsersID`, `StalkerUsersID`) VALUES
(1, 2),
(1, 3),
(4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Ingredients`
--

CREATE TABLE IF NOT EXISTS `Ingredients` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `BaseUnitOfMeasure` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ImageURL` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=128 ;

--
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`ID`, `Name`, `BaseUnitOfMeasure`, `Description`, `ImageURL`) VALUES
(1, 'Oregano', 'tsp', 'Spice (common in Italian recipes)', NULL),
(2, 'Black Pepper', 'tsp', 'Crushed Black-Pepper corns', NULL),
(3, 'Salt', 'tsp', 'Granulated iodized sodium-chloride', NULL),
(4, 'Sea Salt', 'tsp', 'sodium-chloride(and other mineral components) extracted from sea-water via evaporation.', NULL),
(5, 'Olive Oil', 'cups', 'Cooking oil extracted from olives', NULL),
(6, 'Canola Oil', 'cups', 'Cooking oil extracted from rapseed or field-mustard seeds', NULL),
(7, 'Potato', 'oz', 'Starchy vegetable', NULL),
(8, 'Cheese', 'oz', 'Proteins and fat extracted from various animals'' milk. (various types)', NULL),
(9, 'Bread', 'slice', 'Baked dough(flour and water)', NULL),
(10, 'Butter', 'tsp', 'Extract of churned cream or milk', NULL),
(11, 'Tomato', 'slice', 'Tomato', NULL),
(12, 'Bologna', 'slice', 'Sandwich Meat', NULL),
(13, 'chicken breast', 'pound', 'raw skinless chicken breast', NULL),
(14, 'oranges', 'slice', 'quarter slice of orange', NULL),
(15, 'apples', 'whole', 'whole apple red or green', NULL),
(16, 'vanilla icecream', 'scoop', 'vanilla icecream', NULL),
(17, 'rice krispies', 'cups', 'rice kripsies cereal', NULL),
(18, 'Barbecue Sauce', 'cups', 'Sweet n Smoky Barbecue Sauce', NULL),
(19, 'Tilapia', 'fillet', 'Slices of tilapia', NULL),
(20, 'ground beef', 'pound', 'ground beef', NULL),
(23, 'Egg', 'whole', 'Unfertilized Chicken Eggs', NULL),
(24, 'Beer', 'oz', 'A fermented mix of grain and hops.', NULL),
(25, 'Mushrooms', 'cup', 'any type of edible mushroom', NULL),
(27, 'Peanut Butter', 'Tsp', 'Creamy, ground up peanuts', NULL),
(28, 'Grape Jelly', 'Tsp', 'Any type of fruit jelly', NULL),
(29, 'Root Beer', 'oz', 'a carbonated, sweetened beverage, originally made using the root of a sassafras plant', NULL),
(30, 'Banana', 'whole', 'A fruit that is long and yellow.', NULL),
(31, 'Peanut', 'oz', 'Peanuts that come from the ground.', NULL),
(32, 'Eggplant', 'whole', 'A vegetable that is purple and looks like a large pear?', NULL),
(33, 'Cherries', 'oz', 'Sweet fruits that go great on things.', NULL),
(34, 'Ground Turkey', 'pound', 'A pound of ground turkey meat', NULL),
(35, 'Taco Shell', 'Taco Shell', 'A hard shell made of corn or flour to make tacos', NULL),
(36, 'Flour Tortilla', 'Tortilla', 'A round flour canvas to paint your tacos on.', NULL),
(37, 'Lettuce', 'oz', 'A vegetable used to decorate food or base ingredient in salad', NULL),
(38, 'Scallops', 'Scallop', 'soft squishy yummy scallop obtained from salt-water? locations', NULL),
(39, 'Chocolate Ice Cream', 'scoop', 'Ice Cream with chocolate added', NULL),
(40, 'Pineapple', 'oz', 'A fruit that goes in desserts usually.', NULL),
(41, 'Chocolate', 'oz', 'Sweet that is created from the cocoa bean.', NULL),
(42, 'Cashew', 'oz', 'A type of nut used as a snack or ingredient', NULL),
(43, 'Sour Cream', 'dallop', 'Cream that is sour', NULL),
(44, 'Onion', 'oz', 'Vegetable (round-white)', NULL),
(45, 'Cilantro', 'oz', 'Herb', NULL),
(46, 'Garlic', 'oz', 'Vegetable (used for seasoning)', NULL),
(47, 'Lime', 'whole', 'Citrus fruit (green)', NULL),
(48, 'Jalapeno', 'whole', 'Pepper (fruit used for seasoning)', NULL),
(49, 'Avacado', 'whole', 'Fruit (green-fatty-rich)', NULL),
(50, 'Cayenne', 'oz', 'Spice (dried-ground cayenne pepper)', NULL),
(51, 'Taco sauce', 'tbsp', 'Taco Sauce', NULL),
(52, 'Carrot', 'oz', 'Vegetable (orange root)', NULL),
(53, 'Red Wine', 'cup', 'Alcoholic beverage (for drinking or cooking)', NULL),
(54, 'Beef Stock', 'cup', 'Beef (bone marrow) infused  water', NULL),
(55, 'Nutmeg', 'tsp', 'Spice', NULL),
(56, 'Spaghetti noodles', 'oz', 'Noodles made from eggs and flour', NULL),
(57, 'Saffron', 'oz', 'an expensive spice', NULL),
(62, 'Cinnamon', 'tspn', 'The sweet kind that everyone loves.', NULL),
(63, 'Fettuccine Pasta', 'cup', 'a type of pasta popular in Roman Cuisine', NULL),
(64, 'Bacon', 'strip', 'cured pork strips', NULL),
(65, 'Cream', 'oz', 'dairy product composed of high-butterfat layer skimmed from the top of milk before homogenization', NULL),
(66, 'Bread Crumbs', 'cup', 'bread crumbs', NULL),
(67, 'Parsley', 'tblsp', 'herb', NULL),
(68, 'Parmesan', 'tblsp', 'parmesan cheese', NULL),
(69, 'Garlic Powder', 'tsp', 'garlic powder', NULL),
(70, 'Canned Tomatoes', 'oz', 'tomatoes in a can', NULL),
(71, 'Sugar', 'tsp / cup', 'white granulated cane sugar', NULL),
(72, 'Bay Leaf', '1 leaf', 'herb', NULL),
(73, 'Tomato Paste', 'oz', 'tomato puree', NULL),
(74, 'Basil', 'tsp', 'herb', NULL),
(75, 'Sausage (Italian)', 'lb', 'spiced and sweet Italian sausage', NULL),
(76, 'Water', 'cup', 'water', NULL),
(77, 'Fennel Seeds', 'tsp', 'seeds from a fennel plant', NULL),
(78, 'Italian Seasoning', 'tsp', 'herbs and spices for an "Italian" flavor', NULL),
(79, 'Lasagna Noodles', '1 noodle', 'large flat noodle used for layering', NULL),
(80, 'Ricotta', 'oz', 'ricotta cheese', NULL),
(81, 'Mozzarella', 'oz / lb', 'mozzarella cheese (from buffalo milk)', NULL),
(83, 'Beef Brisket', 'lb', 'meat cut from under the first 5 ribs', NULL),
(84, 'Brown Sugar', 'cup', 'sugar and molasses', NULL),
(85, 'Stout Beer', 'oz', 'distinct flavor of beer', NULL),
(92, 'Curry', 'table spoon', 'Delicious yellow spice', NULL),
(96, 'Corncob', '1 corncob', 'an ear of corn', NULL),
(97, 'Lemon', 'Whole Lemon', 'Citrus Fruit(yellow)', NULL),
(99, 'Asparagus', 'sticks', 'Elongated green healthy vegetable', NULL),
(100, 'Cucumber', 'slice', 'Green Long Vegetable', NULL),
(102, 'Strawberry Jelly', 'tsp', 'strawberry flavored jelly', NULL),
(105, 'Feta', 'lb', 'Cheese', NULL),
(106, 'Olives', 'cup', 'green or black', NULL),
(107, 'Balsamic Vinegar', 'cup', 'condiment from Italy, commonly used for salad dressing together with oil', NULL),
(108, 'Yogurt (plain)', 'cup', 'a dairy product produced by bacterial fermentation of milk', NULL),
(109, 'Mint', 'cup', 'herb', NULL),
(110, 'Soy Sauce', 'cup', 'a condiment produced by fermenting soybeans', NULL),
(111, 'Karashi Mustard', 'tbsp', 'Mustard used as a seasoning in Japan. Made from the crushed seeds of Brassica Juncea', NULL),
(112, 'Clam', 'lb', 'a bivalved mollusc', NULL),
(113, 'Sake', 'cup', 'Japanese alcoholic beverage made from fermented rice', NULL),
(114, 'Green Onion', 'whole', 'a.k.a "chives", onion-like having hollow green leaves and lacking a fully developed root bulb', NULL),
(115, 'Marshmallows', 'bag', 'fluffy white confection', NULL),
(116, 'Graham Cracker', 'whole', 'a sweet wafer made from graham flour', NULL),
(117, 'Waffle (frozen)', 'whole', 'a batter or dough based cake cooked in a grid-shaped iron', NULL),
(118, 'Maple Syrup', 'tbsp', 'a sweet topping made from the sap of a maple tree', NULL),
(119, 'Shrimp', 'whole', 'small shellfish', NULL),
(121, 'Ramen', 'whole', 'noodles and flavor packet', NULL),
(122, 'Milk', 'cups', 'It comes from a cow', NULL),
(123, 'Blueberries', 'Cups', 'A small blue berry', NULL),
(125, 'Pepperoni', 'oz', 'A spicy Italian-American variety of salami (a dry sausage) usually made from cured pork and chicken.', NULL),
(126, 'Food Coloring', 'tbsp', 'Doesn''t taste like anything but makes your food funky colors!', NULL),
(127, 'Salmon', 'oz', 'Pink Fish', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Recipes`
--

CREATE TABLE IF NOT EXISTS `Recipes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SubmitterUsersID` int(11) NOT NULL,
  `Name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Directions` text COLLATE utf8_unicode_ci NOT NULL,
  `Servings` int(11) DEFAULT NULL,
  `ImageURL` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `SubmitterUsersID` (`SubmitterUsersID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=59 ;

--
-- Dumping data for table `Recipes`
--

INSERT INTO `Recipes` (`ID`, `SubmitterUsersID`, `Name`, `Directions`, `Servings`, `ImageURL`, `Description`) VALUES
(1, 1, 'Grilled Cheese', 'Spread 1 tsp of butter on 1 side of both pieces of bread.\r\n\r\nHeat skillet to med-high heat.\r\n\r\nPlace 1 piece of bread, butter-side down, in skillet.\r\n\r\nPlace slice of cheese on bread in skillet.\r\n\r\nPlace 2nd piece of bread on top of cheese, butter side up.\r\n\r\nLet bottom remain on skillet until golden brown. Flip and repeat.', 1, NULL, 'A simple grilled cheese sandwich'),
(2, 4, 'Tomato Grilled Cheese', 'Spread 1 tsp of butter on 1 side of both pieces of bread.\r\n\r\nHeat skillet to med-high heat.\r\n\r\nPlace 1 piece of bread, butter-side down, in skillet.\r\n\r\nPlace slice of cheese on bread in skillet.\r\n\r\nPlace tomato slice on cheese.\r\n\r\nPlace 2nd piece of bread on top of tomato, butter side up.\r\n\r\nLet bottom remain on skillet until golden brown. Flip and repeat.', 1, NULL, 'A grilled cheese sandwich with tomatoes'),
(3, 4, 'Macaroni and Cheese', '1.Boil water\r\n2.Cook macaroni in water\r\n3.Drain macaraoni\r\n4.Return macaroni to pot\r\n5.Add cheese and stir until cheese is melted.', 1, NULL, 'Boiled macaroni noodles blended with the finest cheeses'),
(4, 2, 'Beer Omelette', 'Beat eggs, beer, and butter into a smooth mixture.  Heat pan to medium and then pour the mixture in.  Once the bottom starts to cook, add in tomatoes and mushrooms.  Let it cook a little longer then fold it over and let it continue to cook to your liking.  Enjoy!', 1, NULL, 'An omelette the way real men eat them'),
(5, 4, 'Hamburger', 'Cook ground beef and place it on a bread bun. ', 1, NULL, 'The minimalist''s burger'),
(7, 2, 'Cheese Burger', 'Cook ground beef.\r\nPlace the cooked beef on a bun.\r\nPlace a slice of cheese on the bun.\r\nEnjoy.', 1, NULL, 'A burger with cheese. The real way to eat them'),
(9, 3, 'Peanut Butter and Jelly', 'Acquire two pieces of bread. \r\n\r\nPlace two or three Tsp of peanut butter on a piece of bread. \r\n\r\nPlace two or three Tsp of jelly butter on the other piece of bread. \r\n\r\nPut the two pieces of bread together. \r\n\r\nEnjoy', 1, NULL, 'All you friends will be peanut butter and jealous when you have this'),
(10, 3, 'Root Beer Float', 'Pour a can of Root Beer into a cup and add the desired amount of ice cream scoops.', 1, NULL, 'Delicious, non-nutritious, and non-alchoholic '),
(11, 3, 'Salsa', 'Mexican style salsa dip. Simple preparation using fresh ingredients. Makes 4 cups.\r\n\r\nIngredients:\r\n\r\n    4 ripe tomatoes (diced)\r\n    1 medium onion (diced)\r\n    1/2 cup cilantro (diced and fresh)\r\n    3 cloves garlic (minced)\r\n    1 tablespoon fresh squeezed lime juice\r\n    seasoning to taste\r\n    1 jalapeno, (diced)\r\n\r\nInstructions:\r\n\r\n    Combine together all ingredients, except the jalapeno, in a bowl. Mix thoroughly. Add in only half of the jalapeno, and tomatillo (optional), and taste. Add additional spice by increasing the amount of jalapeno used, taste after each addition. Chill in fridge for at least one hour before serving.\r\n', 4, NULL, 'Simple Salsa Dip'),
(12, 3, 'Guacamole', 'This delicious dip is a must have for your Cinco de Mayo celebration! Serves 4.\r\n\r\nIngredients:\r\n\r\n    3 large avocados (prepared)\r\n    juice of 1 lime\r\n    1 teaspoon salt\r\n    1/2 cup onion (diced)\r\n    3 tablespoons cilantro (chopped and fresh)\r\n    2 roma tomatoes (chopped)\r\n    1 teaspoon garlic (finely minced)\r\n    1 pinch cayenne\r\n\r\nInstructions:\r\n\r\n    Prepare avocados: peel, pit, and mash.\r\n    In a bowl, mix together the prepared avocados, salt and lime juice. Add in the diced onion, tomatoes, cilantro and garlic. Add in the cayenne pepper if you like a little spice. Let chill in the fridge for at least one hour.\r\n', 4, NULL, 'Fresh Mexican Guacamole'),
(13, 4, 'Tacos', 'Tacos are so easy to make there is no reason to go out for them. Learn how to make beef tacos at home. They taste so much better when you don’t use pre mixes. Serve with seasoned beef, taco shells and desired toppings.\r\n\r\nIngredients\r\n\r\n    1 lb of ground beef\r\n    1 large onion, chopped\r\n    salt and freshly ground black pepper to taste\r\n    lettuce,tomato,cheese for filling\r\n    1 garlic clove, crushed\r\n    1 packet of taco shells\r\n    1 cup of green chili or taco sauce\r\n\r\nCooking Instructions\r\n\r\nPreheat the oven to 350 ° F (180 ° C).\r\n\r\nLine the oven tray with baking paper and place the taco shells on tray, evenly spread apart. Heat the tacos until hot, for about 5 minutes. You don’t want to brown them.\r\n\r\nSaute the ground beef in a hot saucepan until browned. Add the onion and continue to cook until lightly browned.\r\n\r\nAdd a pinch of salt and black pepper to taste. You can also add some garlic if you like the taste.\r\n\r\nSpoon a large tablespoon of meat mixture in each individual taco shell and stuff with lettuce, tomato and cheese.\r\n\r\nPour green chili or taco sauce on top of the beef tacos for some extra flavor.\r\n\r\nServe the tacos immediately while still warm.', 10, NULL, 'Mexican Beef Tacos'),
(14, 5, 'Spaghetti Bolognese', 'Spaghetti Bolognese is a popular italian recipe which is simple to make. Serves 4-6.\r\n\r\nIngredients\r\n\r\n    3 cups of dried spaghetti\r\n    2 tablespoons of olive oil\r\n    1 onion, finely chopped\r\n    1 carrot, chopped\r\n    1 garlic clove, crushed\r\n    1 lb of minced beef\r\n    1/2 cup of red wine\r\n    13 oz of canned tomatoes\r\n    1 cup of beef stock\r\n    2 tablespoons of dried oregano\r\n    pinch of nutmeg\r\n    salt and pepper to taste\r\n    parmesan cheese, shavings\r\n\r\nCooking Instructions\r\n\r\nHeat oil in a large saucepan and cook the onion and carrot, until soft and slightly colored. This should only take a few minutes.\r\n\r\nAdd the garlic and minced beef to the vegetable mixture. Cook until the meat starts to brown. Break up any lumps of meat with a fork.\r\n\r\nAdd the red wine and continue to cook, stirring occasionally, until the wine has pretty much evaporated. Add the tomato, stock, tomato paste, oregano, and nutmeg, and cook over a low heat for 1 1/2 hours, stirring occasionally. Season with salt and freshly ground black pepper.\r\n\r\nJust before the completion of cooking the sauce, cook the spaghetti following packet directions, until the pasta is al dente. Drain well and place the spaghetti back into the saucepan and stir in the sauce.\r\n\r\nServe immediately in serving plates with parmesan shavings on top.', 6, NULL, 'Spaghetti Bolognese'),
(17, 1, 'Cheesey Baked Potato', 'Bake potato in oven for 20 minutes at 300 degrees. Add cheese  after removing carefully. Add 5 black peppers for additional kick of flavor.', 1, 'NULL', 'A delicious blend of fresh potato, fine cheese, and spicy black pepper.  '),
(19, 1, 'Rice Krispy Kream', 'Put chocolate and vanilla ice cream in a bowl. Beak up rice krispy and crumbled on top of ice cream. Melt chocolate bar and drizzle over ice cream and rice krispy mix.', 1, 'NULL', 'A delicious and easy to make treat for any occasion. '),
(20, 1, 'Potato Soup', 'Add all dat stuff in a pot and cook it.', 10, 'NULL', 'Potato like soup.'),
(28, 16, 'Buttered Bread', '# Get your bread ready\n# Smear butter on the bread\n# _optional_ heat it up in the microwave for 5 seconds\n# Enjoy!', 1, 'NULL', 'It''s bread, and it is buttered. That simple/'),
(29, 15, 'Fettuccine Carbonara', 'This fettuccine carbonara recipe is a classic italian pasta dish. The creamy white sauce compliments the mushrooms and bacon. Serves 4.\r\n\r\nIngredients\r\n\r\n    5 cups of fettuccine pasta\r\n    6 bacon rashers, thinly sliced\r\n    1 cup of button mushrooms, thinly sliced\r\n    10 oz of cream\r\n    4 eggs, lightly beaten\r\n    1 cup of parmesan cheese, grated\r\n\r\nCooking Instructions\r\n\r\nHeat a large saucepan of salted water and bring to a boil. Add the fettuccine pasta and cook for 10 minutes, or until the pasta is al dente. Drain well. Transfer pasta back to pan and cover to keep warm.\r\n\r\nCook the bacon in a large frying pan, stirring occasionally until the bacon is crispy. Stir in the mushrooms into the pan and continue to cook until softened. Add the cream and stir through with the rest of the ingredients.\r\n\r\nWork quickly to combine the bacon mixture, hot pasta, eggs and cheese into the one saucepan.\r\n\r\nServe immediately with some extra parmesan shavings on top if desired.', 4, NULL, 'Italian pasta dish'),
(30, 3, 'Spaghetti & Meatballs', 'A classic dish with lots of flavor! Directions for both the sauce and meatballs. Serves 6.\r\n\r\n\r\nIngredients:\r\n\r\nFor the Meatballs:\r\n\r\n    1 pound ground beef\r\n    1 cup bread crumbs (fresh)\r\n    1 tablespoon dry parsley\r\n    1 tablespoon Parmesan (grated)\r\n    1/4 teaspoon finely ground black pepper\r\n    1/8 teaspoon garlic powder\r\n    1 egg\r\n\r\nFor the Sauce:\r\n\r\n    3/4 cup diced onion\r\n    5 cloves of garlic (minced)\r\n    1/4 cup olive oil\r\n    56 ounces tomatoes (from the can, whole and peeled)\r\n    2 teaspoons salt\r\n    1 teaspoon white sugar\r\n    1 bay leaf\r\n    6 ounces tomato paste\r\n    3/4 teaspoon dried basil\r\n    1/2 teaspoon finely ground black pepper\r\n\r\nInstructions:\r\n\r\n    Beat the egg.\r\n    In a bowl, mix together the egg, and all ingredients listed for the meatballs. Mold about twelve balls. Place in the refrigerator, covered, until needed.\r\n    In a saucepan, grill onion and garlic in olive oil over medium heat until onion is cooked. Add in tomatoes, salt, sugar and bay leaf, stir. Lower the heat and cover, letting simmer 90 minutes. Mix in paste, basil, pepper and add the meatballs. Let simmer another 30 minutes.\r\n', 6, NULL, 'Italian Spaghetti & Meatballs'),
(31, 2, 'Lasagna', 'Classic Lasagna, Serves 12.\r\n\r\nIngredients:\r\n    1 pound sausage (sweet Italian)\r\n    3/4 pound ground beef\r\n    1/2 cup onion (diced)\r\n    2 cloves garlic (crushed)\r\n    28 ounces tomatoes (crushed)\r\n    12 ounces tomato puree\r\n    13 ounces tomato sauce\r\n    1/2 cup water\r\n    2 tablespoons white sugar\r\n    1 1/2 teaspoons basil leaves (dried)\r\n    1/2 teaspoon fennel seeds\r\n    1 teaspoon Italian seasoning\r\n    1 tablespoon salt\r\n    1/4 teaspoon black pepper\r\n    4 tablespoons fresh parsley (diced)\r\n    12 lasagna noodles\r\n    16 ounces ricotta cheese\r\n    1 large egg\r\n    1/2 teaspoon salt\r\n    3/4 pound mozzarella cheese (sliced)\r\n    3/4 cup Parmesan cheese (grated)\r\n\r\nInstructions:\r\n\r\n    Cook the sausage and beef together with the onion and garlic over medium heat in a Dutch style oven, until golden brown. Mix in all tomatoes (crushed, puree, & sauce) and water. Use the sugar, basil, fennel, Italian seasoning, salt (1 TBSP), pepper, and parsley (2 TBSPs) to season. Cover and let simmer for around one and a half hours, stirring often.\r\n    Boil a pot of lightly salted water to cook lasagna noodles, around ten minutes. Drain and then rinse the noodles with cold water. Use a separate bowl to mix together the ricotta cheese with the large egg, the rest of the parsley, and salt (half TSP).\r\n    Heat oven to 375 F (190 C).\r\n    In a 9×13 baking dish, pour in about 1 1/2 cups of the meat mixture evenly. Then place about six noodles on top of meat mixture. Add the ricotta cheese mix next, then about a third of mozzarella cheese slices. Add more of the meat mixture over mozzarella, and then add Parmesan cheese on top. Repeat these instructions to add layers. Sprinkle mozzarella and Parmesan cheese on top to finish. Cover with foil.\r\n    Bake for 25 minutes. Remove foil, and bake for another 25 minutes. Let cool a quarter of an hour.\r\n', 12, NULL, 'classic lasagna'),
(32, 1, 'Corned Beef with Stout Beer', 'Ingredients:\r\n\r\n    4 pounds beef brisket		\r\n    1 cup light brown sugar		\r\n    12 oz stout beer			\r\n    1 cup chopped carrots 		\r\n\r\nInstructions: \r\n\r\n    Heat oven to 300 F (150 C). Prepare brisket: rinse and dry.\r\n    On an oven roasting pan, place in the prepared brisket. Coat beef with sugar \r\n\r\nthoroughly. Add in the carrots, and then the beer, gradually.\r\n    Bake, covered, for two to three hours, or until tender. Let rest before serving.', 10, NULL, 'beer flavored corned beef'),
(33, 18, 'Pizza', 'Put everything on that tortilla like a pizza looks. Then cook it. Beer is for the waiting. Drink responsibly.', 2, 'NULL', 'It''s a pizza and people love it.'),
(34, 19, 'Turkey Omelette', 'Crack two eggs into a bowl. \nMix eggs and pour into skillet.\nAdd mushrooms, cheese, pepper, tomato, and turkey as the eggs cook.\nOnce eggs are nice and cooked flip over to seal in the flavor.\nConsume with bacon.', 1, 'NULL', 'A basic turkey omelette with some special add-ins for an extra kick!'),
(35, 25, 'Curry Chicken', 'Sprinkle curry powder evenly over the chicken breast.  Next, chop the onions small pieces.  Next grind the garlic\nand spread it evenly over chicken.  Put the stove on medium-high.  Add ingredients to a pan and mix thoroughly.  Cook until chicken is well cooked and the onions are soft.  ', 2, 'NULL', 'Delicious chicken breast made with curry.  '),
(41, 21, 'Sliced Feta with Oregano and Olive Oil', 'Put a 1/2 inch slice of feta cheese on a salad plate. Serve it plain, or sprinkle with oregano and pepper. Then drizzle with olive oil. ', 20, 'NULL', 'An appetizer or side dish'),
(42, 21, 'Pasta Elias', 'Grate the garlic. Combine all ingredients in the blender and blend for a few seconds until smooth. The paste will be slightly granular.\n\nServe as a meze with Ouzo or wine, accompanied by small rusks, crusty bread, breadsticks, and/or raw vegetables.', 3, 'NULL', 'Olive Paste Spread with Garlic'),
(43, 21, 'Tzatziki', 'Use a cheese cloth to strain the yogurt over a bowl for 3 to 4 hours, until most of the water has drained. \n\nPuree all ingredients in blender. Chill for 1-2 hrs', 3, 'NULL', 'Greek yogurt sauce made with cucumbers and fresh mint'),
(44, 21, 'Japanese Steamed Eggplant', 'Trim and cut eggplants in halves in lengthwise. Peel the skin in vertical stripes and soak eggplants in water for about 10 minutes. Drain and make long cuts on the surface of each eggplant. Steam them on high heat for about 10 minutes, or until softened. Place them on plates and chill in the refrigerator. Serve soy sauce into individual small plate with some karashi mustard on the side for dipping. ', 4, 'NULL', 'A simple Japanese dish, great for summer time.'),
(45, 21, 'Asari no Sakamushi', 'Soak clams in salted water overnight in the refrigerator. Discard any clams that don''t close at this time. Drain in a colander. Put asari clams in a large skillet and pour sake. Place a lid and steam on high heat for a few minutes until clams open. (Discard any clams that didn''t open after steaming.) Serve steamed asari in a bowl and top with chopped green onion if you would like.', 4, 'NULL', 'Clams steamed with Sake'),
(46, 21, 'Oven S''mores', '    Preheat the oven broiler. Line a small pan with aluminum foil and lightly coat with cooking spray.\n    Break the graham crackers in half and lay 4 of the squares out on a serving plate. Break the candy bars in half and lay one piece on each of the graham crackers on the plate.\n    Arrange the marshmallows in a single layer in the prepared pan.\n    Broil the marshmallows until the tops brown, turn the marshmallows to brown the undersides. Keep a close eye on the marshmallows so they do not burn. They will brown very quickly.\n    Remove the marshmallows from the pan and place three on each of the chocolate squares. Top with the remaining graham cracker halves.\n', 4, 'NULL', 'classic american children''s snack'),
(47, 21, 'IceCream Waffle Sandwich', 'Toast the frozen waffle, immediately spread with butter and cut the waffle in half. Place a scoop of ice cream on one half of the waffle, distributing evenly. Drizzle the ice cream with maple syrup; top the ice cream with the other half of the waffle and gently press to seal the sandwich. ', 1, 'NULL', 'a simple dessert sandwich'),
(48, 21, 'Shrimp Lo Mein (easy)', '1: Clean, then boil your shrimp for 10 minutes.\n\n2: Add ramen noodles to boiling water. DO NOT add packet to water.\n\n3: Drain the water from the noodles and shrimp, leaving just enough to help melt the butter.\n\n4: Add the butter and mix until all noodles and shrimp have a buttery coating.\n\n5: Mix in the flavoring packet. Serve while hot\n\n(you can also add some of your favorite steamed vegetables)', 1, 'NULL', 'Quick and easy Shrimp Lo Mein at home'),
(49, 21, 'Cinnamon Fruit Smoothie', 'Peel bananas\nPeel and chop apples\nAdd all ingredients to blender, and puree until smooth and well mixed.\nChill for an hour. Serve cold.', 2, 'NULL', 'a fruit smoothie spiced with cinnamon'),
(50, 21, 'Vegetable Stir-Fry', 'Cut asparagus sticks into quarters\nDice carrots into small cubes\nDice green onions into 1/8 in rings\nAdd canola oil to wok(or frying pan)\nAdd green onions and carrots to wok. Fry until carrots soften\nAdd asparagus and fry until asparagus begins to wilt.\nAdd cucumber slices, and remove wok from heat after 30sec\nSprinkle garlic powder and cashews evenly, then mix.\nPlace wok back on heat for 30 secs and remove.\nDrain excess oil, drizzle with soy sauce, and serve.', 3, 'NULL', 'Chinese vegetable stir fry.'),
(51, 21, 'Oriental Sauteed Scallops', 'Melt butter in a pot\nAdd soy sauce and sake to melted butter, and mix\nDivide this mixture between two skillets\nSautee mushrooms in one skillet, scallops in the other.\nPlate a base of mushrooms, place scallops on top', 1, 'NULL', 'Oriental style sauteed scallops'),
(52, 21, 'Stuffed Tilapia', 'Crush and mince garlic\nSlice mushrooms\nChop asparagus\nChop cashews\nAdd asparagus, mushrooms, and garlic to blender\n  Do not over blend, mixture should be lumpy\nSpread this mixture over the tilapia fillet\nRoll ovr the fillet short-ways, so it looks like a burrito\nWrap the fillet in foil, and grill for 10-15 min\nSprinkle on the chopped cashews', 1, 'NULL', 'Tilapia fillet stuffed with chinese flavor'),
(53, 21, 'BBQ Chicken Breast', 'Generously apply barbecue sauce to fresh raw chicken breast\nGrill for 10 minutes\nFlip, then grill for another 10 minutes\nAdd more Barbecue Sauce\nServe Hot!', 1, 'NULL', 'Barbecue Chicken Breast'),
(54, 18, 'Hot Dogs', 'Cook the hot dog sausages over heat until it''s cooked and to desired temperature then put it on a slice of bread add ketchup and mustard if you want.', 4, 'NULL', 'A hot dog!'),
(55, 20, 'Mashed Potatoes', 'Place potatoes in a saucepan and cover with water. Cover and bring to a boil; cook for 20-25 minutes or until very tender. Drain well. Add milk, butter, salt and any other desired seasonings such as pepper; mash until light and fluffy. ', 6, 'NULL', 'Fluffy, traditional mashed potatoes.'),
(57, 16, 'Pepperoni Pizza', 'Position one oven rack in the middle setting. Position another rack in the lowest setting, and place a rimless baking sheet on the bottom rack. Preheat oven to 500°.\n\nHeat a large nonstick skillet over medium-high heat. Coat pan with cooking spray. Add sliced mushrooms to pan, and sauté for 5 minutes or until moisture evaporates.\n\nRemove plastic wrap from Basic Pizza Dough; discard. Brush oil over dough. Remove preheated baking sheet from oven; close oven door. Slide dough onto preheated baking sheet, using a spatula as a guide. Bake on lowest oven rack at 500° for 8 minutes. Remove from oven.\n\nSpread Basic Pizza Sauce in an even layer over crust, leaving a 1/4-inch border. Top sauce with mushrooms. Sprinkle mushrooms evenly with mozzarella and Parmesan. Arrange pepperoni in an even layer on top of cheese. Bake on middle rack an additional 10 minutes or until crust is golden brown and cheese melts. Cut into 12 wedges.', 8, 'NULL', 'Mix up this classic pepperoni pizza recipe with pepperoni''s earthy flavor to this familiar favorite, but they''re optional if you''re a pizza purist.'),
(58, 35, 'Wild Alaskan Salmon', 'Combine all spices. Generously rub the spice mixture on the flesh side of the salmon and drizzle with a light coat of oil. Place the salmon on the grill, flesh side first. Let cook for about 7 to 10 minutes each side.\n\ndrink with beer!', 10, 'NULL', 'Delicious wild Alaskan Salmon.  Now with Beer!');

-- --------------------------------------------------------

--
-- Table structure for table `RecipesAllergies`
--

CREATE TABLE IF NOT EXISTS `RecipesAllergies` (
  `RecipesID` int(11) NOT NULL,
  `AllergiesID` int(11) NOT NULL,
  PRIMARY KEY (`RecipesID`,`AllergiesID`),
  KEY `AllergiesID` (`AllergiesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `RecipesAllergies`
--

INSERT INTO `RecipesAllergies` (`RecipesID`, `AllergiesID`) VALUES
(1, 1),
(2, 1),
(13, 1),
(14, 1),
(29, 1),
(30, 1),
(31, 1),
(14, 2),
(29, 2),
(30, 2),
(31, 2),
(9, 3),
(30, 7),
(31, 7),
(1, 8),
(2, 8),
(14, 8),
(29, 8),
(30, 8),
(31, 8);

-- --------------------------------------------------------

--
-- Table structure for table `RecipesCookware`
--

CREATE TABLE IF NOT EXISTS `RecipesCookware` (
  `RecipesID` int(11) NOT NULL,
  `CookwareID` int(11) NOT NULL,
  PRIMARY KEY (`RecipesID`,`CookwareID`),
  KEY `CookwareID` (`CookwareID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `RecipesCookware`
--

INSERT INTO `RecipesCookware` (`RecipesID`, `CookwareID`) VALUES
(1, 3),
(2, 3),
(13, 3),
(14, 3),
(29, 3),
(30, 3),
(14, 4),
(29, 4),
(30, 4),
(31, 4),
(31, 5),
(13, 6),
(31, 6),
(1, 8),
(2, 8),
(11, 9),
(12, 9),
(30, 9),
(31, 9),
(32, 14);

-- --------------------------------------------------------

--
-- Table structure for table `RecipesIngredients`
--

CREATE TABLE IF NOT EXISTS `RecipesIngredients` (
  `RecipesID` int(11) NOT NULL,
  `IngredientsID` int(11) NOT NULL,
  `Amount` float DEFAULT NULL,
  PRIMARY KEY (`RecipesID`,`IngredientsID`),
  KEY `IngredientsID` (`IngredientsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `RecipesIngredients`
--

INSERT INTO `RecipesIngredients` (`RecipesID`, `IngredientsID`, `Amount`) VALUES
(1, 8, 2),
(1, 9, 2),
(1, 10, 0.75),
(2, 8, NULL),
(2, 9, NULL),
(2, 10, NULL),
(2, 11, NULL),
(3, 8, NULL),
(4, 10, NULL),
(4, 11, NULL),
(4, 23, NULL),
(4, 24, NULL),
(4, 25, NULL),
(5, 9, NULL),
(5, 20, NULL),
(7, 8, NULL),
(7, 9, NULL),
(7, 20, NULL),
(9, 9, NULL),
(9, 27, NULL),
(9, 28, NULL),
(10, 16, NULL),
(10, 29, NULL),
(11, 11, NULL),
(11, 44, NULL),
(11, 45, NULL),
(11, 46, NULL),
(11, 47, NULL),
(11, 48, NULL),
(12, 3, NULL),
(12, 11, NULL),
(12, 44, NULL),
(12, 45, NULL),
(12, 46, NULL),
(12, 47, NULL),
(12, 49, NULL),
(12, 50, NULL),
(13, 2, NULL),
(13, 3, NULL),
(13, 8, NULL),
(13, 11, NULL),
(13, 20, NULL),
(13, 35, NULL),
(13, 37, NULL),
(13, 44, NULL),
(13, 51, NULL),
(14, 1, NULL),
(14, 2, NULL),
(14, 3, NULL),
(14, 5, NULL),
(14, 8, NULL),
(14, 11, NULL),
(14, 20, NULL),
(14, 44, NULL),
(14, 46, NULL),
(14, 52, NULL),
(14, 53, NULL),
(14, 54, NULL),
(14, 55, NULL),
(14, 56, NULL),
(17, 2, 5),
(17, 7, 1),
(17, 8, 1),
(19, 16, 1),
(19, 17, 1),
(19, 39, 1),
(19, 41, 1),
(20, 2, 3),
(20, 3, 1),
(20, 5, 3),
(20, 7, 10),
(20, 8, 4),
(20, 44, 2),
(20, 54, 5),
(28, 9, 1),
(28, 10, 0.5),
(29, 8, 1),
(29, 23, 4),
(29, 25, 1),
(29, 63, 5),
(29, 64, 6),
(29, 65, 10),
(30, 2, 0.25),
(30, 3, 2),
(30, 5, 0.25),
(30, 20, 1),
(30, 23, 1),
(30, 44, 0.75),
(30, 46, 5),
(30, 66, 1),
(30, 67, 1),
(30, 68, 1),
(30, 69, 0.125),
(30, 70, 56),
(30, 71, 1),
(30, 72, 1),
(30, 73, 6),
(30, 74, 0.5),
(31, 2, 0.25),
(31, 3, 1),
(31, 11, 28),
(31, 20, 0.75),
(31, 23, 1),
(31, 44, 0.5),
(31, 46, 2),
(31, 67, 4),
(31, 68, 0.75),
(31, 71, 2),
(31, 73, 25),
(31, 74, 1.5),
(31, 75, 1),
(31, 76, 0.5),
(31, 77, 0.5),
(31, 78, 1),
(31, 79, 12),
(31, 80, 16),
(31, 81, 0.75),
(32, 52, 1),
(32, 83, 4),
(32, 84, 1),
(32, 85, 12),
(33, 1, 1),
(33, 3, 1),
(33, 8, 2),
(33, 24, 6),
(33, 36, 1),
(33, 44, 1),
(33, 68, 1),
(33, 73, 1),
(34, 2, 2),
(34, 8, 1),
(34, 11, 1),
(34, 23, 2),
(34, 25, 1),
(34, 34, 1),
(35, 13, 2),
(35, 44, 2),
(35, 46, 2),
(35, 92, 2),
(41, 1, 1),
(41, 2, 1),
(41, 5, 1),
(42, 5, 0.25),
(42, 46, 1),
(42, 106, 3),
(42, 107, 0.25),
(43, 2, 0.25),
(43, 3, 0.5),
(43, 46, 2),
(43, 100, 20),
(43, 108, 2),
(43, 109, 0.25),
(44, 32, 4),
(44, 110, 1),
(44, 111, 4),
(45, 112, 1),
(45, 113, 0.33),
(45, 114, 1),
(46, 41, 2),
(46, 115, 1),
(46, 116, 4),
(47, 10, 1),
(47, 16, 1),
(47, 117, 1),
(47, 118, 1),
(48, 10, 2),
(48, 119, 10),
(48, 121, 1),
(49, 15, 2),
(49, 16, 4),
(49, 30, 4),
(49, 33, 4),
(49, 62, 3),
(50, 6, 0.5),
(50, 42, 1),
(50, 52, 10),
(50, 69, 2),
(50, 99, 6),
(50, 100, 20),
(50, 110, 0.25),
(50, 114, 3),
(51, 10, 10),
(51, 25, 0.25),
(51, 38, 3),
(51, 110, 0.125),
(51, 113, 0.25),
(52, 19, 1),
(52, 25, 0.125),
(52, 42, 0.25),
(52, 46, 0.25),
(52, 99, 1),
(53, 13, 1),
(53, 18, 1),
(54, 9, 8),
(54, 75, 1),
(55, 3, 0.75),
(55, 7, 24),
(55, 10, 12),
(55, 122, 0.5),
(57, 1, 4),
(57, 8, 10),
(57, 36, 1),
(57, 68, 4),
(57, 73, 6),
(57, 125, 6),
(58, 24, 60),
(58, 69, 1),
(58, 127, 80);

-- --------------------------------------------------------

--
-- Table structure for table `RecipesTags`
--

CREATE TABLE IF NOT EXISTS `RecipesTags` (
  `RecipesID` int(11) NOT NULL,
  `TagsID` int(11) NOT NULL,
  PRIMARY KEY (`RecipesID`,`TagsID`),
  KEY `TagsID` (`TagsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `RecipesTags`
--

INSERT INTO `RecipesTags` (`RecipesID`, `TagsID`) VALUES
(11, 1),
(12, 1),
(13, 1),
(14, 2),
(29, 2),
(30, 2),
(31, 2),
(33, 2),
(57, 2),
(48, 3),
(50, 3),
(51, 3),
(52, 3),
(1, 4),
(2, 4),
(3, 4),
(17, 4),
(19, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(34, 4),
(46, 4),
(53, 4),
(54, 4),
(58, 4),
(41, 5),
(42, 5),
(43, 5),
(44, 6),
(45, 6),
(51, 6),
(17, 7),
(20, 7),
(32, 7),
(11, 8),
(12, 8),
(11, 9),
(12, 9),
(49, 9),
(50, 9),
(55, 9),
(13, 10),
(14, 10),
(29, 10),
(30, 10),
(31, 10),
(32, 10),
(35, 19),
(53, 21),
(54, 21),
(4, 23),
(32, 23),
(10, 25),
(19, 25),
(46, 25),
(47, 25),
(49, 25);

-- --------------------------------------------------------

--
-- Table structure for table `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `Tags`
--

INSERT INTO `Tags` (`ID`, `Name`, `Description`) VALUES
(1, 'Mexican', 'Nationality of Recipe'),
(2, 'Italian', 'Nationality of Recipe'),
(3, 'Chinese', 'Nationality of Recipe'),
(4, 'American', 'Nationality of Recipe'),
(5, 'Greek', 'Nationality of Recipe'),
(6, 'Japanese', 'Nationality of Recipe'),
(7, 'Irish', 'Nationality of Recipe'),
(8, 'Vegan', 'Preference Label'),
(9, 'Vegetarian', 'Preference Label'),
(10, 'Savory', 'Preference Label'),
(19, 'Indian', 'Recipes from India'),
(21, 'BBQ', 'food that is great for barbecuing'),
(23, 'Beer', 'food to make with beer'),
(25, 'Sweet', 'All the best stuff'),
(26, 'Spicy', 'For recipes with a kick');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `DisplayName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `HashedPassword` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `AvatarURL` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Email`, `DisplayName`, `HashedPassword`, `AvatarURL`) VALUES
(1, 'silentbob@yahoo.com', 'silentbob', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', ''),
(2, 'frodoandsam@dontaskdonttell.com', 'frodo', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', NULL),
(3, 'pennyisafreeloader@bang.net', 'sheldon', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', NULL),
(4, 'einstein@patentoffice.gov', 'patentthief', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', NULL),
(5, 'tyrion@gameofthrones.com', 'imp', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', NULL),
(14, 'jacob.v.gardner@gmail.com', 'Jacob Gardner', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'Jacob Gardner'),
(15, 'cmptrgy412@gmail.com', 'Jacob', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'Jacob'),
(16, 'jtf3m8@mst.edu', 'Jacob Fischer', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'Jacob Fischer'),
(17, 'abc@cde', 'JAKE JAKE JAKE', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(18, 'guest', 'guest', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(19, 'sawwx7@mst.edu', 'Nerzugal', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'Nerzugal'),
(20, 'cjw5xd@mail.mst.edu', 'codyw', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'codyw'),
(21, 'dcost@fake.com', 'dcost', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(22, 'mnm@gmail.com', 'mikew', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(23, 'bzybnd@mst.edu', 'brianY', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(24, 'srhhg6@mail.mst.edu', 'iLoveSloots', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'iLoveSloots'),
(25, 'pacp@m.com', 'paco', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'paco'),
(26, 'jay@random.com', 'JayRandom', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(27, 'testEmail@test.com', 'TestGuest', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(28, 'newGuest', 'newGuest', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(29, 'jay@random2.com', 'JayRandom2', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(30, 'jay@random3.com', 'JayRandom3', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(31, 'jay@random4.com', 'JayRandom4', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(32, 'jay@random5.com', 'JayRandom5', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(33, 'jtf3m8@gfwd.mst.edu', 'Tux the penguin', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(34, 'billygoat@mailinator.com', 'Billy', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0'),
(35, 'jacob.t.fischer@gmail.com', 'joeminer', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', 'joeminer'),
(36, 'test@test.com', 'test', '$1$8MKW27um$oQRa7BS7L927rLRSTb8q61', '0');

-- --------------------------------------------------------

--
-- Table structure for table `UsersAllergies`
--

CREATE TABLE IF NOT EXISTS `UsersAllergies` (
  `UsersID` int(11) NOT NULL,
  `AllergiesID` int(11) NOT NULL,
  PRIMARY KEY (`UsersID`,`AllergiesID`),
  KEY `AllergiesID` (`AllergiesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `UsersAllergies`
--

INSERT INTO `UsersAllergies` (`UsersID`, `AllergiesID`) VALUES
(4, 2),
(1, 3),
(5, 4),
(3, 5),
(2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Varients`
--

CREATE TABLE IF NOT EXISTS `Varients` (
  `FromRecipeID` int(11) NOT NULL,
  `ToRecipeID` int(11) NOT NULL,
  PRIMARY KEY (`FromRecipeID`,`ToRecipeID`),
  KEY `ToRecipeID` (`ToRecipeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Varients`
--

INSERT INTO `Varients` (`FromRecipeID`, `ToRecipeID`) VALUES
(1, 2),
(5, 7),
(14, 30);

-- --------------------------------------------------------

--
-- Table structure for table `Votes`
--

CREATE TABLE IF NOT EXISTS `Votes` (
  `UsersID` int(11) NOT NULL,
  `RecipesID` int(11) NOT NULL,
  `Direction` tinyint(1) NOT NULL,
  PRIMARY KEY (`UsersID`,`RecipesID`),
  KEY `RecipesID` (`RecipesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Votes`
--

INSERT INTO `Votes` (`UsersID`, `RecipesID`, `Direction`) VALUES
(1, 1, 1),
(1, 2, -1),
(1, 4, 1),
(1, 17, 1),
(1, 19, 1),
(2, 1, 1),
(2, 2, -1),
(2, 4, 1),
(2, 31, 1),
(3, 1, 1),
(3, 2, 1),
(3, 7, 1),
(3, 9, 1),
(3, 10, 1),
(3, 11, 1),
(3, 12, 1),
(3, 30, 1),
(4, 1, -1),
(4, 2, 1),
(4, 3, 1),
(4, 5, 1),
(4, 14, 1),
(4, 32, 1),
(5, 1, 1),
(5, 2, 1),
(14, 1, -1),
(14, 2, -1),
(14, 3, -1),
(14, 7, -1),
(14, 19, -1),
(15, 7, 1),
(15, 29, 1),
(16, 1, 1),
(16, 2, -1),
(16, 3, 1),
(16, 5, -1),
(16, 7, 1),
(16, 9, -1),
(16, 10, 1),
(16, 12, -1),
(16, 19, 1),
(16, 28, 1),
(16, 29, -1),
(16, 31, -1),
(16, 33, 1),
(16, 57, 1),
(18, 1, -1),
(18, 2, -1),
(18, 3, 1),
(18, 7, -1),
(18, 12, 1),
(18, 17, 1),
(18, 19, -1),
(18, 29, -1),
(18, 33, -1),
(19, 2, -1),
(19, 3, 1),
(19, 13, 1),
(19, 19, 1),
(19, 34, 1),
(19, 48, 1),
(19, 50, 1),
(20, 1, 1),
(20, 2, -1),
(20, 3, 1),
(20, 4, -1),
(20, 5, 1),
(20, 7, 1),
(20, 9, 1),
(20, 10, -1),
(20, 11, -1),
(20, 19, 1),
(20, 28, 1),
(20, 29, -1),
(20, 30, 1),
(20, 31, 1),
(20, 33, 1),
(20, 34, 1),
(20, 53, -1),
(20, 55, 1),
(21, 10, -1),
(21, 11, 1),
(21, 12, 1),
(21, 13, 1),
(21, 17, 1),
(21, 19, 1),
(21, 29, 1),
(21, 32, 1),
(21, 35, -1),
(21, 41, 1),
(21, 42, 1),
(21, 43, 1),
(21, 44, 1),
(21, 45, 1),
(21, 46, 1),
(21, 47, 1),
(21, 48, 1),
(21, 49, 1),
(21, 50, 1),
(21, 51, 1),
(21, 52, 1),
(21, 53, 1),
(22, 1, 1),
(22, 2, 1),
(22, 4, 1),
(22, 7, 1),
(22, 9, 1),
(22, 10, 1),
(22, 12, 1),
(22, 14, 1),
(22, 19, -1),
(22, 28, -1),
(22, 29, -1),
(22, 31, 1),
(22, 33, 1),
(22, 34, 1),
(23, 1, 1),
(23, 3, 1),
(23, 7, 1),
(23, 49, 1),
(23, 50, -1),
(23, 54, -1),
(24, 7, 1),
(24, 19, 1),
(24, 35, -1),
(25, 3, -1),
(25, 7, -1),
(25, 12, 1),
(25, 13, -1),
(25, 19, 1),
(25, 20, -1),
(25, 35, 1),
(25, 42, 1),
(25, 54, -1),
(34, 1, 1),
(34, 4, 1),
(34, 7, -1),
(34, 12, 1),
(35, 1, -1),
(35, 12, 1),
(35, 58, -1),
(36, 12, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`UsersID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`ParentCommentsID`) REFERENCES `Comments` (`ID`);

--
-- Constraints for table `Favorites`
--
ALTER TABLE `Favorites`
  ADD CONSTRAINT `Favorites_ibfk_1` FOREIGN KEY (`UsersID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `Favorites_ibfk_2` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`);

--
-- Constraints for table `Followings`
--
ALTER TABLE `Followings`
  ADD CONSTRAINT `Followings_ibfk_1` FOREIGN KEY (`StalkingUsersID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `Followings_ibfk_2` FOREIGN KEY (`StalkerUsersID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `Recipes`
--
ALTER TABLE `Recipes`
  ADD CONSTRAINT `Recipes_ibfk_1` FOREIGN KEY (`SubmitterUsersID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `RecipesAllergies`
--
ALTER TABLE `RecipesAllergies`
  ADD CONSTRAINT `RecipesAllergies_ibfk_1` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`),
  ADD CONSTRAINT `RecipesAllergies_ibfk_2` FOREIGN KEY (`AllergiesID`) REFERENCES `Allergies` (`ID`);

--
-- Constraints for table `RecipesCookware`
--
ALTER TABLE `RecipesCookware`
  ADD CONSTRAINT `RecipesCookware_ibfk_1` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`),
  ADD CONSTRAINT `RecipesCookware_ibfk_2` FOREIGN KEY (`CookwareID`) REFERENCES `Cookware` (`ID`);

--
-- Constraints for table `RecipesIngredients`
--
ALTER TABLE `RecipesIngredients`
  ADD CONSTRAINT `RecipesIngredients_ibfk_1` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`),
  ADD CONSTRAINT `RecipesIngredients_ibfk_2` FOREIGN KEY (`IngredientsID`) REFERENCES `Ingredients` (`ID`);

--
-- Constraints for table `RecipesTags`
--
ALTER TABLE `RecipesTags`
  ADD CONSTRAINT `RecipesTags_ibfk_1` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`),
  ADD CONSTRAINT `RecipesTags_ibfk_2` FOREIGN KEY (`TagsID`) REFERENCES `Tags` (`ID`);

--
-- Constraints for table `UsersAllergies`
--
ALTER TABLE `UsersAllergies`
  ADD CONSTRAINT `UsersAllergies_ibfk_1` FOREIGN KEY (`UsersID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `UsersAllergies_ibfk_2` FOREIGN KEY (`AllergiesID`) REFERENCES `Allergies` (`ID`);

--
-- Constraints for table `Varients`
--
ALTER TABLE `Varients`
  ADD CONSTRAINT `Varients_ibfk_3` FOREIGN KEY (`FromRecipeID`) REFERENCES `Recipes` (`ID`),
  ADD CONSTRAINT `Varients_ibfk_4` FOREIGN KEY (`ToRecipeID`) REFERENCES `Recipes` (`ID`);

--
-- Constraints for table `Votes`
--
ALTER TABLE `Votes`
  ADD CONSTRAINT `Votes_ibfk_1` FOREIGN KEY (`UsersID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `Votes_ibfk_2` FOREIGN KEY (`RecipesID`) REFERENCES `Recipes` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
