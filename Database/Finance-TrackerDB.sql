-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2024 at 11:12 AM
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
-- Database: `finance_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_type` enum('Income','Expense','Savings') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `User_id`, `category_name`, `category_type`) VALUES
(1, 1, 'Freelancing', 'Income'),
(2, 1, 'Services', 'Income'),
(3, 1, 'Grocery', 'Expense'),
(4, 1, 'Bills', 'Expense'),
(5, 1, 'Dream House', 'Savings'),
(6, 1, 'Emergency Funds', 'Savings'),
(7, 1, 'QA', 'Income'),
(10, 1, 'Personal', 'Expense');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `expense_date` date NOT NULL,
  `expense_description` text DEFAULT NULL,
  `expense_amount` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `User_id`, `expense_date`, `expense_description`, `expense_amount`, `category_id`) VALUES
(1, 1, '2024-11-01', 'Grocery - Nov', 5500.00, 3),
(2, 1, '2024-11-01', 'Bills - Nov', 4000.00, 4),
(3, 1, '2024-11-02', 'Cat Food', 2000.00, 3),
(4, 1, '2024-11-02', 'Baking', 1200.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `income_date` date NOT NULL,
  `income_description` text DEFAULT NULL,
  `income_amount` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `User_id`, `income_date`, `income_description`, `income_amount`, `category_id`) VALUES
(1, 1, '2024-11-01', 'Freelancing - Nov', 32000.00, 1),
(2, 1, '2024-11-01', 'House Cleaning', 19500.00, 2),
(3, 1, '2024-11-02', 'PC Labor', 32000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `savings_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `savings_date` date NOT NULL,
  `savings_description` text DEFAULT NULL,
  `savings_amount` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`savings_id`, `User_id`, `savings_date`, `savings_description`, `savings_amount`, `category_id`) VALUES
(1, 1, '2024-11-01', 'Dream House', 3000.00, 5),
(2, 1, '2024-11-01', 'EF - NOV', 5000.00, 6);

-- --------------------------------------------------------

--
-- Table structure for table `savingsgoals`
--

CREATE TABLE `savingsgoals` (
  `goal_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `goal_amount` decimal(10,2) NOT NULL,
  `target_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `Username`, `Email`, `Password_Hash`) VALUES
(1, 't', 't@gmail.com', '$2y$10$yXLtNijJCCbpV9PxFxzi1uNc3NSvONue9ZEO9nbhK59P2CtTpxi/2'),
(2, 'tt', 'tt@gmail.com', '$2y$10$eTAIvKh1UajOS6nIERSreOipQ7KKS8KsMEIl5H/ruUXkR2lFLEIQS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `User_id` (`User_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`savings_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `savingsgoals`
--
ALTER TABLE `savingsgoals`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `savings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `savingsgoals`
--
ALTER TABLE `savingsgoals`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `income_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `savings_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `savingsgoals`
--
ALTER TABLE `savingsgoals`
  ADD CONSTRAINT `savingsgoals_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `savingsgoals_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
