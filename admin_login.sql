-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 01:04 PM
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
-- Database: `admin_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `resume_photo_path` varchar(255) NOT NULL,
  `about_yourself` text NOT NULL,
  `high_school` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `skills` text NOT NULL,
  `experiences` text NOT NULL,
  `submission_date` datetime DEFAULT current_timestamp(),
  `status` enum('hired','pending','rejected') DEFAULT 'pending',
  `metrics_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `job_title`, `company_name`, `applicant_name`, `address`, `contact_number`, `email_address`, `resume_photo_path`, `about_yourself`, `high_school`, `college`, `skills`, `experiences`, `submission_date`, `status`, `metrics_score`) VALUES
(3, 8, 'Secretary', 'ByteMagus Co.', 'John Doe', '123 Main St, Anytown, USA', '(123) 456-7890', 'johndoe@example.com', '../uploads/JohnDoe.png', 'A motivated and results-driven professional with over 5 years of experience in software development. Proficient in a variety of programming languages and frameworks, with a passion for learning new technologies and improving processes.', 'Anytown High School, Graduated 2010', 'State University, Bachelor of Science in Computer Science, Graduated 2014', 'Programming Languages: Python, Java, JavaScript, Web Development: HTML, CSS, React, Node.js, Database Management: MySQL, MongoDB, Version Control: Git, Strong problem-solving skills and ability to work in a team environment', 'Worked as an intern IT Support', '2024-08-15 09:07:43', 'rejected', 40),
(10, 12, 'Nightguard', 'Fazbear Entertainment', 'Michael Afton', '456 Elm Street, Anytown, USA', '(555) 987-6543', 'mikesmidth@gmail.com', '../uploads/michael.PNG', 'Dedicated and detail-oriented individual with a strong background in security and safety protocols. Committed to ensuring the safety and security of premises and personnel. Eager to leverage observational skills and experience to contribute effectively as a Night Guard at Fazbear Entertainment.', 'High School Diploma - Anytown High School, Anytown, USA Graduated: June 2015', 'none', 'Strong observational skills and attention to detail., Excellent problem-solving abilities, particularly in high-pressure situations., Familiarity with security systems, including cameras and monitoring equipment., Basic knowledge of emergency response procedures, including first aid and CPR.', 'Monitored surveillance equipment and reported any suspicious activities. | Conducted regular patrols of the premises to ensure safety and security. | Responded promptly to alarms and emergencies, coordinating with local law enforcement when necessary.', '2024-08-15 12:54:34', '', 55),
(11, 12, 'Nightguard', 'Fazbear Entertainment', 'Melvin Stark', '123 Main Street, Cityville, ST 12345', '(123) 456-7890', 'melvinstark@gmail.com', '../uploads/phoneguy.PNG', 'Dedicated and reliable individual seeking a position as a Night Guard. Eager to maintain safety and security while ensuring a peaceful environment.', 'Cityville High School', 'none', 'Basic understanding of security procedures, Good communication skills, Ability to remain calm under pressure, Basic first aid knowledge', '', '2024-08-15 13:47:26', 'hired', 50),
(12, 12, 'Nightguard', 'Fazbear Entertainment', 'Mister Fresh', 'cathaus forever rd China', '423492384324528', 'fresh@gmail.com', '../uploads/mrfresh.gif', 'I play Five nights at freddies video game', '', '', 'Gaming', '', '2024-08-16 09:01:35', 'pending', 5),
(13, 13, 'Manager', 'Beluga Bad Intentions Co.', 'Freddy Fazbear', 'Afton St. FNAF Ave. Michael City', '12334394212', 'fazbear@gmail.com', '../uploads/d8kocm8-2ea797c6-83e4-4628-9c04-82c4935a829c.gif', 'I wanted to be a manager since I was a kid, I saw your company and I thought this will be my best chance to be a manager.', 'Bikini Bottom National Highschool', 'Squidward Community College B', 'Speaks English, Organizational Skills', '', '2024-08-28 12:01:06', 'rejected', 52),
(14, 14, 'Security Guard', 'Beluga Bad Intentions Co.', 'Romnick Canonigo', 'B4 B5 Roundhouse Compd. Las Pinas City', '2131313435511', 'roms@gmail.com', '../uploads/phoneguy.PNG', 'I am a freshgrad who wants to take a temporary job. I saw your post and I saw that the job might be for me.', 'United Nations Highschool B', 'Squidward Community College B', 'Observational Skills', '', '2024-08-28 12:27:16', 'rejected', 50),
(15, 13, 'Manager', 'Beluga Bad Intentions Co.', 'Michael Smith', '123 ABC Lane United Nations', '2349029421', 'michael@gmail.com', '../uploads/michael.PNG', 'I am a security guard for more than 50 years now, I have tons of experience that I am sure the company can benefit to.', 'United Nations Highschool A', 'National College for Security Operations', 'Observational Skills, I am strong, I am the best', 'I worked as a guard before', '2024-08-28 12:30:23', 'hired', 54);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_position` varchar(100) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `job_image` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `job_location` text NOT NULL,
  `contact_details` text NOT NULL,
  `job_qualifications` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `required_skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `company_name`, `job_position`, `company_logo`, `job_image`, `job_description`, `job_location`, `contact_details`, `job_qualifications`, `created_at`, `required_skills`) VALUES
(6, 'WhiskerRealm Tech Solutions', 'Junior Programmer', 'uploads/whisker_realm.png', 'uploads/whisker_realmjob.png', 'We are looking for a fresh grad but capable programmer  to join our growing team. his is an excellent opportunity for someone with a passion.', 'Las Pinas City NCR, Philippines', 'whiskerrealmtech@gmail.com', '• Bachelor’s degree in Computer Science, Information Technology, or a related field (or equivalent experience).\r\n\r\n• Basic understanding of programming languages such as Python, Java, C++, or JavaScript.\r\n\r\n• Familiarity with web development technologies such as HTML, CSS, and JavaScript.\r\n\r\n• Experience with version control systems like Git is a plus.\r\n\r\n• Strong problem-solving skills and attention to detail.\r\n\r\n• Ability to work both independently and as part of a team.\r\n\r\n• Willingness to learn and adapt to new technologies and methodologies.', '2024-08-13 01:57:10', ''),
(8, 'ByteMagus Co.', 'Secretary', 'uploads/byte_magus.png', 'uploads/sexytary.png', 'We are seeking a highly organized and proactive Secretary to join our team. The ideal candidate will provide administrative support to us.', 'Quezon City, Philippines', 'bytemagustech@gmail.com', '⦿ High school diploma or equivalent; additional certification in office administration is a plus.\r\n\r\n⦿ Proven experience as a secretary or in a similar administrative role.\r\n\r\n⦿ Proficient in Microsoft Office Suite (Word, Excel, PowerPoint, Outlook) and other office software.\r\n\r\n⦿ Excellent verbal and written communication skills.\r\n\r\n⦿ Strong organizational and time management skills.\r\n\r\n⦿ Ability to work independently and collaboratively in a team environment.\r\n\r\n⦿ Discretion and confidentiality in handling sensitive information.', '2024-08-13 02:53:48', ''),
(9, 'ByteMagus Co.', 'Cashier', 'uploads/byte_magus.png', 'uploads/job3.png', 'You will take peoples money from their pockets. Have fun making them poor.', 'Las Pinas Underground', 'bytemagustech@gmail.com', '- High school diploma or equivalent required.\r\n- Basic math skills and familiarity with handling money.', '2024-08-14 05:36:49', ''),
(10, 'Stepblock Studios', '3D Modeller', 'uploads/stepblock.png', 'uploads/sand.jpg', 'Your work will be to create any 3d models the company wants. From humans to aliens, cars to tanks. Do you have what it takes?', 'Philippines', 'stepblockstudios@gmail.com', '- Proficient in Blender or any other 3d modelling\r\n\r\n-  Really Nice', '2024-08-14 07:58:43', ''),
(12, 'Fazbear Entertainment', 'Nightguard', 'uploads/faz.PNG', 'uploads/924f726a442dcae75c9cb67f2e0ff3cd.jpg', 'As a Night Guard at Fazbear Entertainment, you will play a crucial role in maintaining the safety and security of our facility.', '123 Fun Street, Anytown, USA', 'Phone: (555) 123-4567\r\nEmail: careers@fazbearentertainment.com', '1. Education and Experience:\r\n\r\n   - High school diploma or equivalent.\r\n   - Previous experience in security or a related field preferred.\r\n\r\n2. Background Check:\r\n\r\n   - Must pass a background check and drug screening prior to employment.', '2024-08-15 04:39:42', 'Strong observational skills, Excellent problem-solving abilities, Familiarity with security systems- cameras- and monitoring equipment., Basic knowledge of emergency response procedures.'),
(13, 'Beluga Bad Intentions Co.', 'Manager', 'uploads/beluga.jfif', 'uploads/thumb-1920-460172.jpg', 'You will manage our East Branch. Please fill the resume form if you want to apply.', 'Eastern City, Nog Nog Federation', 'badintentions@gmail.com', '- College Graduate\r\n- Can speak english', '2024-08-28 03:57:46', 'Organizational Skills, Management Skills, English Speaking Skills'),
(14, 'Beluga Bad Intentions Co.', 'Security Guard', 'uploads/beluga.jfif', 'uploads/images.jfif', 'You will be tasked to keep my building safe. Make sure to fill the resume form if you want to apply.', 'Eastern City, United States', 'badintentions@gmail.com\r\n1231231323 (tel)', '- atleast college graduate\r\n- can use weapons\r\n- background in security operations', '2024-08-28 04:21:07', 'Strong observational skills, Excellent problem-solving abilities, Familiarity with security systems, cameras, and monitoring equipment., Basic knowledge of emergency response procedures.'),
(15, 'Stick n pack', 'tech support', 'uploads/preview.webp', 'uploads/pixlr-image-generator-a87ea0b9-222c-4577-9622-5abef327b6fd.png', 'dtsrtssays', 'rsysyrsyrsys', 'eyytshs', 'ryyyrdyryd', '2024-09-18 10:19:48', 'marketing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'admin', '25e4ee4e9229397b6b17776bfceaf8e7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
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
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
