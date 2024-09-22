-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 22, 2024 at 03:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matrimonial`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `Admin_id` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`Admin_id`, `Username`, `Password`) VALUES
(1, 'admin1', 'password1'),
(2, 'admin2', 'password2');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` varchar(10) NOT NULL,
  `outgoing_msg_id` varchar(10) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `read_status` enum('read','unread') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `read_status`) VALUES
(28, 'uD8oO1A0LX', 'YiObjCPuES', 'qdm1X7Yaq7EfEg3ha/4SBQ==', 'read'),
(29, 'YiObjCPuES', 'uD8oO1A0LX', 'qdm1X7Yaq7EfEg3ha/4SBQ==', 'read'),
(30, 'YiObjCPuES', 'uD8oO1A0LX', 'XJDCrGDvHiybA4MgdzNlqQ==', 'read'),
(31, 'S15SHs9YQ9', 'YiObjCPuES', 'qdm1X7Yaq7EfEg3ha/4SBQ==', 'read'),
(32, 'S15SHs9YQ9', 'YiObjCPuES', 'X4VL4lhG3KN6eCgXYD7LtA==', 'read'),
(33, 'YiObjCPuES', 'uD8oO1A0LX', 'HF47v3FVRtB9ONVRrZNEmg==', 'read'),
(34, 'YiObjCPuES', 'uD8oO1A0LX', 'JYFOZ+FVyrR4G+BjPsqiuQ==', 'read'),
(35, 'S15SHs9YQ9', 'YiObjCPuES', 'XqWn7HtfyUfMtGVKdPN8BA==', 'read'),
(36, 'S15SHs9YQ9', 'YiObjCPuES', 'HFLXf4/pdiQIvzysccjSHA==', 'read'),
(37, 'S15SHs9YQ9', 'uD8oO1A0LX', 'FXHLJbU9g8TVfRYWkXN9DX4+ehi+1Eeuj5nimsx+Tps=', 'read'),
(38, 'Jbyv3pmnlq', '3RpVFwSEsW', '2c8ipkwnad9ygKvAjHc1Bw==', 'read'),
(39, '3RpVFwSEsW', 'Jbyv3pmnlq', '6ZDo9lpE31uCXzdILQ85Bw==', 'read'),
(40, 'Jbyv3pmnlq', '3RpVFwSEsW', 'uus33/cL7JpZBRy814U0gA==', 'read'),
(41, '3RpVFwSEsW', 'Jbyv3pmnlq', 'Pg6kiU0dGVcARQKHu78ZBQ==', 'read'),
(42, 'Jbyv3pmnlq', '3RpVFwSEsW', 'XXhRXWGfYSnMjQoDqHL4VA==', 'read'),
(43, '3RpVFwSEsW', 'Jbyv3pmnlq', 'a0+ccgcNhuIXcgAc5cdg+h0zfVgfoKvqPz3LjBgiGOw=', 'read'),
(44, '3RpVFwSEsW', 'Jbyv3pmnlq', 'm5yhWKjn9M3rN0Oo9Aq/4A==', 'read'),
(45, 'Jbyv3pmnlq', '1KzMmwV2Sq', '8zgj8w1aGbiqLNrHL6oIuA==', 'read'),
(46, '1KzMmwV2Sq', 'Jbyv3pmnlq', 'QsAtknGxHELk8MJDRVIdGg==', 'read'),
(47, '3RpVFwSEsW', '1KzMmwV2Sq', 'SF8NR7sprsx/N0JIVtCKmw==', 'unread'),
(48, '1KzMmwV2Sq', 'Jbyv3pmnlq', 'SF8NR7sprsx/N0JIVtCKmw==', 'read'),
(49, 'ZKoKExqpT3', 'c45gv6C1n7', 'ce8++cRWHrB0U63P9Yd8LQ==', 'read'),
(50, 'c45gv6C1n7', 'ZKoKExqpT3', 'qGCxq6MR1eYZ/uMOfAJ6Og==', 'read'),
(51, 'c45gv6C1n7', 'ZKoKExqpT3', 'zo3QqQSBtrM1xE8pJakgxg==', 'read'),
(52, 'ZKoKExqpT3', 'c45gv6C1n7', 'C38txexOH4+XBY0cedx4Ww==', 'read'),
(53, 'ZKoKExqpT3', 'S15SHs9YQ9', '9/wv8GHEm4iS+KhYdmQp5g==', 'read'),
(54, 'ZKoKExqpT3', 'S15SHs9YQ9', 'lrx68AsyfAHUR7iNIIQP5w==', 'read'),
(55, 'S15SHs9YQ9', 'ZKoKExqpT3', 'G36MWa1F3pNO19Pt4Ta0hg==', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

CREATE TABLE `chat_users` (
  `user_id` varchar(10) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`) VALUES
('1KzMmwV2Sq', '1KzMmwV2Sq', 'Tom', 'Cruise', 'tom@gmail.com', '$2y$10$fRdT1rO.urrgzls0wHN6N.0mp7pm/RTtuu8MQU6EUYEBiZv1Neljy', '', ''),
('3RpVFwSEsW', '3RpVFwSEsW', 'Reshad', 'Karim', 'reshadulkarim@gmail.com', '$2y$10$hXBSNXEfN.ExqR6zi6e.cuZjWZEsjh5dRc9IAI/3F26ZCpZ1ihQZK', '', ''),
('c45gv6C1n7', 'c45gv6C1n7', 'Kiara', 'Advani', 'kiara@gmail.com', '$2y$10$XEiS5JPp/GHhUCAm7X6BW.3QLQBvlFSszcHc3oE3ZGDmYKvimeDve', '', ''),
('Jbyv3pmnlq', 'Jbyv3pmnlq', 'Syeda Maliha', 'Tabassum', 'malihatabassum@gmail.com', '$2y$10$YfbnwSVLWRjum9otzGTpfeMaNB9dSGF/W8PNEHccsdSr8KCqdtd5.', '', ''),
('S15SHs9YQ9', 'S15SHs9YQ9', 'x', 'y', 'xy@gmail.com', '$2y$10$1s3agjRJvNQ2CluCpNtjgOQ1EHIsItGmKmR9/RC.xARsdnh4NpTiC', '', ''),
('uD8oO1A0LX', 'uD8oO1A0LX', 'u', 'v', 'uv@gmail.com', '$2y$10$8KPU1/oa9p4vm0aMyPHOn.Hot1irmH/RlcNn7Z0vYs9W2kDyg9m6C', '', ''),
('YiObjCPuES', 'YiObjCPuES', 'i', 'j', 'ij@gmail.com', '$2y$10$EvLKDtG2gJARg0E40SAvL.rtx0NSLPNN7FKDSW3rUFgPmNJEopW/a', '', ''),
('ZKoKExqpT3', 'ZKoKExqpT3', 'Siddharth', 'malhotra', 'sid@gmail.com', '$2y$10$yoqQbCO.e4crkIMJiXY20OSAsss5LZFCkIJEO12bjWEY1e6tek9MC', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Preferences`
--

CREATE TABLE `Preferences` (
  `user_id` varchar(10) NOT NULL,
  `preferred_religion` enum('Christian','Muslim','Hindu','Buddhist','Jewish','Atheist','Other') DEFAULT NULL,
  `preferred_height` int(11) DEFAULT NULL,
  `preferred_ethnicity` varchar(50) DEFAULT NULL,
  `preferred_pets` enum('Dogs','Cats','Birds','No Pets','Other') DEFAULT NULL,
  `preferred_gender` enum('Male','Female','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Preferences`
--

INSERT INTO `Preferences` (`user_id`, `preferred_religion`, `preferred_height`, `preferred_ethnicity`, `preferred_pets`, `preferred_gender`) VALUES
('1KzMmwV2Sq', NULL, NULL, NULL, NULL, NULL),
('3RpVFwSEsW', NULL, NULL, NULL, NULL, NULL),
('c45gv6C1n7', NULL, NULL, NULL, NULL, NULL),
('Jbyv3pmnlq', NULL, NULL, NULL, NULL, NULL),
('S15SHs9YQ9', NULL, NULL, NULL, NULL, NULL),
('U010', 'Muslim', 5, 'Middle Eastern', 'Other', 'Male'),
('U011', 'Buddhist', 6, 'Asian', 'Dogs', 'Female'),
('U012', 'Christian', 6, 'Caucasian', 'No Pets', 'Male'),
('U013', 'Muslim', 6, 'Hispanic', 'Cats', 'Female'),
('U014', 'Hindu', 5, 'Asian', 'Birds', 'Male'),
('U015', 'Buddhist', 6, 'Caucasian', 'Other', 'Female'),
('U016', 'Christian', 6, 'African', 'Dogs', 'Male'),
('U017', 'Muslim', 6, 'Middle Eastern', 'Cats', 'Female'),
('U018', 'Hindu', 6, 'Asian', 'Birds', 'Male'),
('U019', 'Christian', 6, 'Caucasian', 'No Pets', 'Female'),
('U020', 'Buddhist', 6, 'Hispanic', 'Other', 'Male'),
('U021', 'Christian', 6, 'Caucasian', 'Dogs', 'Female'),
('U022', 'Muslim', 6, 'African', 'Cats', 'Male'),
('U023', 'Hindu', 6, 'Asian', 'No Pets', 'Female'),
('U024', 'Buddhist', 6, 'Middle Eastern', 'Birds', 'Male'),
('U025', 'Christian', 6, 'Caucasian', 'Dogs', 'Female'),
('U026', 'Muslim', 5, 'Asian', 'No Pets', 'Male'),
('U027', 'Hindu', 6, 'African', 'Cats', 'Female'),
('U028', 'Buddhist', 6, 'Hispanic', 'Dogs', 'Male'),
('U029', 'Christian', 6, 'Middle Eastern', 'Birds', 'Female'),
('U030', 'Muslim', 6, 'Asian', 'Other', 'Male'),
('U031', 'Christian', 6, 'Caucasian', 'Cats', 'Female'),
('U032', 'Muslim', 6, 'Asian', 'Birds', 'Male'),
('U033', 'Hindu', 6, 'African', 'No Pets', 'Female'),
('U034', 'Buddhist', 5, 'Hispanic', 'Dogs', 'Male'),
('U035', 'Christian', 6, 'Middle Eastern', 'Cats', 'Female'),
('U036', 'Muslim', 6, 'Asian', 'Birds', 'Male'),
('U037', 'Hindu', 6, 'Caucasian', 'No Pets', 'Female'),
('U038', 'Buddhist', 6, 'Hispanic', 'Dogs', 'Male'),
('U039', 'Christian', 6, 'Middle Eastern', 'Birds', 'Female'),
('U040', 'Muslim', 6, 'African', 'No Pets', 'Male'),
('uD8oO1A0LX', NULL, NULL, NULL, NULL, NULL),
('V8BnvcxHwo', NULL, NULL, NULL, NULL, NULL),
('VDqezg1eFt', NULL, NULL, NULL, NULL, NULL),
('YiObjCPuES', NULL, NULL, NULL, NULL, NULL),
('ZKoKExqpT3', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Details`
--

CREATE TABLE `Profile_Details` (
  `user_id` varchar(10) NOT NULL,
  `Secondary_Education` varchar(255) NOT NULL,
  `Higher_Secondary` varchar(255) NOT NULL,
  `Undergrade` varchar(255) DEFAULT NULL,
  `Post_Grade` varchar(255) DEFAULT NULL,
  `road_number` varchar(50) NOT NULL,
  `street_number` varchar(50) NOT NULL,
  `building_number` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `Marital_Status` enum('Single','Married','Divorced','Widowed') NOT NULL,
  `Interest` text DEFAULT NULL,
  `Hobbies` text DEFAULT NULL,
  `Height` decimal(5,2) DEFAULT NULL,
  `Weight` decimal(5,2) NOT NULL,
  `Complexion` enum('Fair','Medium','Dark','Olive','Tan') NOT NULL,
  `Biography` text NOT NULL,
  `Family_Background` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Profile_Details`
--

INSERT INTO `Profile_Details` (`user_id`, `Secondary_Education`, `Higher_Secondary`, `Undergrade`, `Post_Grade`, `road_number`, `street_number`, `building_number`, `phone_number`, `Marital_Status`, `Interest`, `Hobbies`, `Height`, `Weight`, `Complexion`, `Biography`, `Family_Background`) VALUES
('1KzMmwV2Sq', '', '', NULL, NULL, '', '', '', '', 'Single', '', '', 0.00, 0.00, 'Medium', '', ''),
('3RpVFwSEsW', '', '', NULL, NULL, '', '', '', '', 'Single', '', '', 0.00, 0.00, 'Medium', '', ''),
('c45gv6C1n7', '', '', NULL, NULL, '', '', '', '', 'Single', NULL, NULL, 0.00, 0.00, 'Medium', '', NULL),
('Jbyv3pmnlq', '', '', NULL, NULL, '', '', '', '', 'Single', '', '', 150.00, 0.00, 'Medium', 'Im the best', ''),
('S15SHs9YQ9', '', '', 'BA', 'MA', '', '', '', '', 'Single', '', '', 0.00, 0.00, 'Medium', '', ''),
('U010', 'SSC', 'HSC', 'BBA', 'MBA', '110', '211', '10J', '012-345-6789', 'Widowed', 'Psychology', 'Yoga', 160.02, 48.50, 'Fair', 'Psychologist from OR.', 'Middle-class family'),
('U011', 'SSC', 'HSC', 'BSC', 'MSC', '111', '212', '11A', '345-123-7890', 'Single', 'IT Support', 'Music', 172.72, 68.50, 'Fair', 'IT Support Specialist from WA.', 'Middle-class family'),
('U012', 'SSC', 'HSC', 'BSC', 'MSC', '112', '213', '12B', '456-234-8901', 'Married', 'Healthcare', 'Dancing', 162.56, 60.70, 'Medium', 'Physical Therapist from NY.', 'Upper-class family'),
('U013', 'SSC', 'HSC', 'BBA', 'MBA', '113', '214', '13C', '567-345-9012', 'Single', 'Healthcare', 'Traveling', 179.83, 75.20, 'Olive', 'Dentist from CA.', 'Middle-class family'),
('U014', 'SSC', 'HSC', 'BSC', NULL, '114', '215', '14D', '678-456-0123', 'Divorced', 'Fashion', 'Painting', 167.64, 55.60, 'Tan', 'Fashion Designer from TX.', 'Upper-class family'),
('U015', 'SSC', 'HSC', 'BSC', 'MSC', '115', '216', '15E', '789-567-1234', 'Single', 'Gaming', 'Coding', 187.96, 78.00, 'Fair', 'Game Developer from AZ.', 'Middle-class family'),
('U016', 'SSC', 'HSC', 'BA', 'MA', '116', '217', '16F', '890-678-2345', 'Married', 'Writing', 'Reading', 173.74, 58.00, 'Dark', 'Freelance Writer from IL.', 'Lower-class family'),
('U017', 'SSC', 'HSC', 'BSC', 'MSC', '117', '218', '17G', '901-789-3456', 'Single', 'Culinary Arts', 'Cooking', 179.83, 72.50, 'Olive', 'Chef from NV.', 'Middle-class family'),
('U018', 'SSC', 'HSC', 'BSC', 'MSC', '118', '219', '18H', '012-890-4567', 'Divorced', 'Design', 'Sketching', 167.64, 54.30, 'Tan', 'Graphic Designer from TX.', 'Upper-class family'),
('U019', 'SSC', 'HSC', 'BSC', 'MSC', '119', '220', '19I', '123-901-5678', 'Married', 'Healthcare', 'Swimming', 182.88, 85.40, 'Medium', 'Doctor from WA.', 'Upper-class family'),
('U020', 'SSC', 'HSC', 'BBA', 'MBA', '120', '221', '20J', '234-012-6789', 'Widowed', 'Psychology', 'Yoga', 165.10, 52.00, 'Fair', 'Psychologist from OR.', 'Middle-class family'),
('U021', 'SSC', 'HSC', 'BSC', 'MSC', '121', '222', '21A', '345-678-7890', 'Single', 'Data Science', 'Cycling', 182.88, 70.40, 'Fair', 'Data Scientist from NY.', 'Middle-class family'),
('U022', 'SSC', 'HSC', 'BSC', 'MSC', '122', '223', '22B', '456-789-8901', 'Married', 'Healthcare', 'Yoga', 167.64, 55.60, 'Dark', 'Nurse from TX.', 'Upper-class family'),
('U023', 'SSC', 'HSC', 'BSC', 'MSC', '123', '224', '23C', '567-890-9012', 'Single', 'Technology', 'Gaming', 182.88, 80.30, 'Olive', 'Software Engineer from CA.', 'Upper-class family'),
('U024', 'SSC', 'HSC', 'BSC', 'MSC', '124', '225', '24D', '678-901-0123', 'Married', 'Healthcare', 'Traveling', 167.64, 62.50, 'Tan', 'Doctor from IL.', 'Middle-class family'),
('U025', 'SSC', 'HSC', 'BSC', 'MSC', '125', '226', '25E', '789-012-1234', 'Single', 'Cybersecurity', 'Programming', 188.00, 75.20, 'Fair', 'Cybersecurity Analyst from FL.', 'Upper-class family'),
('U026', 'SSC', 'HSC', 'BSC', 'MSC', '126', '227', '26F', '890-123-2345', 'Married', 'Healthcare', 'Hiking', 162.56, 60.70, 'Medium', 'Physical Therapist from NY.', 'Middle-class family'),
('U027', 'SSC', 'HSC', 'BSC', 'MSC', '127', '228', '27G', '901-234-3456', 'Single', 'Civil Engineering', 'Photography', 190.50, 78.50, 'Olive', 'Civil Engineer from AZ.', 'Upper-class family'),
('U028', 'SSC', 'HSC', 'BBA', 'MBA', '128', '229', '28H', '012-345-4567', 'Divorced', 'Healthcare', 'Cooking', 170.18, 58.00, 'Tan', 'Dentist from WA.', 'Middle-class family'),
('U029', 'SSC', 'HSC', 'BSC', 'MSC', '129', '230', '29I', '123-456-5678', 'Married', 'Technology', 'Blogging', 182.88, 68.40, 'Medium', 'Web Developer from TX.', 'Middle-class family'),
('U030', 'SSC', 'HSC', 'BSC', 'MSC', '130', '231', '30J', '234-567-6789', 'Single', 'Architecture', 'Drawing', 173.74, 65.40, 'Olive', 'Architect from CA.', 'Upper-class family'),
('U031', 'SSC', 'HSC', 'BSC', 'MSC', '131', '232', '31A', '456-789-0123', 'Single', 'AI Research', 'Programming', 185.42, 72.40, 'Fair', 'AI Engineer from NY.', 'Middle-class family'),
('U032', 'SSC', 'HSC', 'BSC', 'MSC', '132', '233', '32B', '567-890-1234', 'Married', 'Veterinary Care', 'Traveling', 167.64, 60.20, 'Dark', 'Veterinarian from TX.', 'Upper-class family'),
('U033', 'SSC', 'HSC', 'BSC', 'MSC', '133', '234', '33C', '678-901-2345', 'Single', 'Cloud Computing', 'Cycling', 182.88, 74.30, 'Olive', 'Cloud Engineer from CA.', 'Middle-class family'),
('U034', 'SSC', 'HSC', 'BBA', 'MBA', '134', '235', '34D', '789-012-3456', 'Divorced', 'Law', 'Reading', 162.56, 58.50, 'Tan', 'Lawyer from IL.', 'Upper-class family'),
('U035', 'SSC', 'HSC', 'BSC', 'MSC', '135', '236', '35E', '890-123-4567', 'Single', 'Business Development', 'Photography', 188.00, 77.00, 'Fair', 'Entrepreneur from FL.', 'Upper-class family'),
('U036', 'SSC', 'HSC', 'BSC', 'MSC', '136', '237', '36F', '901-234-5678', 'Married', 'Fashion', 'Sewing', 167.64, 55.40, 'Medium', 'Fashion Designer from NY.', 'Middle-class family'),
('U037', 'SSC', 'HSC', 'BSC', 'MSC', '137', '238', '37G', '012-345-6789', 'Single', 'Economics', 'Debating', 190.50, 76.20, 'Olive', 'Economist from CA.', 'Middle-class family'),
('U038', 'SSC', 'HSC', 'BBA', 'MBA', '138', '239', '38H', '123-456-7890', 'Married', 'Healthcare', 'Cooking', 170.18, 58.10, 'Tan', 'Doctor from TX.', 'Upper-class family'),
('U039', 'SSC', 'HSC', 'BSC', 'MSC', '139', '240', '39I', '234-567-8901', 'Single', 'Blockchain', 'Programming', 182.88, 71.40, 'Fair', 'Blockchain Developer from AZ.', 'Middle-class family'),
('U040', 'SSC', 'HSC', 'BBA', 'MBA', '140', '241', '40J', '345-678-9012', 'Widowed', 'Real Estate', 'Hiking', 165.10, 56.30, 'Dark', 'Real Estate Agent from WA.', 'Lower-class family'),
('uD8oO1A0LX', '', '', NULL, NULL, '', '', '', '', 'Single', NULL, NULL, 0.00, 0.00, 'Medium', '', NULL),
('V8BnvcxHwo', '', '', NULL, NULL, '', '', '', '', 'Single', NULL, NULL, 0.00, 0.00, 'Medium', '', NULL),
('VDqezg1eFt', '', '', NULL, NULL, '', '', '', '', 'Single', NULL, NULL, 0.00, 0.00, 'Medium', '', NULL),
('YiObjCPuES', '', '', NULL, NULL, '', '', '', '', 'Single', NULL, NULL, 0.00, 0.00, 'Medium', '', NULL),
('ZKoKExqpT3', 'SSC', 'HSC', 'BSC', 'MBA', '', '', '', '', 'Single', '', '', 0.00, 0.00, 'Medium', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Request`
--

CREATE TABLE `Request` (
  `request_id` int(11) NOT NULL,
  `sender_id` varchar(10) NOT NULL,
  `receiver_id` varchar(10) NOT NULL,
  `request_status` enum('Pending','Accepted','Declined','Cancelled') NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Request`
--

INSERT INTO `Request` (`request_id`, `sender_id`, `receiver_id`, `request_status`, `request_time`) VALUES
(5, 'ZKoKExqpT3', 'S15SHs9YQ9', 'Accepted', '2024-09-21 20:45:28'),
(10, 'ZKoKExqpT3', 'Jbyv3pmnlq', 'Accepted', '2024-09-21 20:31:19'),
(77, 'Jbyv3pmnlq', 'ZKoKExqpT3', 'Accepted', '2024-09-21 20:32:40'),
(701, 'ZKoKExqpT3', 'c45gv6C1n7', 'Accepted', '2024-09-21 20:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Profession` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `Religion` enum('Christian','Muslim','Hindu','Buddhist','Jewish','Atheist','Other') NOT NULL,
  `Ethnicity` varchar(50) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Registration_Date` date NOT NULL,
  `Account_Status` enum('Active','Inactive','Suspended') NOT NULL,
  `Profile_Photo_URL` varchar(255) DEFAULT NULL,
  `Photos_URL` varchar(255) DEFAULT NULL,
  `NID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `Email`, `Password`, `Profession`, `DOB`, `Gender`, `Religion`, `Ethnicity`, `First_Name`, `Middle_Name`, `Last_Name`, `Registration_Date`, `Account_Status`, `Profile_Photo_URL`, `Photos_URL`, `NID`) VALUES
('1KzMmwV2Sq', 'tom@gmail.com', '$2y$10$fRdT1rO.urrgzls0wHN6N.0mp7pm/RTtuu8MQU6EUYEBiZv1Neljy', 'art-director', '1975-02-22', 'Male', 'Christian', 'Caucasian', 'Tom', '', 'Cruise', '2024-09-22', 'Inactive', 'Tom Cruise.jpg', NULL, '159197515'),
('3RpVFwSEsW', 'reshadulkarim@gmail.com', '$2y$10$hXBSNXEfN.ExqR6zi6e.cuZjWZEsjh5dRc9IAI/3F26ZCpZ1ihQZK', 'software-engineer', '2001-09-27', 'Male', 'Muslim', 'Caucasian', 'Reshad', 'Ul', 'Karim', '2024-09-22', 'Active', 'ReshadS.jpg', NULL, '5546687'),
('c45gv6C1n7', 'kiara@gmail.com', '$2y$10$XEiS5JPp/GHhUCAm7X6BW.3QLQBvlFSszcHc3oE3ZGDmYKvimeDve', 'art-director', '1995-04-04', 'Female', 'Hindu', 'Asian', 'Kiara', '', 'Advani', '2024-09-22', 'Active', 'kiara.jpg', NULL, '7764564'),
('Jbyv3pmnlq', 'malihatabassum@gmail.com', '$2y$10$YfbnwSVLWRjum9otzGTpfeMaNB9dSGF/W8PNEHccsdSr8KCqdtd5.', 'ai-engineer', '2002-02-19', 'Female', 'Muslim', 'Caucasian', 'Syeda Maliha', '', 'Tabassum', '2024-09-22', 'Active', 'Maliha.jpg', NULL, '45894897'),
('S15SHs9YQ9', 'xy@gmail.com', '$2y$10$1s3agjRJvNQ2CluCpNtjgOQ1EHIsItGmKmR9/RC.xARsdnh4NpTiC', 'software-engineer', '1999-02-22', 'Female', 'Buddhist', 'Caucasian', 'x', '', 'y', '2024-09-21', 'Active', 'imgase.jpg', NULL, '22315912'),
('U010', 'sara.moore@example.com', 'hashed_password_stu', 'psychologist', '1993-01-19', 'Female', 'Muslim', 'Middle Eastern', 'Sara', NULL, 'Moore', '2024-10-20', 'Active', 'url_to_profile_photo_10', 'url_to_photos_10', 'NID010'),
('U011', 'kevin.lee@example.com', 'hashed_password_vwx', 'it-support-specialist', '1986-02-15', 'Male', 'Buddhist', 'Asian', 'Kevin', NULL, 'Lee', '2024-02-28', 'Active', 'url_to_profile_photo_11', 'url_to_photos_11', 'NID011'),
('U012', 'emily.davis@example.com', 'hashed_password_yza', 'physical-therapist', '1991-10-30', 'Female', 'Christian', 'Caucasian', 'Emily', NULL, 'Davis', '2024-03-15', 'Active', 'url_to_profile_photo_12', 'url_to_photos_12', 'NID012'),
('U013', 'david.sanchez@example.com', 'hashed_password_bcd', 'dentist', '1989-12-20', 'Male', 'Muslim', 'Hispanic', 'David', NULL, 'Sanchez', '2024-03-30', 'Active', 'url_to_profile_photo_13', 'url_to_photos_13', 'NID013'),
('U014', 'olivia.martinez@example.com', 'hashed_password_efg', 'fashion-designer', '1994-05-10', 'Female', 'Hindu', 'Asian', 'Olivia', NULL, 'Martinez', '2024-04-10', 'Inactive', 'url_to_profile_photo_14', 'url_to_photos_14', 'NID014'),
('U015', 'michael.white@example.com', 'hashed_password_hij', 'game-developer', '1988-09-25', 'Male', 'Buddhist', 'Caucasian', 'Michael', 'J', 'White', '2024-05-05', 'Active', 'url_to_profile_photo_15', 'url_to_photos_15', 'NID015'),
('U016', 'sophia.jones@example.com', 'hashed_password_klm', 'freelance-writer', '1992-03-08', 'Female', 'Christian', 'African', 'Sophia', NULL, 'Jones', '2024-06-18', 'Active', 'url_to_profile_photo_16', 'url_to_photos_16', 'NID016'),
('U017', 'daniel.harris@example.com', 'hashed_password_nop', 'chef', '1990-01-14', 'Male', 'Muslim', 'Middle Eastern', 'Daniel', NULL, 'Harris', '2024-07-12', 'Active', 'url_to_profile_photo_17', 'url_to_photos_17', 'NID017'),
('U018', 'emma.clark@example.com', 'hashed_password_qrs', 'graphic-designer', '1987-07-22', 'Female', 'Hindu', 'Asian', 'Emma', NULL, 'Clark', '2024-08-01', 'Inactive', 'url_to_profile_photo_18', 'url_to_photos_18', 'NID018'),
('U019', 'ryan.morris@example.com', 'hashed_password_tuv', 'doctor', '1993-04-17', 'Male', 'Christian', 'Caucasian', 'Ryan', NULL, 'Morris', '2024-09-15', 'Active', 'url_to_profile_photo_19', 'url_to_photos_19', 'NID019'),
('U020', 'ava.jackson@example.com', 'hashed_password_wxy', 'psychologist', '1985-06-21', 'Female', 'Buddhist', 'Hispanic', 'Ava', NULL, 'Jackson', '2024-10-07', 'Suspended', 'url_to_profile_photo_20', 'url_to_photos_20', 'NID020'),
('U021', 'noah.walker@example.com', 'hashed_password_aaa', 'data-scientist', '1987-04-10', 'Male', 'Christian', 'Caucasian', 'Noah', NULL, 'Walker', '2024-02-02', 'Active', 'url_to_profile_photo_21', 'url_to_photos_21', 'NID021'),
('U022', 'mia.robinson@example.com', 'hashed_password_bbb', 'nurse', '1995-09-09', 'Female', 'Muslim', 'African', 'Mia', NULL, 'Robinson', '2024-03-10', 'Active', 'url_to_profile_photo_22', 'url_to_photos_22', 'NID022'),
('U023', 'william.young@example.com', 'hashed_password_ccc', 'software-engineer', '1989-11-01', 'Male', 'Hindu', 'Asian', 'William', 'T', 'Young', '2024-04-12', 'Inactive', 'man1.jpg', 'url_to_photos_23', 'NID023'),
('U024', 'chloe.king@example.com', 'hashed_password_ddd', 'doctor', '1991-07-22', 'Female', 'Buddhist', 'Middle Eastern', 'Chloe', NULL, 'King', '2024-05-18', 'Active', 'url_to_profile_photo_24', 'url_to_photos_24', 'NID024'),
('U025', 'james.lee@example.com', 'hashed_password_eee', 'cybersecurity-analyst', '1992-08-15', 'Male', 'Christian', 'Caucasian', 'James', NULL, 'Lee', '2024-06-25', 'Active', 'man2.jpg', 'url_to_photos_25', 'NID025'),
('U026', 'amelia.james@example.com', 'hashed_password_fff', 'physical-therapist', '1993-05-18', 'Female', 'Muslim', 'Asian', 'Amelia', NULL, 'James', '2024-07-30', 'Active', 'url_to_profile_photo_26', 'url_to_photos_26', 'NID026'),
('U027', 'liam.brown@example.com', 'hashed_password_ggg', 'civil-engineer', '1990-10-05', 'Male', 'Hindu', 'African', 'Liam', NULL, 'Brown', '2024-08-11', 'Active', 'man3.jpg', 'url_to_photos_27', 'NID027'),
('U028', 'ava.davis@example.com', 'hashed_password_hhh', 'dentist', '1991-12-13', 'Female', 'Buddhist', 'Hispanic', 'Ava', NULL, 'Davis', '2024-09-18', 'Inactive', 'url_to_profile_photo_28', 'url_to_photos_28', 'NID028'),
('U029', 'lucas.wilson@example.com', 'hashed_password_iii', 'web-developer', '1990-03-03', 'Male', 'Christian', 'Middle Eastern', 'Lucas', 'P', 'Wilson', '2024-10-01', 'Active', 'man4.jpg', 'url_to_photos_29', 'NID029'),
('U030', 'sophia.hall@example.com', 'hashed_password_jjj', 'architect', '1994-06-12', 'Female', 'Muslim', 'Asian', 'Sophia', NULL, 'Hall', '2024-11-02', 'Active', 'url_to_profile_photo_30', 'url_to_photos_30', 'NID030'),
('U031', 'ethan.harris@example.com', 'hashed_password_kkk', 'ai-engineer', '1990-01-14', 'Male', 'Christian', 'Caucasian', 'Ethan', NULL, 'Harris', '2024-01-15', 'Active', 'url_to_profile_photo_31', 'url_to_photos_31', 'NID031'),
('U032', 'isabella.clark@example.com', 'hashed_password_lll', 'veterinarian', '1992-02-22', 'Female', 'Muslim', 'Asian', 'Isabella', NULL, 'Clark', '2024-02-23', 'Inactive', 'url_to_profile_photo_32', 'url_to_photos_32', 'NID032'),
('U033', 'jackson.morris@example.com', 'hashed_password_mmm', 'cloud-engineer', '1991-04-11', 'Male', 'Hindu', 'African', 'Jackson', NULL, 'Morris', '2024-03-11', 'Active', 'man5.jpg', 'url_to_photos_33', 'NID033'),
('U034', 'olivia.carter@example.com', 'hashed_password_nnn', 'lawyer', '1988-09-18', 'Female', 'Buddhist', 'Hispanic', 'Olivia', NULL, 'Carter', '2024-04-20', 'Suspended', 'url_to_profile_photo_34', 'url_to_photos_34', 'NID034'),
('U035', 'henry.anderson@example.com', 'hashed_password_ooo', 'entrepreneur', '1994-05-24', 'Male', 'Christian', 'Middle Eastern', 'Henry', NULL, 'Anderson', '2024-05-25', 'Active', 'url_to_profile_photo_35', 'url_to_photos_35', 'NID035'),
('U036', 'ava.lopez@example.com', 'hashed_password_ppp', 'fashion-designer', '1990-06-12', 'Female', 'Muslim', 'Asian', 'Ava', NULL, 'Lopez', '2024-06-15', 'Active', 'url_to_profile_photo_36', 'url_to_photos_36', 'NID036'),
('U037', 'mason.wright@example.com', 'hashed_password_qqq', 'economist', '1993-03-16', 'Male', 'Hindu', 'Caucasian', 'Mason', NULL, 'Wright', '2024-07-10', 'Active', 'man8.jpg', 'url_to_photos_37', 'NID037'),
('U038', 'mia.young@example.com', 'hashed_password_rrr', 'doctor', '1989-12-19', 'Female', 'Buddhist', 'Hispanic', 'Mia', NULL, 'Young', '2024-08-02', 'Active', 'url_to_profile_photo_38', 'url_to_photos_38', 'NID038'),
('U039', 'benjamin.lee@example.com', 'hashed_password_sss', 'blockchain-developer', '1991-07-29', 'Male', 'Christian', 'Middle Eastern', 'Benjamin', NULL, 'Lee', '2024-09-05', 'Inactive', 'man6.jpg', 'url_to_photos_39', 'NID039'),
('U040', 'sophia.thompson@example.com', 'hashed_password_ttt', 'real-estate-agent', '1988-08-15', 'Female', 'Muslim', 'African', 'Sophia', NULL, 'Thompson', '2024-10-10', 'Active', 'url_to_profile_photo_40', 'url_to_photos_40', 'NID040'),
('uD8oO1A0LX', 'uv@gmail.com', '$2y$10$8KPU1/oa9p4vm0aMyPHOn.Hot1irmH/RlcNn7Z0vYs9W2kDyg9m6C', 'software-engineer', '2000-02-22', 'Female', 'Hindu', 'Caucasian', 'u', '', 'v', '2024-09-21', 'Active', 'pp copy.JPG', NULL, '199816126'),
('VDqezg1eFt', 'karim@gmail.com', '$2y$10$.y7G1HExwfJcnUm1K6GFFOMftAMARXThM2YSaKeOQAaVs5A/lT4Bi', 'software-engineer', '2000-02-22', 'Male', 'Muslim', 'Caucasian', 'Karim', '', 'Broi', '2024-09-21', 'Active', '310918736_2415154238632459_8164636422417715202_n.jpg', NULL, '15975364'),
('YiObjCPuES', 'ij@gmail.com', '$2y$10$EvLKDtG2gJARg0E40SAvL.rtx0NSLPNN7FKDSW3rUFgPmNJEopW/a', 'software-engineer', '2000-02-11', 'Male', 'Muslim', 'Caucasian', 'i', '', 'j', '2024-09-21', 'Active', 'imgase.jpg', NULL, '1231345566'),
('ZKoKExqpT3', 'sid@gmail.com', '$2y$10$yoqQbCO.e4crkIMJiXY20OSAsss5LZFCkIJEO12bjWEY1e6tek9MC', 'teacher', '1990-01-27', 'Male', 'Hindu', 'Asian', 'Siddharth', '', 'malhotra', '2024-09-22', 'Active', 'siddharth.jpg', NULL, '77552');

-- --------------------------------------------------------

--
-- Table structure for table `User_Activity_Log`
--

CREATE TABLE `User_Activity_Log` (
  `log_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Activity_Log`
--

INSERT INTO `User_Activity_Log` (`log_id`, `user_id`, `activity`, `timestamp`) VALUES
(2, 'V8BnvcxHwo', 'User registered', '2024-09-16 22:36:42'),
(7, 'VDqezg1eFt', 'User registered', '2024-09-20 21:55:07'),
(13, 'S15SHs9YQ9', 'User registered', '2024-09-21 14:06:39'),
(14, 'YiObjCPuES', 'User registered', '2024-09-21 14:07:36'),
(16, 'uD8oO1A0LX', 'User registered', '2024-09-21 14:10:58'),
(18, '3RpVFwSEsW', 'User registered', '2024-09-21 20:34:37'),
(19, 'Jbyv3pmnlq', 'User registered', '2024-09-21 20:35:53'),
(20, '1KzMmwV2Sq', 'User registered', '2024-09-21 21:54:52'),
(21, 'c45gv6C1n7', 'User registered', '2024-09-21 23:35:59'),
(22, 'ZKoKExqpT3', 'User registered', '2024-09-21 23:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `User_Admin`
--

CREATE TABLE `User_Admin` (
  `Admin_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`Admin_id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `fk_incoming_user` (`incoming_msg_id`),
  ADD KEY `fk_outgoing_user` (`outgoing_msg_id`);

--
-- Indexes for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Preferences`
--
ALTER TABLE `Preferences`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Profile_Details`
--
ALTER TABLE `Profile_Details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Request`
--
ALTER TABLE `Request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `idx_sender_id` (`sender_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `NID` (`NID`),
  ADD KEY `idx_email` (`Email`),
  ADD KEY `idx_profession` (`Profession`),
  ADD KEY `idx_religion` (`Religion`),
  ADD KEY `idx_user_registration_date` (`Registration_Date`);

--
-- Indexes for table `User_Activity_Log`
--
ALTER TABLE `User_Activity_Log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `User_Admin`
--
ALTER TABLE `User_Admin`
  ADD PRIMARY KEY (`Admin_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `Request`
--
ALTER TABLE `Request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=702;

--
-- AUTO_INCREMENT for table `User_Activity_Log`
--
ALTER TABLE `User_Activity_Log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`incoming_msg_id`) REFERENCES `chat_users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `chat_users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_incoming_user` FOREIGN KEY (`incoming_msg_id`) REFERENCES `chat_users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_outgoing_user` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `chat_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `chat_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Preferences`
--
ALTER TABLE `Preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile_Details`
--
ALTER TABLE `Profile_Details`
  ADD CONSTRAINT `profile_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Request`
--
ALTER TABLE `Request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `User_Activity_Log`
--
ALTER TABLE `User_Activity_Log`
  ADD CONSTRAINT `user_activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `User_Admin`
--
ALTER TABLE `User_Admin`
  ADD CONSTRAINT `user_admin_ibfk_1` FOREIGN KEY (`Admin_id`) REFERENCES `Admin` (`Admin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_admin_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
