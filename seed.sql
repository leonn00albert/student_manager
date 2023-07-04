-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2023 at 09:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `permissions` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulletins`
--

CREATE TABLE `bulletins` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('warning','info','success','danger') DEFAULT 'info',
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `classroom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulletins`
--

INSERT INTO `bulletins` (`id`, `title`, `type`, `message`, `created_at`, `classroom_id`) VALUES
(1, 'tesad', 'warning', 'asdsad', '2023-06-27 09:26:01', 0),
(2, 'asdsad', 'warning', 'adsasd', '2023-06-27 09:26:16', 0),
(5, 'Day off 07-12', 'info', 'We will have the day off to celebrate some holiday is some specfic country because reasons', '2023-06-27 13:30:12', 18),
(6, 'dasdsa', 'info', 'sadasd', '2023-06-29 11:08:53', 40),
(7, 'Upcoming Holidays', 'info', 'We will be taking next week off for holidays', '2023-07-03 10:36:14', 41);

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `classroom_id` int(11) NOT NULL,
  `classroom_name` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`classroom_id`, `classroom_name`, `teacher_id`, `course_id`, `is_archived`) VALUES
(37, 'New Classroom for course_id: /', 4, 0, 1),
(38, 'New Classroom for course_id: /', 4, 0, 0),
(39, 'New Classroom for course_id: /', 4, 0, 0),
(40, 'Advanced Javascript 1', 4, 6, 0),
(41, 'Advanced Javascript K6', 4, 6, 0),
(42, 'Web security 101 B3', 4, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `course_description` text DEFAULT NULL,
  `course_image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_status` enum('Active','Inactive','Completed','Upcoming','Cancelled','Archived','On-hold') DEFAULT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `section_count` int(11) DEFAULT NULL,
  `module_count` int(11) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `teacher_id`, `course_description`, `course_image`, `start_date`, `end_date`, `course_status`, `classroom_id`, `section_count`, `module_count`, `is_archived`) VALUES
(6, 'Advanced Javascript', 4, 'Advanced JavaScript is a course that delves into more complex concepts and techniques for working with the JavaScript programming language. It builds upon the foundational knowledge of JavaScript and explores advanced features, best practices, and design patterns to write more efficient, scalable, and maintainable code.', 'https://www.tutorialbar.com/wp-content/uploads/2635498_6a46_2-2048x1152.jpg', '2023-06-30', '2023-07-28', 'Upcoming', 41, 2, 1, 0),
(7, 'Web security 101', 4, 'Web Security 101 is an introductory course designed to provide a comprehensive overview of the fundamental principles and best practices for securing web applications and websites. In this course, participants will gain a solid understanding of the various threats and vulnerabilities that exist in the web ecosystem and learn practical techniques to mitigate those risks.', 'https://www.ingenious.news/wp-content/uploads/2019/12/CyberSecurity-101-min.png', '2023-07-11', '2023-09-08', 'Active', 42, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `classroom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrollment_date`, `classroom_id`) VALUES
(6, 11, 6, '2023-06-30', 41),
(7, 13, 6, '2023-06-30', 41),
(8, 12, 6, '2023-07-01', 41),
(9, 11, 7, '2023-07-03', 42),
(10, 12, 7, '2023-07-03', 42);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `assignment` text DEFAULT NULL,
  `score` decimal(5,2) DEFAULT 0.00,
  `classroom_id` int(11) DEFAULT NULL,
  `grade_answer` text DEFAULT NULL,
  `submit_date` date DEFAULT NULL,
  `grade_status` enum('Pending','Submitted','Graded') DEFAULT 'Pending',
  `course_id` int(11) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `student_id`, `section_id`, `assignment`, `score`, `classroom_id`, `grade_answer`, `submit_date`, `grade_status`, `course_id`, `is_archived`) VALUES
(33, 11, 14, 'Exercise:', 9.00, 41, 'Here, by default, content is only permitted from the document&amp;#039;s origin, with the following exceptions:\r\n\r\n    Images may load from anywhere (note the &amp;quot;*&amp;quot; wildcard).\r\n    Media is only allowed from example.org and example.net (and not from subdomains of those sites).\r\n    Executable script is only allowed from userscripts.example.com.\r\n\r\nExample 4\r\n\r\nA website administrator for an online banking site wants to ensure that all its content is loaded using TLS, in order to prevent attackers from eavesdropping on requests.', '2023-07-04', 'Graded', 6, 0),
(34, 11, 16, NULL, 7.00, 42, 'Violation report syntax\r\n\r\nThe report JSON object is sent with an application/csp-report Content-Type and contains the following data:\r\n\r\nblocked-uri\r\n\r\n    The URI of the resource that was blocked from loading by the Content Security Policy. If the blocked URI is from a different origin than the document-uri, then the blocked URI is truncated to contain just the scheme, host, and port.\r\ndisposition\r\n\r\n    Either &amp;quot;enforce&amp;quot; or &amp;quot;report&amp;quot; depending on whether the Content-Security-Policy-Report-Only header or the Content-Security-Policy header is used.\r\ndocument-uri\r\n\r\n    The URI of the document in which the violation occurred.\r\neffective-directive\r\n\r\n    The directive whose enforcement caused the violation. Some browsers may provide different values, such as Chrome providing style-src-elem/style-src-attr, even when the actually enforced directive was style-src.\r\noriginal-policy\r\n\r\n    The original policy as specified by the Content-Security-Policy HTTP header.', '2023-07-04', 'Graded', 7, 0),
(35, 12, 15, 'Part', 6.00, 41, 'Violation report syntax\r\n\r\nThe report JSON object is sent with an application/csp-report Content-Type and contains the following data:\r\n\r\nblocked-uri\r\n\r\n    The URI of the resource that was blocked from loading by the Content Security Policy. If the blocked URI is from a different origin than the document-uri, then the blocked URI is truncated to contain just the scheme, host, and port.\r\ndisposition\r\n\r\n    Either &amp;quot;enforce&amp;quot; or &amp;quot;report&amp;quot; depending on whether the Content-Security-Policy-Report-Only header or the Content-Security-Policy header is used.\r\ndocument-uri\r\n\r\n    The URI of the document in which the violation occurred.\r\neffective-directive\r\n\r\n    The directive whose enforcement caused the violation. Some browsers may provide different values, such as Chrome providing style-src-elem/style-src-attr, even when the actually enforced directive was style-src.\r\noriginal-policy\r\n\r\n    The original policy as specified by the Content-Security-Policy HTTP header.', '2023-07-04', 'Graded', 6, 0),
(36, 12, 16, NULL, 7.00, 42, 'Violation report syntax\r\n\r\nThe report JSON object is sent with an application/csp-report Content-Type and contains the following data:\r\n\r\nblocked-uri\r\n\r\n    The URI of the resource that was blocked from loading by the Content Security Policy. If the blocked URI is from a different origin than the document-uri, then the blocked URI is truncated to contain just the scheme, host, and port.\r\ndisposition\r\n\r\n    Either &amp;quot;enforce&amp;quot; or &amp;quot;report&amp;quot; depending on whether the Content-Security-Policy-Report-Only header or the Content-Security-Policy header is used.\r\ndocument-uri\r\n\r\n    The URI of the document in which the violation occurred.\r\neffective-directive\r\n\r\n    The directive whose enforcement caused the violation. Some browsers may provide different values, such as Chrome providing style-src-elem/style-src-attr, even when the actually enforced directive was style-src.\r\noriginal-policy\r\n\r\n    The original policy as specified by the Content-Security-Policy HTTP header.', '2023-07-04', 'Graded', 7, 0),
(37, 12, 17, 'Writing', 8.00, 42, 'Violation report syntax\r\n\r\nThe report JSON object is sent with an application/csp-report Content-Type and contains the following data:\r\n\r\nblocked-uri\r\n\r\n    The URI of the resource that was blocked from loading by the Content Security Policy. If the blocked URI is from a different origin than the document-uri, then the blocked URI is truncated to contain just the scheme, host, and port.\r\ndisposition\r\n\r\n    Either &amp;quot;enforce&amp;quot; or &amp;quot;report&amp;quot; depending on whether the Content-Security-Policy-Report-Only header or the Content-Security-Policy header is used.\r\ndocument-uri\r\n\r\n    The URI of the document in which the violation occurred.\r\neffective-directive\r\n\r\n    The directive whose enforcement caused the violation. Some browsers may provide different values, such as Chrome providing style-src-elem/style-src-attr, even when the actually enforced directive was style-src.\r\noriginal-policy\r\n\r\n    The original policy as specified by the Content-Security-Policy HTTP header.', '2023-07-04', 'Graded', 7, 0);

--
-- Triggers `grades`
--
DELIMITER $$
CREATE TRIGGER `insert_progress_entry` AFTER INSERT ON `grades` FOR EACH ROW BEGIN
    SET @grade_count := (
            SELECT COUNT(*)
            FROM grades
            WHERE student_id = NEW.student_id
              AND classroom_id = NEW.classroom_id
              AND grade_status = 'Graded'
        );
    -- Check if the entry exists in the 'progress' table based on classroom_id and student_id
    IF NOT EXISTS (
        SELECT 1
        FROM progress
        WHERE classroom_id = NEW.classroom_id
          AND student_id = NEW.student_id
    ) THEN
        -- Insert a new entry into the 'progress' table
        INSERT INTO progress (student_id, classroom_id, graded,course_id)
        VALUES (NEW.student_id, NEW.classroom_id,  @grade_count,NEW.course_id);

    -- Update the 'grades' count in the 'progress' table if the entry exists
    ELSE
        -- Get the count of graded grades associated with student and classroom
    

        -- Update the 'grades' field in the 'progress' table
        UPDATE progress
        SET graded = @grade_count
        WHERE student_id = NEW.student_id
          AND classroom_id = NEW.classroom_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_column_trigger` BEFORE UPDATE ON `grades` FOR EACH ROW BEGIN
  IF NEW.score IS NOT NULL THEN
    SET NEW.grade_status = 'Graded';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_progress_entry` AFTER UPDATE ON `grades` FOR EACH ROW BEGIN
    SET @grade_count := (
            SELECT COUNT(*)
            FROM grades
            WHERE student_id = NEW.student_id
              AND classroom_id = NEW.classroom_id
              AND grade_status = 'Graded'
        );
    -- Check if the entry exists in the 'progress' table based on classroom_id and student_id
    IF NOT EXISTS (
        SELECT 1
        FROM progress
        WHERE classroom_id = NEW.classroom_id
          AND student_id = NEW.student_id
    ) THEN
        -- Insert a new entry into the 'progress' table
        INSERT INTO progress (student_id, classroom_id, graded,course_id)
        VALUES (NEW.student_id, NEW.classroom_id,  @grade_count,NEW.course_id);

    -- Update the 'grades' count in the 'progress' table if the entry exists
    ELSE
        -- Get the count of graded grades associated with student and classroom
    

        -- Update the 'grades' field in the 'progress' table
        UPDATE progress
        SET graded = @grade_count
        WHERE student_id = NEW.student_id
          AND classroom_id = NEW.classroom_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_progress_sections` AFTER INSERT ON `grades` FOR EACH ROW BEGIN
    UPDATE progress
    SET sections = (SELECT section_count FROM courses WHERE course_id = NEW.course_id)
    WHERE student_id = NEW.student_id
    AND classroom_id = NEW.classroom_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_progress_sections_update` BEFORE UPDATE ON `grades` FOR EACH ROW BEGIN
    UPDATE progress
    SET sections = (SELECT section_count FROM courses WHERE course_id = NEW.course_id)
    WHERE student_id = NEW.student_id
    AND course_id = NEW.course_id
    ;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `homepage_cms`
--

CREATE TABLE `homepage_cms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_text` varchar(255) DEFAULT NULL,
  `cta_text` varchar(255) DEFAULT NULL,
  `cta_url` varchar(255) DEFAULT NULL,
  `featured_course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_cms`
--

INSERT INTO `homepage_cms` (`id`, `title`, `hero_image`, `hero_title`, `hero_text`, `cta_text`, `cta_url`, `featured_course`) VALUES
(1, 'Welcome to Tech From Scratch', 'https://b2294532.smushcdn.com/2294532/wp-content/uploads/2020/12/mainsection-bg-scaled.jpg?lossy=0&amp;strip=1&amp;webp=1', 'Welcome to Tech From Scratch', 'At Tech From Scratch, we believe in empowering individuals to embark on their tech journey and build their skills from the ground up. Whether you&#039;re a beginner or an aspiring tech professional, our platform is here to guide you through the exciting w', 'Enroll Now', '/login', 6);

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_url` varchar(255) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`book_id`, `book_title`, `book_url`, `publication_date`, `book_image`) VALUES
(4, 'Security for Web Developers', 'https://www.pdfdrive.com/security-for-web-developers-using-javascript-html-and-css-e101499028.html', NULL, 'https://cdn.asaha.com/assets/thumbs/b76/b766af631f32eb2e6dcd523199b2da64.jpg'),
(5, 'Learning PHP, MySQL, JavaScript, CSS &amp;amp; HTML5', 'https://www.pdfdrive.com/learning-php-mysql-javascript-css-html5-a-step-by-step-guide-to-creating-dynamic-websites-e158606918.html', NULL, 'https://cdn.asaha.com/assets/thumbs/d35/d35ed880c62754b24760ef2af778ce4d.jpg'),
(6, 'Practical PHP 7, MySQL 8, and MariaDB Website Databases: A Simplified Approach to Developing Database-Driven Websites Practical PHP 7, MySQL 8, and MariaDB Website Databases', 'https://www.pdfdrive.com/practical-php-7-mysql-8-and-mariadb-website-databases-a-simplified-approach-to-developing-database-driven-websites-e187206125.html', NULL, 'https://cdn.asaha.com/assets/thumbs/6a6/6a6f9c9c39b01d56bcc6920a9999196b.jpg'),
(7, 'Laravel: Up &amp;amp; Running', 'https://www.pdfdrive.com/laravel-up-running-a-framework-for-building-modern-php-apps-e189833029.html0', NULL, 'https://cdn.asaha.com/assets/thumbs/bca/bcab3289fb1dee43e2b2b6528a6600bb.jpg'),
(8, 'Design Patterns in PHP and Laravel Design Patterns in PHP and Laravel', 'https://www.pdfdrive.com/design-patterns-in-php-and-laravel-e55291610.html', NULL, 'https://cdn.asaha.com/assets/thumbs/280/2804a8549d1e7410d25718fc23b6ca0e.jpg'),
(9, 'Professional: JavaScript&amp;reg; for Web Developers', 'https://www.pdfdrive.com/professional-javascript-for-web-developers-e33417074.html', NULL, 'https://cdn.asaha.com/assets/thumbs/70d/70d66e5bf096c446f134695c866242b9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `recipient_id`, `subject`, `message`, `date`) VALUES
(2, 11, 15, NULL, 'dasdas', NULL),
(3, 11, 9, NULL, 'Hello !', NULL),
(4, 11, 9, NULL, 'Do you know where I can find the books for the advanced JS course?', NULL),
(5, 9, 11, NULL, 'Yeah you find them right here', NULL),
(6, 9, 11, NULL, 'https://www.pdfdrive.com/you-dont-know-js-async-performance-e177823297.html', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_count` int(11) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `course_id`, `section_count`, `is_archived`) VALUES
(5, 'Module 1: Object-Oriented Programming (OOP)', 6, NULL, 0),
(6, 'Content security', 7, NULL, 0);

--
-- Triggers `modules`
--
DELIMITER $$
CREATE TRIGGER `module_insert_trigger` AFTER INSERT ON `modules` FOR EACH ROW BEGIN
    UPDATE courses
    SET module_count = (
        SELECT COUNT(*)
        FROM modules
        WHERE course_id = NEW.course_id
    )
    WHERE course_id = NEW.course_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `is_archived` tinyint(1) DEFAULT 0,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `created_at`, `is_read`, `is_archived`, `link`) VALUES
(1, 4, 'leonSubmmited a new assignment to grade', '2023-06-28 06:35:24', 1, 0, '/teachers/classrooms/18'),
(2, 11, 'Your assignment was accepted with a score of: 6', '2023-06-28 10:22:12', 1, 0, '/students/grades/18'),
(3, 4, 'A new student enrolled for your course', '2023-06-28 15:06:16', 1, 0, '/teachers/classrooms/18'),
(4, 4, 'A new student enrolled for your course', '2023-06-28 17:20:33', 1, 0, '/teachers/classrooms/18'),
(5, 4, 'A new student enrolled for your course', '2023-06-29 09:06:28', 1, 0, '/teachers/classrooms/37'),
(6, 4, 'A new student enrolled for your course', '2023-06-29 09:07:06', 1, 0, '/teachers/classrooms/38'),
(7, 4, 'A new student enrolled for your course', '2023-06-29 09:09:13', 1, 0, '/teachers/classrooms/39'),
(8, 4, 'A new student enrolled for your course', '2023-06-29 09:19:06', 1, 0, '/teachers/classrooms/40'),
(9, 4, 'leon Submmited a new assignment to grade', '2023-06-29 10:00:07', 1, 0, '/teachers/classrooms/40'),
(10, 11, 'Your assignment was accepted with a score of: 6', '2023-06-29 10:38:47', 1, 0, '/students/grades/40'),
(11, 11, 'Your assignment was accepted with a score of: 6', '2023-06-29 10:40:19', 1, 0, '/students/grades/40'),
(12, 11, 'Your assignment was accepted with a score of: 9', '2023-06-29 10:40:34', 1, 0, '/students/grades/40'),
(13, 11, 'Your assignment was accepted with a score of: 9', '2023-06-29 10:40:39', 1, 0, '/students/grades/40'),
(14, 11, 'Your assignment was declined with a score of: 0', '2023-06-29 10:41:12', 1, 0, '/students/grades/40'),
(15, 11, 'Your assignment was declined with a score of: 0', '2023-06-29 10:41:12', 1, 0, '/students/grades/40'),
(16, 11, 'Your assignment was accepted with a score of: 10', '2023-06-29 10:41:13', 1, 0, '/students/grades/40'),
(17, 11, 'Your assignment was declined with a score of: 0', '2023-06-29 10:41:13', 1, 0, '/students/grades/40'),
(18, 11, 'Your assignment was accepted with a score of: 10', '2023-06-29 10:41:35', 1, 0, '/students/grades/40'),
(19, 11, 'Your assignment was accepted with a score of: 7', '2023-06-29 10:42:25', 1, 0, '/students/grades/40'),
(20, 11, 'Your assignment was accepted with a score of: 6', '2023-06-29 11:02:16', 1, 0, '/students/grades/40'),
(21, 11, 'Your assignment was accepted with a score of: 7', '2023-06-29 11:02:49', 1, 0, '/students/grades/40'),
(22, 11, 'Your assignment was declined with a score of: 0', '2023-06-29 11:03:56', 1, 0, '/students/grades/40'),
(23, 11, 'Your assignment was accepted with a score of: 8', '2023-06-29 11:04:02', 1, 0, '/students/grades/40'),
(24, 11, 'Your assignment was accepted with a score of: 6', '2023-06-29 11:04:40', 1, 0, '/students/grades/40'),
(25, 11, 'Your assignment was accepted with a score of: 6', '2023-06-29 11:05:07', 1, 0, '/students/grades/40'),
(26, 4, 'leon Submmited a new assignment to grade', '2023-06-30 06:42:09', 1, 0, '/teachers/classrooms/40'),
(27, 11, 'Your assignment was accepted with a score of: 10', '2023-06-30 06:52:25', 1, 0, '/students/grades/40'),
(28, 11, 'Your assignment was declined with a score of: 4', '2023-06-30 07:02:38', 1, 0, '/students/grades/40'),
(29, 4, 'A new student enrolled for your course', '2023-06-30 07:59:51', 1, 0, '/teachers/classrooms/40'),
(30, 4, 'John Submmited a new assignment to grade', '2023-06-30 08:01:47', 1, 0, '/teachers/classrooms/40'),
(31, 12, 'Your assignment was accepted with a score of: 8', '2023-06-30 08:05:51', 0, 0, '/students/grades/40'),
(32, 4, 'leon Submmited a new assignment to grade', '2023-06-30 09:15:43', 1, 0, '/teachers/classrooms/40'),
(33, 4, 'A new student enrolled for your course', '2023-06-30 09:43:52', 1, 0, '/teachers/classrooms/41'),
(34, 4, 'A new student enrolled for your course', '2023-06-30 10:39:50', 1, 0, '/teachers/classrooms/41'),
(35, 4, 'A new student enrolled for your course', '2023-07-01 04:03:57', 1, 0, '/teachers/classrooms/41'),
(36, 4, 'A new student enrolled for your course', '2023-07-03 10:40:13', 1, 0, '/teachers/classrooms/42'),
(37, 4, 'leon Submmited a new assignment to grade', '2023-07-03 13:06:05', 1, 0, '/teachers/classrooms/41'),
(38, 4, 'A new student enrolled for your course', '2023-07-03 13:47:51', 1, 0, '/teachers/classrooms/42'),
(39, 4, 'John Submmited a new assignment to grade', '2023-07-03 13:48:00', 1, 0, '/teachers/classrooms/42'),
(40, 11, 'Your assignment was declined with a score of: 4', '2023-07-03 13:48:28', 1, 0, '/students/grades/41'),
(41, 12, 'Your assignment was declined with a score of: 5', '2023-07-03 13:49:39', 0, 0, '/students/grades/42'),
(42, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:25:12', 1, 0, '/teachers/classrooms/42'),
(43, 11, 'Your assignment was accepted with a score of: 6', '2023-07-03 14:26:05', 1, 0, '/students/grades/42'),
(44, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:29:23', 1, 0, '/teachers/classrooms/41'),
(45, 11, 'Your assignment was accepted with a score of: 7', '2023-07-03 14:29:56', 1, 0, '/students/grades/41'),
(46, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:31:40', 1, 0, '/teachers/classrooms/42'),
(47, 11, 'Your assignment was accepted with a score of: 6', '2023-07-03 14:32:19', 1, 0, '/students/grades/42'),
(48, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:40:16', 1, 0, '/teachers/classrooms/41'),
(49, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:40:23', 1, 0, '/teachers/classrooms/42'),
(50, 11, 'Your assignment was declined with a score of: 4', '2023-07-03 14:41:07', 1, 0, '/students/grades/41'),
(51, 11, 'Your assignment was declined with a score of: 4', '2023-07-03 14:41:18', 0, 0, '/students/grades/42'),
(52, 4, 'John Submmited a new assignment to grade', '2023-07-03 14:43:44', 1, 0, '/teachers/classrooms/41'),
(53, 4, 'John Submmited a new assignment to grade', '2023-07-03 14:43:53', 1, 0, '/teachers/classrooms/42'),
(54, 12, 'Your assignment was declined with a score of: 5', '2023-07-03 14:44:26', 0, 0, '/students/grades/42'),
(55, 12, 'Your assignment was accepted with a score of: 7', '2023-07-03 14:44:42', 0, 0, '/students/grades/41'),
(56, 4, 'leon Submmited a new assignment to grade', '2023-07-03 14:58:41', 1, 0, '/teachers/classrooms/42'),
(57, 11, 'Your assignment was declined with a score of: 4', '2023-07-03 14:59:13', 0, 0, '/students/grades/42'),
(58, 4, 'leon Submmited a new assignment to grade', '2023-07-03 15:04:06', 1, 0, '/teachers/classrooms/41'),
(59, 4, 'leon Submmited a new assignment to grade', '2023-07-03 15:04:17', 1, 0, '/teachers/classrooms/42'),
(60, 11, 'Your assignment was accepted with a score of: 6', '2023-07-03 15:04:43', 0, 0, '/students/grades/42'),
(61, 11, 'Your assignment was accepted with a score of: 6', '2023-07-03 15:04:55', 0, 0, '/students/grades/41'),
(62, 4, 'leon Submmited a new assignment to grade', '2023-07-04 07:01:04', 1, 0, '/teachers/classrooms/41'),
(63, 4, 'leon Submmited a new assignment to grade', '2023-07-04 07:01:27', 1, 0, '/teachers/classrooms/42'),
(64, 4, 'John Submmited a new assignment to grade', '2023-07-04 07:01:48', 0, 0, '/teachers/classrooms/41'),
(65, 4, 'John Submmited a new assignment to grade', '2023-07-04 07:01:55', 0, 0, '/teachers/classrooms/42'),
(66, 4, 'John Submmited a new assignment to grade', '2023-07-04 07:02:02', 0, 0, '/teachers/classrooms/42'),
(67, 11, 'Your assignment was accepted with a score of: 7', '2023-07-04 07:02:24', 0, 0, '/students/grades/42'),
(68, 11, 'Your assignment was accepted with a score of: 7', '2023-07-04 07:02:24', 0, 0, '/students/grades/42'),
(69, 12, 'Your assignment was accepted with a score of: 8', '2023-07-04 07:02:27', 0, 0, '/students/grades/42'),
(70, 12, 'Your assignment was accepted with a score of: 7', '2023-07-04 07:02:31', 0, 0, '/students/grades/42'),
(71, 12, 'Your assignment was accepted with a score of: 6', '2023-07-04 07:02:43', 0, 0, '/students/grades/41'),
(72, 11, 'Your assignment was accepted with a score of: 9', '2023-07-04 07:02:48', 0, 0, '/students/grades/41');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `graded` int(11) DEFAULT NULL,
  `sections` int(11) DEFAULT NULL,
  `percentage` decimal(11,0) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `total_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `student_id`, `classroom_id`, `graded`, `sections`, `percentage`, `student_name`, `course_id`, `total_score`) VALUES
(18, 11, 41, 1, 2, 50, 'leon test', 6, 16),
(19, 11, 42, 1, 2, 50, 'leon test', 7, 7),
(20, 12, 41, 1, 2, 50, 'John Doe', 6, 21),
(21, 12, 42, 2, 2, 100, 'John Doe', 7, 15);

--
-- Triggers `progress`
--
DELIMITER $$
CREATE TRIGGER `calculate_percentage_before_insert` BEFORE INSERT ON `progress` FOR EACH ROW BEGIN
    -- Calculate the percentage based on the grades and sections count
    SET NEW.percentage = (
        CASE
            WHEN NEW.sections > 0 THEN CAST(NEW.graded AS DECIMAL(5, 2)) / NEW.sections * 100
            ELSE 0.0
        END
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `calculate_percentage_before_update` BEFORE UPDATE ON `progress` FOR EACH ROW BEGIN
    -- Calculate the percentage based on the grades and sections count
    SET NEW.percentage = (
        CASE
            WHEN NEW.sections > 0 THEN CAST(NEW.graded AS DECIMAL(5, 2)) / NEW.sections * 100
            ELSE 0.0
        END
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set total_score on insert` BEFORE INSERT ON `progress` FOR EACH ROW BEGIN
    -- Calculate the percentage based on the grades and sections count
    SET NEW.total_score = (
        SELECT SUM(score) FROM grades WHERE student_id = NEW.student_id
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set total_score on update` BEFORE UPDATE ON `progress` FOR EACH ROW SET NEW.total_score = (
        SELECT SUM(score) FROM grades WHERE student_id = NEW.student_id
    )
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_student_name_before_insert` BEFORE INSERT ON `progress` FOR EACH ROW BEGIN
    -- Set the student name based on the users table
    SET NEW.student_name = (
        SELECT CONCAT(u.first_name, ' ', u.last_name)
        FROM users u
        INNER JOIN students s ON u.user_id = s.user_id
        WHERE s.student_id = NEW.student_id
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `section_content` text DEFAULT NULL,
  `section_resources` text DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `assignment` text DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_name`, `section_content`, `section_resources`, `module_id`, `assignment`, `course_id`, `is_archived`) VALUES
(14, 'Understanding prototypes and prototype chains', 'In the last article, we introduced some basic concepts of object-oriented programming (OOP), and discussed an example where we used OOP principles to model professors and students in a school.\r\n\r\nWe also talked about how it&amp;#039;s possible to use prototypes and constructors to implement a model like this, and that JavaScript also provides features that map more closely to classical OOP concepts.\r\n\r\nIn this article, we&amp;#039;ll go through these features. It&amp;#039;s worth keeping in mind that the features described here are not a new way of combining objects: under the hood, they still use prototypes. They&amp;#039;re just a way to make it easier to set up a prototype chain.', 'https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Classes_in_JavaScript', 5, 'Exercise: Understanding Prototypes\r\n\r\n    Create a constructor function called Animal with the following properties and methods:\r\n        Properties: name (string) and age (number)\r\n        Method: eat() - logs a message to the console: &amp;quot;[name] is eating.&amp;quot;\r\n\r\n    Create an instance of Animal called cat with the name &amp;quot;Whiskers&amp;quot; and age 3.\r\n\r\n    Add a method to the Animal prototype called sleep(), which logs a message to the console: &amp;quot;[name] is sleeping.&amp;quot;\r\n\r\n    Create another constructor function called Dog that inherits from Animal and adds an additional property breed (string).\r\n\r\n    Create an instance of Dog called dog with the name &amp;quot;Buddy,&amp;quot; age 5, and breed &amp;quot;Labrador.&amp;quot;\r\n\r\n    Test the functionality of both cat and dog objects by calling their methods (eat(), sleep()) and accessing their properties.', 6, 0),
(15, 'Inheritance and polymorphism in JavaScript:', 'Inheritance and polymorphism in JavaScript:\r\nInheritance allows objects to inherit properties and behaviors from other objects. We will explore how inheritance works in JavaScript and discuss different inheritance patterns, such as the prototype chain, constructor stealing, and explicit prototypes. You will also learn about polymorphism, which enables objects to have multiple forms or behaviors.\r\n\r\nImplementing encapsulation, abstraction, and inheritance patterns:\r\nEncapsulation, abstraction, and inheritance are important concepts in object-oriented programming. In this module, you will learn how to implement these patterns in JavaScript. We will discuss techniques for encapsulating data and methods, creating abstract classes and interfaces, and utilizing inheritance to organize and reuse code effectively.', 'https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Classes_in_JavaScript', 5, 'Part 2: Prototype Chains\r\n\r\n    Explanation of the prototype chain and its significance in inheritance.\r\n    Illustration of how objects can access properties and methods from their prototype chain.\r\n    Demonstration of traversing the prototype chain using the __proto__ property or Object.getPrototypeOf() method.\r\n\r\nPart 3: Inheritance with Prototypes\r\n\r\n    Introduction to object inheritance through prototypes.\r\n    Explanation of how to create a new object with a specific prototype using Object.create().\r\n    Demonstration of extending prototypes to add or override properties and methods.', 6, 0),
(16, 'Content Security Policy (CSP)', 'Content Security Policy (CSP) is an added layer of security that helps to detect and mitigate certain types of attacks, including Cross-Site Scripting (XSS) and data injection attacks. These attacks are used for everything from data theft, to site defacement, to malware distribution.\r\n\r\nCSP is designed to be fully backward compatible (except CSP version 2 where there are some explicitly-mentioned inconsistencies in backward compatibility; more details here section 1.1). Browsers that don&amp;#039;t support it still work with servers that implement it, and vice versa: browsers that don&amp;#039;t support CSP ignore it, functioning as usual, defaulting to the standard same-origin policy for web content. If the site doesn&amp;#039;t offer the CSP header, browsers likewise use the standard same-origin policy.\r\n\r\nTo enable CSP, you need to configure your web server to return the Content-Security-Policy HTTP header. (Sometimes you may see mentions of the X-Content-Security-Policy header, but that&amp;#039;s an older version and you don&amp;#039;t need to specify it anymore.)', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP', 6, 'Configuring Content Security Policy involves adding the Content-Security-Policy HTTP header to a web page and giving it values to control what resources the user agent is allowed to load for that page. For example, a page that uploads and displays images could allow images from anywhere, but restrict a form action to a specific endpoint. A properly designed Content Security Policy helps protect a page against a cross-site scripting attack. This article explains how to construct such headers properly, and provides examples.', 7, 0),
(17, 'Threats', 'Threats\r\nMitigating cross-site scripting\r\n\r\nA primary goal of CSP is to mitigate and report XSS attacks. XSS attacks exploit the browser&amp;#039;s trust in the content received from the server. Malicious scripts are executed by the victim&amp;#039;s browser because the browser trusts the source of the content, even when it&amp;#039;s not coming from where it seems to be coming from.\r\n\r\nCSP makes it possible for server administrators to reduce or eliminate the vectors by which XSS can occur by specifying the domains that the browser should consider to be valid sources of executable scripts. A CSP compatible browser will then only execute scripts loaded in source files received from those allowed domains, ignoring all other scripts (including inline scripts and event-handling HTML attributes).\r\n\r\nAs an ultimate form of protection, sites that want to never allow scripts to be executed can opt to globally disallow script execution.\r\nMitigating packet sniffing attacks\r\n\r\nIn addition to restricting the domains from which content can be loaded, the server can specify which protocols are allowed to be used; for example (and ideally, from a security standpoint), a server can specify that all content must be loaded using HTTPS. A complete data transmission security strategy includes not only enforcing HTTPS for data transfer, but also marking all cookies with the secure attribute and providing automatic redirects from HTTP pages to their HTTPS counterparts. Sites may also use the Strict-Transport-Security HTTP header to ensure that browsers connect to them only over an encrypted channel.', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP', 6, 'Writing a policy\r\n\r\nA policy is described using a series of policy directives, each of which describes the policy for a certain resource type or policy area. Your policy should include a default-src policy directive, which is a fallback for other resource types when they don&amp;#039;t have policies of their own (for a complete list, see the description of the default-src directive). A policy needs to include a default-src or script-src directive to prevent inline scripts from running, as well as blocking the use of eval(). A policy needs to include a default-src or style-src directive to restrict inline styles from being applied from a &amp;lt;style&amp;gt; element or a style attribute. There are specific directives for a wide variety of types of items, so that each type can have its own policy, including fonts, frames, images, audio and video media, scripts, and workers.', 7, 0);

--
-- Triggers `sections`
--
DELIMITER $$
CREATE TRIGGER `section_insert_trigger` AFTER INSERT ON `sections` FOR EACH ROW BEGIN
    UPDATE courses
    SET section_count = (
        SELECT COUNT(*)
        FROM sections
        WHERE module_id = NEW.module_id
          AND course_id = NEW.course_id
    )
    WHERE course_id = NEW.course_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `classroom_id`, `user_id`) VALUES
(5, NULL, 15),
(11, NULL, 11),
(12, NULL, 9),
(13, NULL, 16),
(14, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `first_name`, `last_name`, `contact_number`, `email`, `user_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, 4),
(3, NULL, NULL, NULL, NULL, 5),
(4, NULL, NULL, NULL, NULL, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` enum('student','teacher','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_archived` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `contact_email`, `contact_phone`, `address`, `city`, `country`, `password`, `type`, `created_at`, `last_login`, `last_login_ip`, `date_of_birth`, `gender`, `avatar`, `is_archived`) VALUES
(9, 'John', 'Doe', 'test@student.com', 'asdsad', 'asd', 'asd', 'asdasdsad', '$2y$10$YKm4bMEkWvfOm1L38mlC6.f/2zAjdBxliwpWqkcTUIi/kYNPrwzfO', 'student', '2023-06-24 11:23:20', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/John Doe', 0),
(10, 'leon', 'test', 'admin@test.com', 'asdsad', 'asd', 'asd', 'asdasdsad', '$2y$10$u62w1fZ5CzmO7WNFjrF6GOQHjfYsioD1tE5NAKBpuS5eFYVChBsnm', 'admin', '2023-06-24 11:24:33', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/leon test', 0),
(11, 'leon', 'test', 'student@test.com', 'asdsad', 'asd', 'asd', 'asdasdsad', '$2y$10$3qjewttN6zGATgEd8ZI8VO3i1Bje75Km.q9ASFliJqundmQ1axt0m', 'student', '2023-06-24 11:24:44', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/leon test', 0),
(15, 'teacher', 'test', 'teacher@test.com', '+5954582221', 'marketstreet', 'Cloudcity', 'Bespin', '$2y$10$T8zJeTfGcHFArALlKO/Ob.OWapt1NXED7IL5/oSJPDmD3bxmQtJIi', 'teacher', '2023-06-25 09:03:25', NULL, '::1', '0000-00-00', 'male', 'https://api.multiavatar.com/teacher test', 0),
(16, 'asdasd', 'asddsas', 'test@test.com', 'adsasdsad', 'asdasd', 'asddsa', 'asdsadsa', '$2y$10$IZcd9DPgA4X46JwdBzP5zeYSVwjfCm8u0DhoDumk5f/rdj59bHrf.', 'student', '2023-06-30 10:36:37', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/asdasd asddsas', 1),
(17, 'asdsad', 'saddas', 'asdsaddsa@dsaasd.com', 'asdsad', 'dsasad', 'dsasadd', 'asdsadsad', '$2y$10$J3m5qRUvGhtv..nvjNqUDegRkedJJXdT.uvKpaGGzo.UeFsgM1J4u', 'student', '2023-07-03 17:13:08', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/asdsad saddas', 0),
(18, 'asdasd', 'asdasd', 'asdssdsddas@dsd.com', 'saadsasd', 'adssd', 'adsasd', 'asdsadsad', '$2y$10$BrRxSq0m9GNOBE.gCUAydup1dRRw2Ut.2uFxT2/gsvZ6K6QsxkRpe', 'student', '2023-07-03 17:14:02', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/asdasd asdasd', 0),
(19, 'dsaasd', 'assad', 'asdasd@dasd.com', 'asdasd', 'asdsad', 'adssad', 'dsasda', '$2y$10$DKCX0i35lalKdCKvWGUBBO4po6SXQXPwlrNJDfH4Jhk4GD7VeDBCW', 'student', '2023-07-03 17:15:41', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/dsaasd assad', 0),
(20, 'dadsas', 'asdasd', 'asdadas@sda.com', 'asdasd', '12321', 'dsadasdsa', '12321213', '$2y$10$xX4OhgZ88YdaX9oOF8PgMeWThRMEUIeiLCuB2n/2n7NlMAbhZJWzq', 'student', '2023-07-03 17:18:55', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/dadsas asdasd', 0),
(21, 'asdasd', 'dasasd', 'sdaasd@Dsd.com', 'asasdsa', 'asdsd', 'adsasd', 'sadsad', '$2y$10$A3a1UDwryNTO7PvyBtxtmeu6YZCGiyLDT0JWP0Qq5gmLiS/60QmO2', 'student', '2023-07-03 17:19:25', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/asdasd dasasd', 0),
(22, 'asddsa', 'sad', 'dsaasdsda@dsasd.com', 'sdadas', 'aasddsa', 'sadsad', 'dasasdsa', '$2y$10$7cwz9DHvRhGpXKuFAQ7Se.g8qHSLnHtOv.Ta9OzEitQJZHU3EuZB2', 'student', '2023-07-03 17:20:49', NULL, '::1', NULL, NULL, 'https://api.multiavatar.com/asddsa sad', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bulletins`
--
ALTER TABLE `bulletins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`classroom_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `classroom_id` (`classroom_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `student_id` (`student_id`) USING BTREE,
  ADD KEY `grades_ibfk_2` (`section_id`);

--
-- Indexes for table `homepage_cms`
--
ALTER TABLE `homepage_cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_ibfk_2` (`recipient_id`),
  ADD KEY `messages_ibfk_1` (`sender_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `unique_progress` (`student_id`,`classroom_id`),
  ADD KEY `fk_progress_courses` (`course_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_contact_email` (`contact_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulletins`
--
ALTER TABLE `bulletins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `classroom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `homepage_cms`
--
ALTER TABLE `homepage_cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `enrollments_ibfk_3` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`classroom_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`section_id`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`classroom_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `fk_progress_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`classroom_id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
