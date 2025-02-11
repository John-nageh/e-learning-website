-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 10:31 AM
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
-- Database: `e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `c_name` varchar(100) NOT NULL COMMENT 'Course Name',
  `c_id` int(11) NOT NULL COMMENT 'Course ID, Primary key that auto-increments',
  `c_desc` text NOT NULL COMMENT 'Description for course',
  `c_price` varchar(10) NOT NULL COMMENT 'Price of a course',
  `c_no_of_lessons` int(11) NOT NULL COMMENT 'Number of lessons in a course',
  `c_image` varchar(100) NOT NULL COMMENT 'Path to course image',
  `i_id` int(11) NOT NULL DEFAULT 1 COMMENT 'Instructor ID, foreign key from instructor table',
  `c_level` varchar(15) NOT NULL DEFAULT 'Beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`c_name`, `c_id`, `c_desc`, `c_price`, `c_no_of_lessons`, `c_image`, `i_id`, `c_level`) VALUES
('Introduction to Python', 101, 'Learn the basics of Python programming, including syntax, variables, and loops.', '49.00', 10, 'images/python.png', 1, 'Beginner'),
('Web Development with HTML & CSS', 102, 'Build beautiful and responsive websites using HTML and CSS.', '59.99', 18, 'images/web.jpg', 2, 'beginner'),
('JavaScript Essentials', 103, 'Master the fundamentals of JavaScript to create dynamic web pages.', '69.99', 20, 'images/javaScript.png', 1, 'Beginner'),
('Machine Learning Basics', 104, 'An introductory course on machine learning concepts and algorithms.', '89.99', 12, 'images/machine.jpeg', 3, 'Beginner'),
('Data Science with Python', 105, 'Learn data analysis and visualization techniques using Python.', '99.0', 18, 'images/dataScience.png', 1, 'Beginner'),
('Cybersecurity Fundamentals', 106, 'Understand the principles of cybersecurity and learn to protect systems.', '79.99', 10, 'images/cyber.jpeg', 4, 'Beginner'),
('Cloud Computing with AWS', 107, 'Explore cloud computing services and solutions using AWS.', '119.99', 14, 'images/Cloud.jpeg', 3, 'Beginner'),
('Mobile App Development with Flutter', 108, 'Create cross-platform mobile apps using Flutter.', '85.99', 18, 'images/Mobile.jpg', 2, 'beginner'),
('SQL for Data Management', 109, 'Learn how to manage and query databases using SQL.', '39.99', 8, 'images/sql.jpeg', 3, 'Beginner'),
('Artificial Intelligence Foundations', 110, 'Delve into the world of AI and its real-world applications.', '109.99', 16, 'images/AI.jpeg', 4, 'Beginner'),
('web', 132, 'best course.', '75.99', 9, 'images/logo1.png', 2, 'Intermediate'),
('web', 134, 'best course.', '119', 16, 'images/course-3.jpg', 1, 'advanced'),
('web', 135, 'best course.', '119', 16, 'images/logo1.png', 1, 'advanced'),
('skills', 136, 'best course.', '25.99', 4, 'images/logo1.png', 2, 'beginner'),
('skills', 137, 'best course.', '29.99', 4, 'images/logo1.png', 2, 'intermediate'),
('Data Science', 138, 'best course.', '99.99', 45, 'images/course-3.jpg', 1, 'Beginner');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `i_name` varchar(50) NOT NULL COMMENT 'Instructor''s name',
  `i_id` int(11) NOT NULL COMMENT 'Instructor''s ID, Primary key, auto-incremented',
  `i_phone` varchar(13) NOT NULL COMMENT 'Instructor''s phone number',
  `i_email` varchar(40) NOT NULL COMMENT 'Instructor''s email address',
  `i_image` varchar(30) NOT NULL COMMENT 'Instructor''s Image Path',
  `i_bio` varchar(40) NOT NULL COMMENT 'Instructor''s Bio',
  `i_job_desc` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`i_name`, `i_id`, `i_phone`, `i_email`, `i_image`, `i_bio`, `i_job_desc`) VALUES
('John Doe', 1, '123-456-7890', 'john@inst.com', 'images/instructor1.jpg', 'Business', 'As a mobile software engineer with 5 years of experience in app development, my passion extends beyond just creating applications. I find immense joy in educating others about coding. Teaching is not just a job for me, but a heartfelt passion. You can expect engaging and passionate courses from me, as I love to share my knowledge with others. My expertise lies in demystifying complex programming concepts, making them accessible and understandable for everyone. Whether you think a concept is too challenging, I’m here to guide you through it with ease. I pride myself on having taught over 40,000 students globally, and this number is continuously growing. With my guidance and your dedication, we can make learning programming an enjoyable and rewarding journey. As a recognized Google Developer Expert in Flutter, I bring specialized knowledge and insights to the table, further enriching the learning experience for my students.'),
('Jane Smith', 2, '234-567-8901', 'jane@inst.com', 'images/instructor5.jpg', 'Web Development', 'As a mobile software engineer with 5 years of experience in app development, my passion extends beyond just creating applications. I find immense joy in educating others about coding. Teaching is not just a job for me, but a heartfelt passion. You can expect engaging and passionate courses from me, as I love to share my knowledge with others. My expertise lies in demystifying complex programming concepts, making them accessible and understandable for everyone. Whether you think a concept is too challenging, I’m here to guide you through it with ease. I pride myself on having taught over 40,000 students globally, and this number is continuously growing. With my guidance and your dedication, we can make learning programming an enjoyable and rewarding journey. As a recognized Google Developer Expert in Flutter, I bring specialized knowledge and insights to the table, further enriching the learning experience for my students.'),
('Robert Brown', 3, '345-678-9012', 'robert.brown@example.com', 'images/instructor2.jpg', 'Programming', 'As a mobile software engineer with 5 years of experience in app development, my passion extends beyond just creating applications. I find immense joy in educating others about coding. Teaching is not just a job for me, but a heartfelt passion. You can expect engaging and passionate courses from me, as I love to share my knowledge with others. My expertise lies in demystifying complex programming concepts, making them accessible and understandable for everyone. Whether you think a concept is too challenging, I’m here to guide you through it with ease. I pride myself on having taught over 40,000 students globally, and this number is continuously growing. With my guidance and your dedication, we can make learning programming an enjoyable and rewarding journey. As a recognized Google Developer Expert in Flutter, I bring specialized knowledge and insights to the table, further enriching the learning experience for my students.'),
('Emily White', 4, '456-789-0123', 'emily.white@example.com', 'images/instructor4.jpg', 'Design', 'As a mobile software engineer with 5 years of experience in app development, my passion extends beyond just creating applications. I find immense joy in educating others about coding. Teaching is not just a job for me, but a heartfelt passion. You can expect engaging and passionate courses from me, as I love to share my knowledge with others. My expertise lies in demystifying complex programming concepts, making them accessible and understandable for everyone. Whether you think a concept is too challenging, I’m here to guide you through it with ease. I pride myself on having taught over 40,000 students globally, and this number is continuously growing. With my guidance and your dedication, we can make learning programming an enjoyable and rewarding journey. As a recognized Google Developer Expert in Flutter, I bring specialized knowledge and insights to the table, further enriching the learning experience for my students.'),
('Michael Green', 5, '567-890-1234', 'michael.green@example.com', '0', '0', ''),
('Sarah Black', 6, '678-901-2345', 'sarah.black@example.com', '0', '0', ''),
('David Gray', 7, '789-012-3456', 'david.gray@example.com', '0', '0', ''),
('Linda Blue', 8, '890-123-4567', 'linda.blue@example.com', '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `old_cart`
--

CREATE TABLE `old_cart` (
  `p_id` int(11) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `old_cart`
--

INSERT INTO `old_cart` (`p_id`, `s_id`, `c_id`) VALUES
(5, 1, 106),
(5, 2, 106),
(5, 3, 106),
(5, 4, 106),
(5, 1, 107),
(5, 2, 107),
(5, 3, 107),
(5, 1, 108),
(5, 2, 108),
(5, 3, 108),
(5, 4, 108),
(35, 24, 101),
(36, 27, 101),
(37, 27, 102),
(38, 27, 108);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL,
  `p_date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `p_date_time`) VALUES
(1, '2024-12-01 09:30:00'),
(2, '2024-12-01 10:45:00'),
(3, '2024-12-01 12:00:00'),
(4, '2024-12-02 08:15:00'),
(5, '2024-12-02 14:30:00'),
(6, '2024-12-02 16:00:00'),
(7, '2024-12-03 11:00:00'),
(8, '2024-12-03 13:30:00'),
(9, '2024-12-04 09:45:00'),
(10, '2024-12-04 10:30:00'),
(17, '2024-12-15 13:31:16'),
(18, '2024-12-15 13:34:44'),
(19, '2024-12-15 13:39:04'),
(20, '2024-12-15 13:39:36'),
(21, '2024-12-15 13:46:16'),
(22, '2024-12-15 13:46:53'),
(23, '2024-12-15 13:56:50'),
(24, '2024-12-15 14:08:21'),
(25, '2024-12-15 14:08:23'),
(26, '2024-12-15 14:09:05'),
(27, '2024-12-15 14:10:52'),
(28, '2024-12-15 14:10:57'),
(29, '2024-12-15 14:11:48'),
(30, '2024-12-15 14:12:10'),
(31, '2024-12-16 13:14:06'),
(32, '2024-12-21 19:50:46'),
(33, '2024-12-22 11:31:37'),
(34, '2024-12-23 13:53:22'),
(35, '2024-12-23 20:12:54'),
(36, '2024-12-23 20:29:46'),
(37, '2024-12-23 22:43:04'),
(38, '2024-12-24 10:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `s_name` varchar(50) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `s_password` varchar(50) NOT NULL,
  `s_id` int(11) NOT NULL,
  `i_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`s_name`, `s_email`, `s_password`, `s_id`, `i_id`) VALUES
('Alice Johnson', 'alice.johnson@example.com', 'password123', 1, 0),
('Bob Smith', 'bob.smith@example.com', 'securepass456', 2, 0),
('Charlie Brown', 'charlie.brown@example.com', 'mypassword789', 3, 0),
('Diana Prince', 'diana.prince@example.com', 'wonderwoman123', 4, 0),
('Ethan Hunt', 'ethan.hunt@example.com', 'impossible456', 5, 0),
('Fiona Green', 'fiona.green@example.com', 'greenforest789', 6, 0),
('George Clarke', 'george.clarke@example.com', 'clarke123', 7, 0),
('Hannah Lee', 'hannah.lee@example.com', 'lee_hannah456', 8, 0),
('Ian Wright', 'ian.wright@example.com', 'wrightian789', 9, 0),
('Jessica Miller', 'jessica.miller@example.com', 'millertime123', 10, 0),
('test', 'test@test.com', 't@test', 13, 0),
('John Saleh', 'johnsaleh4@outlook.com', '123456', 15, 0),
('جون صالح', 'arabictest@test.com', 'اختبار', 16, 0),
('Test Name', 'signuptest@test.com', 'signuptest', 18, 0),
('John Nageh', 'johnnageh@gmail.com', 'password', 19, 0),
('etsiojtseiofjseothsejrioawethuaet', 'test@test.com', 'etstset', 20, 0),
('tsetase', 'ser@esr.com', 'easetase', 21, 0),
('Test', 'testing@test.com', 'password', 23, 0),
('john', 'john@gmail.com', '45', 24, 0),
('John Doe', 'john@inst.com', '45', 25, 1),
('Jane Smith', 'jane@inst.com', '________', 26, 2),
('Rahma Ashraf', 'rahma@gmail.com', '12345', 27, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_cart`
--

CREATE TABLE `student_cart` (
  `s_id` int(11) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_cart`
--

INSERT INTO `student_cart` (`s_id`, `c_id`) VALUES
(24, 103),
(24, 108);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_i_id` (`i_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `old_cart`
--
ALTER TABLE `old_cart`
  ADD KEY `p_id` (`p_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `student_cart`
--
ALTER TABLE `student_cart`
  ADD KEY `s_id` (`s_id`),
  ADD KEY `c_id` (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Course ID, Primary key that auto-increments', AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Instructor''s ID, Primary key, auto-incremented', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_i_id` FOREIGN KEY (`i_id`) REFERENCES `instructor` (`i_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `old_cart`
--
ALTER TABLE `old_cart`
  ADD CONSTRAINT `old_cart_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `payment` (`p_id`),
  ADD CONSTRAINT `old_cart_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`),
  ADD CONSTRAINT `old_cart_ibfk_3` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`);

--
-- Constraints for table `student_cart`
--
ALTER TABLE `student_cart`
  ADD CONSTRAINT `student_cart_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`),
  ADD CONSTRAINT `student_cart_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
