-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2025 at 05:53 AM
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
-- Database: `career_guidance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `title`, `description`) VALUES
(1, 'Web Developer', 'Designs, develops, and maintains websites and web applications. html css'),
(2, 'Data Scientist', 'Analyzes complex data to extract insights and predict future trends.'),
(3, 'Cybersecurity Analyst', 'Protects computer systems and networks from threats and attacks.'),
(4, 'Digital Marketing Specialist', 'Plans and executes digital marketing campaigns.'),
(5, 'Graphic Designer', 'Creates visual concepts using computer software or by hand, to communicate ideas.'),
(6, 'Network Administrator', 'Manages computer networks, ensuring smooth operation.'),
(7, 'Project Manager', 'Plans, executes, and closes projects, ensuring they meet deadlines and budgets.'),
(8, 'DevOps', 'intrested in cloud'),
(9, 'fullstack', 'mern');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `url`, `skill_id`, `created_at`) VALUES
(1, 'Docker & Kubernetes Masterclasss', 'Learn containerization and orchestration with Docker and Kubernetes.', 'https://www.udemy.com/course/learn-devops-ci-cd-with-jenkins-using-pipelines-and-docker/?couponCode=LETSLEARNNOW', 89, '2025-07-14 20:14:21'),
(3, 'The Complete Python Bootcamp From Zero to Hero in Python', 'Master Python 3 by building 12+ real-world projects. Learn Python for web development, data science, and machine learning.', 'https://www.udemy.com/course/complete-python-bootcamp/', 17, '2025-07-14 20:30:57'),
(4, 'Python for Everybody Specialization', 'This Specialization builds on the success of the Python for Everybody course and will introduce fundamental programming concepts including data structures, networked application program interfaces, and databases, using the Python programming language.', 'https://www.coursera.org/specializations/python', 17, '2025-07-14 20:30:57'),
(5, 'The Complete JavaScript Course 2024: From Zero to Expert!', 'The modern JavaScript course for everyone! Master JavaScript with projects, challenges and theory. Loves JS, React, Node, CSS & more!', 'https://www.udemy.com/course/the-complete-javascript-course/', 19, '2025-07-14 20:30:57'),
(6, 'Java Programming Masterclass for Software Developers', 'Learn Java In This Course And Become a Computer Programmer. Obtain valuable Core Java Skills And Java Certification!', 'https://www.udemy.com/course/java-the-complete-java-developer-course/', 18, '2025-07-14 20:30:57'),
(7, 'C++ Programming for Beginners - Master C++', 'Learn C++ from scratch. Master C++ fundamentals, object-oriented programming, and advanced features.', 'https://www.udemy.com/course/cpp-programming-for-beginners/', 20, '2025-07-14 20:30:57'),
(8, 'C# Masterclass: Learn C# & .NET Core from Scratch', 'A complete guide to C# programming language and .NET Core framework.', 'https://www.udemy.com/course/csharp-masterclass/', 21, '2025-07-14 20:30:57'),
(9, 'Go (Golang) Programming for Beginners', 'Learn the Go programming language (Golang) from scratch with practical examples.', 'https://www.udemy.com/course/go-programming-for-beginners/', 24, '2025-07-14 20:30:57'),
(10, 'The Complete Ruby on Rails Developer Course', 'Learn to code with Ruby on Rails. Build a social network, a blog, and more!', 'https://www.udemy.com/course/the-complete-ruby-on-rails-developer-course/', 23, '2025-07-14 20:30:57'),
(11, 'HTML, CSS, and JavaScript for Web Developers', 'Master the basics of web development including HTML5, CSS3, and JavaScript.', 'https://www.coursera.org/learn/html-css-javascript-for-web-developers', 39, '2025-07-14 20:30:57'),
(12, 'Build Responsive Real-World Websites with HTML and CSS', 'The most complete HTML and CSS course. Learn to build beautiful, responsive websites.', 'https://www.udemy.com/course/design-and-develop-a-killer-website-with-html5-and-css3/', 40, '2025-07-14 20:30:57'),
(13, 'React - The Complete Guide (incl Hooks, React Router, Redux)', 'Dive in and learn React.js from scratch! Learn Reactjs, Redux, React Routing, Animations, Next.js basics and way more!', 'https://www.udemy.com/course/react-the-complete-guide-incl-hooks-redux/', 41, '2025-07-14 20:30:57'),
(14, 'Angular - The Complete Guide (2024 Edition)', 'Master Angular (formerly Angular 2) and build awesome, reactive web apps with the successor of Angular.js.', 'https://www.udemy.com/course/the-complete-guide-to-angular-2/', 42, '2025-07-14 20:30:57'),
(15, 'Vue JS 3 - The Complete Guide (w/ Router, Vuex, Composition API)', 'Vue.js is an awesome JavaScript Framework for building Frontend Applications! Learn VueJS from the ground up!', 'https://www.udemy.com/course/vuejs-2-the-complete-guide/', 43, '2025-07-14 20:30:57'),
(16, 'Bootstrap 5 Course: Build 5 Modern Websites', 'Learn Bootstrap 5 from scratch and build stunning responsive websites.', 'https://www.udemy.com/course/bootstrap-5-course/', 46, '2025-07-14 20:30:57'),
(17, 'jQuery Crash Course', 'Learn jQuery fundamentals to simplify JavaScript DOM manipulation.', 'https://www.youtube.com/watch?v=D_x-b1_j_wE', 45, '2025-07-14 20:30:57'),
(18, 'Node.js, Express, MongoDB & More: The Complete Bootcamp 2024', 'Master Node.js, Express, MongoDB, Mongoose, REST APIs, Security, JWTs, SSR, Pug, and more.', 'https://www.udemy.com/course/nodejs-express-mongodb-bootcamp/', 57, '2025-07-14 20:30:57'),
(19, 'Django 4 and Python Full-Stack Developer Bootcamp', 'Learn to build powerful web applications with Python and Django.', 'https://www.udemy.com/course/python-and-django-full-stack-web-developer-bootcamp/', 59, '2025-07-14 20:30:57'),
(20, 'Flask: Build a Portfolio Site with Python and Flask', 'Build a fully functional portfolio website using the Flask micro-framework.', 'https://www.udemy.com/course/flask-build-a-portfolio-site/', 60, '2025-07-14 20:30:57'),
(21, 'ASP.NET Core MVC: The Complete Guide', 'Build robust web applications using Microsoft\'s ASP.NET Core MVC framework.', 'https://www.udemy.com/topic/aspnet-mvc/', 62, '2025-07-14 20:30:57'),
(22, 'Spring Boot 3, Spring Framework 6 & Hibernate for Beginners', 'Learn Spring Boot, Spring Framework, Hibernate, REST APIs, Microservices, and more.', 'https://www.udemy.com/course/spring-boot-hibernate-jpa-tutorial/', 63, '2025-07-14 20:30:57'),
(23, 'SQL - The Complete Developer Guide (MySQL, PostgreSQL, Oracle, MS SQL)', 'Learn SQL from scratch for MySQL, PostgreSQL, Oracle, and Microsoft SQL Server. Practical exercises included.', 'https://www.udemy.com/course/sql-the-complete-developer-guide/', NULL, '2025-07-14 20:30:57'),
(24, 'MySQL for Beginners: Learn SQL Database Programming', 'A comprehensive course to learn MySQL database programming and administration.', 'https://www.udemy.com/course/mysql-for-beginners/', 72, '2025-07-14 20:30:57'),
(25, 'MongoDB - The Complete Developer\'s Guide 2024', 'Master MongoDB, Mongoose, Node.js, and Express.js to build powerful NoSQL applications.', 'https://www.udemy.com/course/mongodb-the-complete-developers-guide/', 74, '2025-07-14 20:30:57'),
(26, 'PostgreSQL Bootcamp: From Zero to Hero', 'Learn PostgreSQL from scratch and master database design and SQL queries.', 'https://www.udemy.com/course/postgresql-bootcamp/', 73, '2025-07-14 20:30:57'),
(27, 'Ultimate AWS Certified Solutions Architect - Associate 2024', 'Pass the AWS Certified Solutions Architect Associate Certification. Learn AWS Cloud from scratch!', 'https://www.udemy.com/course/aws-certified-solutions-architect-associate-saa-c03/', 86, '2025-07-14 20:30:57'),
(28, 'AZ-900: Microsoft Azure Fundamentals Exam Prep', 'Prepare for the Microsoft Azure Fundamentals AZ-900 exam and learn cloud concepts, Azure services, and core solutions.', 'https://www.udemy.com/course/az-900-azure-fundamentals-exam-prep-microsoft-azure/', 87, '2025-07-14 20:30:57'),
(29, 'Google Cloud Platform (GCP) Fundamentals: Core Infrastructure', 'Learn the fundamentals of Google Cloud Platform and prepare for the Associate Cloud Engineer exam.', 'https://www.coursera.org/learn/gcp-fundamentals-core-infrastructure', 88, '2025-07-14 20:30:57'),
(30, 'Cloud Security Fundamentals', 'Understand the principles of cloud security and how to protect cloud environments.', 'https://www.udemy.com/course/cloud-security-fundamentals/', 97, '2025-07-14 20:30:57'),
(31, 'Serverless Computing with AWS Lambda & API Gateway', 'Build and deploy serverless applications using AWS Lambda, API Gateway, and other AWS services.', 'https://www.udemy.com/course/aws-lambda-serverless/', 98, '2025-07-14 20:30:57'),
(32, 'Docker & Kubernetes: The Practical Guide', 'Learn Docker, Docker Compose, Kubernetes, and Helm - build, deploy, and scale applications.', 'https://www.udemy.com/course/docker-kubernetes-the-practical-guide/', 89, '2025-07-14 20:30:57'),
(33, 'Jenkins, From Zero To Hero: Become a DevOps Engineer', 'Master Jenkins for CI/CD. Learn to automate your build, test, and deployment pipelines.', 'https://www.udemy.com/course/jenkins-from-zero-to-hero/', 93, '2025-07-14 20:30:57'),
(34, 'Terraform for AWS, Azure, and GCP', 'Learn Infrastructure as Code with Terraform. Deploy resources on AWS, Azure, and Google Cloud.', 'https://www.udemy.com/course/terraform-for-aws-azure-and-gcp/', 91, '2025-07-14 20:30:57'),
(35, 'Ansible for the Absolute Beginner - Hands-On', 'Learn Ansible automation from scratch with practical examples and use cases.', 'https://www.udemy.com/course/ansible-for-the-absolute-beginner-devops/?couponCode=LETSLEARNNOW', 92, '2025-07-14 20:30:57'),
(36, 'Git & GitHub - The Practical Guide', 'Master Git and GitHub for version control, collaboration, and open-source contributions.', 'https://www.udemy.com/course/git-and-github-the-practical-guide/', 101, '2025-07-14 20:30:57'),
(37, 'CI/CD Pipelines with Jenkins, Docker, and Kubernetes', 'Build robust Continuous Integration and Continuous Delivery pipelines.', 'https://www.udemy.com/course/learn-devops-ci-cd-with-jenkins-using-pipelines-and-docker/?couponCode=PMNVD2525', 110, '2025-07-14 20:30:57'),
(38, 'The Linux Command Line: A Complete Introduction', 'Master the Linux command line and shell scripting for system administration and DevOps.', 'https://www.udemy.com/course/linux-command-line/', NULL, '2025-07-14 20:30:57'),
(39, 'Bash Scripting and Shell Programming', 'Learn to automate tasks and write powerful scripts with Bash.', 'https://www.udemy.com/course/bash-shell-scripting/?couponCode=PMNVD2525', NULL, '2025-07-14 20:30:57'),
(40, 'Monitoring & Logging for DevOps', 'Understand how to implement effective monitoring and logging strategies for modern applications.', 'https://www.udemy.com/course/monitoring-logging-devops/', 113, '2025-07-14 20:30:57'),
(41, 'Microservices Architecture', 'Design and build scalable and resilient microservices using various technologies.', 'https://www.udemy.com/course/microservices-architecture/', 69, '2025-07-14 20:30:57'),
(42, 'Data Analysis with Python', 'Learn to analyze data using Python libraries like Pandas, NumPy, and Matplotlib.', 'https://www.coursera.org/learn/data-analysis-with-python', 9, '2025-07-14 20:30:57'),
(43, 'Machine Learning by Andrew Ng (Coursera)', 'The classic machine learning course covering linear regression, logistic regression, neural networks, and more.', 'https://www.coursera.org/learn/machine-learning', 10, '2025-07-14 20:30:57'),
(44, 'Deep Learning Specialization', 'Master deep learning, understand how to build neural networks, and lead successful ML projects.', 'https://www.coursera.org/specializations/deep-learning', 132, '2025-07-14 20:30:57'),
(45, 'TensorFlow 2.0: Deep Learning and Artificial Intelligence', 'Build and train neural networks using TensorFlow 2.0 for various AI applications.', 'https://www.udemy.com/course/tensorflow-2-0-deep-learning-and-artificial-intelligence/', 121, '2025-07-14 20:30:57'),
(46, 'PyTorch: Deep Learning and Neural Networks', 'Learn to build, train, and deploy deep learning models using PyTorch.', 'https://www.udemy.com/course/pytorch-deep-learning/', 123, '2025-07-14 20:30:57'),
(47, 'R Programming', 'Learn R for data analysis, statistical computing, and graphics.', 'https://www.coursera.org/learn/r-programming', 31, '2025-07-14 20:30:57'),
(48, 'Data Visualization with Python', 'Create compelling data visualizations using Matplotlib, Seaborn, and Plotly.', 'https://www.udemy.com/course/data-visualization-with-python/', NULL, '2025-07-14 20:30:57'),
(49, 'The Complete Cyber Security Course : Hackers Exposed!', 'Learn ethical hacking, penetration testing, and cybersecurity fundamentals.', 'https://www.udemy.com/course/learn-ethical-hacking-penetration-testing/?couponCode=PMNVD2525', 12, '2025-07-14 20:30:57'),
(50, 'CompTIA Security+ SY0-601 Cert Prep: The Basics', 'Prepare for the Security+ exam and gain fundamental cybersecurity knowledge.', 'https://www.linkedin.com/learning/comptia-security-sy0-601-cert-prep-the-basics', 150, '2025-07-14 20:30:57'),
(51, 'Ethical Hacking: Learn from Scratch', 'A complete guide to ethical hacking, penetration testing, and web application security.', 'https://www.udemy.com/course/ethical-hacking-from-scratch/', NULL, '2025-07-14 20:30:57'),
(52, 'Certified Ethical Hacker (CEH) Certification Prep', 'Prepare for the CEH exam and master advanced ethical hacking techniques.', 'https://www.udemy.com/course/certified-ethical-hacker-ceh-v11-certification-prep/', NULL, '2025-07-14 20:30:57'),
(53, 'Network Security Fundamentals', 'Understand the core concepts of network security, including firewalls, VPNs, and intrusion detection.', 'https://www.udemy.com/course/network-security-fundamentals/', 150, '2025-07-14 20:30:57'),
(54, 'Cryptography and Network Security', 'Explore cryptographic algorithms and network security protocols.', 'https://www.coursera.org/learn/cryptography-network-security', 156, '2025-07-14 20:30:57'),
(55, 'Networking Fundamentals for Beginners', 'Learn the basics of computer networking, TCP/IP, routing, and switching.', 'https://www.udemy.com/course/networking-fundamentals-for-beginners/', 172, '2025-07-14 20:30:57'),
(56, 'TCP/IP and Networking for IT Professionals', 'Deep dive into TCP/IP protocols and networking concepts essential for IT roles.', 'https://www.udemy.com/course/tcp-ip-and-networking/', 173, '2025-07-14 20:30:57'),
(57, 'DNS and DHCP Fundamentals', 'Understand how DNS and DHCP work and how to configure them.', 'https://www.udemy.com/course/dns-dhcp-fundamentals/', 174, '2025-07-14 20:30:57'),
(58, 'Linux for Beginners: The Complete Linux Training Course', 'Master the Linux operating system from scratch for system administration and development.', 'https://www.udemy.com/course/linux-training/', NULL, '2025-07-14 20:30:57'),
(59, 'Windows Server Administration Fundamentals', 'Learn the basics of managing and administering Windows Server environments.', 'https://www.udemy.com/course/windows-server-administration/', 170, '2025-07-14 20:30:57'),
(61, 'Communication Skills: Become a Master Communicator', 'Improve your public speaking, active listening, and interpersonal skills.', 'https://www.udemy.com/course/communication-skills-become-a-master-communicator/', 180, '2025-07-14 20:30:57'),
(62, 'Critical Thinking Skills for Problem Solvers', 'Develop your critical thinking and problem-solving abilities.', 'https://www.udemy.com/course/critical-thinking-skills/', 5, '2025-07-14 20:30:57'),
(63, 'Leadership and Management Skills', 'Develop essential leadership and management skills for career advancement.', 'https://www.udemy.com/course/leadership-and-management-skills/', 190, '2025-07-14 20:30:57'),
(64, 'Effective Public Speaking', 'Overcome public speaking anxiety and deliver engaging presentations.', 'https://www.udemy.com/course/public-speaking-masterclass/', 187, '2025-07-14 20:30:57'),
(65, 'Negotiation Skills: Master the Art of Negotiation', 'Learn powerful negotiation techniques for business and life.', 'https://www.udemy.com/course/negotiation-skills-master-the-art-of-negotiation/', 188, '2025-07-14 20:30:57'),
(66, 'Teamwork and Collaboration Skills', 'Enhance your ability to work effectively in teams and collaborate on projects.', 'https://www.udemy.com/course/teamwork-and-collaboration-skills/', 7, '2025-07-14 20:30:57'),
(67, 'Problem Solving & Decision Making', 'Learn structured approaches to problem-solving and effective decision-making.', 'https://www.udemy.com/course/problem-solving-decision-making/', 4, '2025-07-14 20:30:57'),
(68, 'Research Methods for IT Professionals', 'Understand how to conduct effective research for technical projects.', 'https://www.udemy.com/course/research-methods-for-it-professionals/', 186, '2025-07-14 20:30:57'),
(69, 'Technical Writing: Master Your Content', 'Learn to write clear, concise, and effective technical documentation.', 'https://www.udemy.com/course/technical-writing-master-your-content/', 185, '2025-07-14 20:30:57'),
(70, 'User Experience (UX) Design Fundamentals', 'Learn the principles of UX design and create user-centered interfaces.', 'https://www.udemy.com/course/user-experience-design-fundamentals/', 53, '2025-07-14 20:30:57'),
(71, 'Graphic Design Masterclass - Learn Great Design', 'A complete guide to graphic design principles, tools, and techniques.', 'https://www.udemy.com/course/graphic-design-masterclass/', 13, '2025-07-14 20:30:57'),
(72, 'The Complete Digital Marketing Course - 12 Courses in 1', 'Master Digital Marketing: SEO, YouTube, Email Marketing, Facebook Marketing, Analytics & More!', 'https://www.udemy.com/course/the-complete-digital-marketing-course/', NULL, '2025-07-14 20:30:57'),
(73, 'SEO Training 2024: Complete SEO Course + WordPress SEO', 'Learn SEO from scratch and rank your website higher on Google.', 'https://www.udemy.com/course/seo-training/', NULL, '2025-07-14 20:30:57'),
(74, 'Social Media Marketing Mastery', 'Master social media marketing strategies for various platforms.', 'https://www.udemy.com/course/social-media-marketing-mastery/', NULL, '2025-07-14 20:30:57'),
(75, 'Content Writing Masterclass: Build a Content Writing Business', 'Learn to write engaging and effective content for websites, blogs, and marketing.', 'https://www.udemy.com/course/content-writing-masterclass/', 14, '2025-07-14 20:30:57'),
(76, 'Human Resources Management: HR for People Managers', 'Understand the fundamentals of HR management, employee relations, and talent acquisition.', 'https://www.udemy.com/course/human-resources-management-hr-for-people-managers/', NULL, '2025-07-14 20:30:57'),
(77, 'Recruiting, Hiring, and Onboarding Employees', 'Learn best practices for talent acquisition, interviewing, and onboarding new hires.', 'https://www.coursera.org/learn/recruiting-hiring-onboarding', NULL, '2025-07-14 20:30:57'),
(78, 'Conflict Resolution Skills', 'Develop strategies for effective conflict resolution in the workplace.', 'https://www.udemy.com/course/conflict-resolution-skills-training/', NULL, '2025-07-14 20:30:57'),
(79, 'Employee Relations & Engagement', 'Master techniques for fostering positive employee relations and engagement.', 'https://www.udemy.com/course/employee-relations-engagement/', NULL, '2025-07-14 20:30:57'),
(80, 'HR Analytics: Using Data to Drive Decisions', 'Learn to use data and analytics to make informed HR decisions.', 'https://www.coursera.org/learn/hr-analytics-using-data-to-drive-decisions', NULL, '2025-07-14 20:30:57'),
(81, 'Talent Management & Development', 'Strategies for attracting, developing, and retaining top talent.', 'https://www.udemy.com/course/talent-management-development/', NULL, '2025-07-14 20:30:57'),
(82, 'Organizational Development & Change Management', 'Understand how to drive organizational change and development initiatives.', 'https://www.udemy.com/course/organizational-development-change-management/', NULL, '2025-07-14 20:30:57'),
(83, 'Benefits and Compensation Management', 'A comprehensive guide to designing and managing employee benefits and compensation programs.', 'https://www.udemy.com/course/benefits-and-compensation-management/', NULL, '2025-07-14 20:30:57'),
(84, 'Training and Development for HR Professionals', 'Design and deliver effective training programs for employee growth.', 'https://www.udemy.com/course/training-and-development-for-hr-professionals/', NULL, '2025-07-14 20:30:57'),
(85, 'Ethical Conduct in the Workplace', 'Understand the importance of ethics and professional conduct in HR.', 'https://www.udemy.com/course/ethical-conduct-in-the-workplace/', NULL, '2025-07-14 20:30:57'),
(86, 'Data Privacy and GDPR Compliance', 'Learn about data privacy regulations and compliance in HR.', 'https://www.udemy.com/course/data-privacy-gdpr-compliance/', NULL, '2025-07-14 20:30:57'),
(87, 'HR Compliance & Employment Law', 'Understand key employment laws and compliance requirements for HR.', 'https://www.udemy.com/course/hr-compliance-employment-law/', NULL, '2025-07-14 20:30:57'),
(88, 'Agile Project Management', 'project', 'https://www.coursera.org/learn/agile-project-management', 181, '2025-11-26 10:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `success_score` decimal(5,2) NOT NULL,
  `recommended_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`id`, `user_id`, `career_id`, `success_score`, `recommended_at`) VALUES
(585, 5, 8, 78.16, '2025-11-26 05:12:04'),
(586, 5, 9, 24.44, '2025-11-26 05:12:04'),
(587, 5, 1, 29.20, '2025-11-26 05:12:04'),
(588, 5, 3, 24.81, '2025-11-26 05:12:04'),
(589, 5, 6, 21.05, '2025-11-26 05:12:04'),
(590, 5, 5, 31.19, '2025-11-26 05:12:04'),
(591, 5, 7, 20.26, '2025-11-26 05:12:04'),
(592, 5, 4, 29.81, '2025-11-26 05:12:04'),
(593, 5, 2, 18.99, '2025-11-26 05:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(167, '3D Modeling'),
(107, 'Agile Methodologies'),
(181, 'Agile Project Management'),
(143, 'Android Development'),
(42, 'Angular'),
(168, 'Animation'),
(92, 'Ansible'),
(136, 'Apache Spark'),
(184, 'API Integration'),
(151, 'Application Security'),
(198, 'AR/VR Development'),
(62, 'ASP.NET Core'),
(33, 'Assembly'),
(193, 'Automated Testing'),
(86, 'AWS (Amazon Web Services)'),
(87, 'Azure (Microsoft Azure)'),
(95, 'Azure DevOps'),
(50, 'Babel'),
(135, 'Big Data'),
(104, 'Bitbucket'),
(195, 'Blockchain'),
(46, 'Bootstrap'),
(140, 'Business Intelligence (BI)'),
(21, 'C#'),
(162, 'C# (Game Dev)'),
(20, 'C++'),
(163, 'C++ (Game Dev)'),
(79, 'Cassandra'),
(110, 'CI/CD Pipelines'),
(199, 'Cloud Architecture'),
(99, 'Cloud Migration'),
(97, 'Cloud Security'),
(35, 'Cobol'),
(6, 'Communication'),
(180, 'Communication Skills'),
(159, 'Compliance (GDPR, HIPAA)'),
(131, 'Computer Vision'),
(106, 'Confluence'),
(111, 'Containerization'),
(14, 'Content Writing'),
(5, 'Critical Thinking'),
(156, 'Cryptography'),
(40, 'CSS3'),
(12, 'Cybersecurity'),
(32, 'Dart'),
(9, 'Data Analysis'),
(126, 'Data Cleaning'),
(200, 'Data Governance'),
(85, 'Data Modeling'),
(138, 'Data Warehousing'),
(82, 'Database Design'),
(3, 'Database Management (MySQL)'),
(183, 'Debugging'),
(132, 'Deep Learning'),
(201, 'DevSecOps'),
(175, 'DHCP'),
(59, 'Django'),
(174, 'DNS'),
(89, 'Docker'),
(80, 'Elasticsearch'),
(116, 'ELK Stack'),
(152, 'Endpoint Security'),
(139, 'ETL'),
(58, 'Express.js'),
(66, 'FastAPI'),
(127, 'Feature Engineering'),
(176, 'Firewalls'),
(60, 'Flask'),
(146, 'Flutter'),
(34, 'Fortran'),
(164, 'Game Design'),
(101, 'Git'),
(102, 'GitHub'),
(103, 'GitLab'),
(94, 'GitLab CI/CD'),
(24, 'Go'),
(96, 'Google Cloud Build'),
(88, 'Google Cloud Platform (GCP)'),
(115, 'Grafana'),
(13, 'Graphic Design'),
(68, 'GraphQL'),
(137, 'Hadoop'),
(36, 'Haskell'),
(39, 'HTML5'),
(158, 'Identity and Access Management (IAM)'),
(153, 'Incident Response'),
(100, 'Infrastructure as Code (IaC)'),
(144, 'iOS Development'),
(196, 'IoT (Internet of Things)'),
(18, 'Java'),
(19, 'JavaScript'),
(93, 'Jenkins'),
(105, 'Jira'),
(45, 'jQuery'),
(109, 'Kanban'),
(122, 'Keras'),
(26, 'Kotlin'),
(90, 'Kubernetes'),
(64, 'Laravel'),
(190, 'Leadership'),
(37, 'Lisp'),
(177, 'Load Balancing'),
(10, 'Machine Learning'),
(194, 'Manual Testing'),
(15, 'Marketing'),
(124, 'Matplotlib'),
(189, 'Mentoring'),
(69, 'Microservices'),
(129, 'Model Evaluation'),
(128, 'Model Training'),
(74, 'MongoDB'),
(113, 'Monitoring & Logging'),
(72, 'MySQL'),
(149, 'NativeScript'),
(130, 'Natural Language Processing (NLP)'),
(188, 'Negotiation'),
(81, 'Neo4j'),
(150, 'Network Security'),
(11, 'Networking'),
(172, 'Networking Fundamentals'),
(57, 'Node.js'),
(84, 'NoSQL Databases'),
(119, 'NumPy'),
(169, 'Operating Systems (Linux/Unix)'),
(77, 'Oracle Database'),
(112, 'Orchestration'),
(118, 'Pandas'),
(155, 'Penetration Testing'),
(30, 'Perl'),
(22, 'PHP'),
(165, 'Physics Engines'),
(73, 'PostgreSQL'),
(142, 'Power BI'),
(4, 'Problem Solving'),
(1, 'Programming (PHP)'),
(55, 'Progressive Web Apps (PWAs)'),
(8, 'Project Management'),
(38, 'Prolog'),
(114, 'Prometheus'),
(187, 'Public Speaking'),
(17, 'Python'),
(123, 'PyTorch'),
(191, 'Quality Assurance (QA)'),
(197, 'Quantum Computing Basics'),
(31, 'R'),
(145, 'React Native'),
(41, 'React.js'),
(75, 'Redis'),
(133, 'Reinforcement Learning'),
(186, 'Research Skills'),
(52, 'Responsive Design'),
(67, 'RESTful APIs'),
(23, 'Ruby'),
(61, 'Ruby on Rails'),
(28, 'Rust'),
(48, 'Sass/Less'),
(29, 'Scala'),
(120, 'Scikit-learn'),
(108, 'Scrum'),
(125, 'Seaborn'),
(157, 'Security Information and Event Management (SIEM)'),
(70, 'Serverless Architecture'),
(98, 'Serverless Computing'),
(166, 'Shader Programming'),
(56, 'Single-Page Applications (SPAs)'),
(202, 'Site Reliability Engineering (SRE)'),
(192, 'Software Testing'),
(117, 'Splunk'),
(63, 'Spring Boot'),
(83, 'SQL Query Optimization'),
(76, 'SQL Server'),
(78, 'SQLite'),
(134, 'Statistical Analysis'),
(44, 'Svelte'),
(25, 'Swift'),
(147, 'SwiftUI'),
(65, 'Symfony'),
(178, 'System Administration'),
(141, 'Tableau'),
(47, 'Tailwind CSS'),
(173, 'TCP/IP'),
(7, 'Teamwork'),
(179, 'Technical Support'),
(185, 'Technical Writing'),
(121, 'TensorFlow'),
(91, 'Terraform'),
(27, 'TypeScript'),
(51, 'TypeScript (Frontend)'),
(53, 'UI/UX Design Principles'),
(160, 'Unity 3D'),
(161, 'Unreal Engine'),
(182, 'Version Control'),
(171, 'Virtualization'),
(43, 'Vue.js'),
(154, 'Vulnerability Assessment'),
(54, 'Web Accessibility'),
(2, 'Web Design (HTML/CSS)'),
(49, 'Webpack'),
(71, 'WebSockets'),
(170, 'Windows Server'),
(148, 'Xamarin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `major` varchar(255) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `experience_summary` text DEFAULT NULL,
  `projects_summary` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `summary_text` text DEFAULT NULL,
  `university_name` varchar(255) DEFAULT NULL,
  `graduation_year` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `major`, `gpa`, `experience_summary`, `projects_summary`, `phone_number`, `linkedin_url`, `summary_text`, `university_name`, `graduation_year`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$2x885dh5RFrKyUvmWM9v/Ofp1fwp555R4wUzwplwJded0YQb7B3My', 'admin', '2025-07-06 16:18:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'tester', 'tester@gmail.com', '$2y$10$UWUytlcI/wUxh1c/fhV99.1ejWjS7KV51oeWZPIliqP6XhbvCcprS', 'user', '2025-07-26 16:52:57', 'computer science', 4.00, '[{\"company\":\"kathmandu bernhardt college\",\"position\":\"intern\",\"description\":\"Completed a dynamic internship, gaining extensive hands-on experience in IT infrastructure and developing strong foundational skills in computer networking, cabling management, and firewall configuration. This role provided direct exposure to industry best practices in security and network maintenance, significantly improving my professional competence in a fast-paced environment and building a strong practical knowledge base.\",\"start_date\":\"june 2025\",\"end_date\":\"present\"}]', '[{\"name\":\"3 tier web app deployed\",\"description\":\"Designed and deployed a highly scalable 3-Tier Application environment on AWS. The architecture leverages VPC and Subnets for secure foundational networking, utilizes EC2 instances managed by an Auto Scaling Group (ASG) for high availability, and uses an Application Load Balancer (ALB) for intelligent traffic distribution.\"}]', '9800000000', 'https://www.linkedin.com/in/testeruser/', 'Results-driven and detail-oriented professional with a proven ability to adapt quickly, solve complex problems, and deliver high-quality work under pressure.', 'testing university', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `question`, `answer`) VALUES
(474, 5, 'What is your ideal work environment?', 'Flexible environment with autonomy, creativity, and less rigid structure'),
(475, 5, 'How do you prefer to approach problem-solving?', 'Experimenting and iterating quickly to find solutions'),
(476, 5, 'What kind of tasks do you find most engaging?', 'Managing projects and coordinating teams||Researching new technologies and concepts||Securing systems and preventing attacks'),
(477, 5, 'How do you prefer to learn new technologies or skills?', 'Hands-on coding/building projects'),
(478, 5, 'How comfortable are you with continuous learning and adapting to new tools?', 'Extremely comfortable, I thrive on new challenges'),
(479, 5, 'Which of the following areas interests you most?', 'Cloud Computing & DevOps'),
(480, 5, 'Are you comfortable with abstract concepts and theoretical frameworks?', 'Somewhat comfortable, I prefer practical applications'),
(481, 5, 'How much do you enjoy working with mathematical or statistical concepts?', 'Moderately enjoy, I can apply them when needed'),
(482, 5, 'How would you describe your communication style?', 'Collaborative and consensus-driven'),
(483, 5, 'Are you more of a detail-oriented person or a big-picture thinker?', 'Mostly detail-oriented, but can see the big picture'),
(484, 5, 'How do you handle repetitive tasks?', 'Strongly dislike repetitive tasks, I seek automation'),
(485, 5, 'How important is innovation and creating new things to you?', 'Very important, I enjoy contributing to new ideas'),
(486, 5, 'What drives you most in a career?', 'Opportunities for continuous learning and growth||Working with cutting-edge technologies');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`user_id`, `skill_id`) VALUES
(5, 86),
(5, 87),
(5, 88),
(5, 89),
(5, 90),
(5, 91),
(5, 93),
(5, 94),
(5, 95),
(5, 97),
(5, 100),
(5, 101),
(5, 102),
(5, 115),
(5, 158),
(5, 169),
(5, 174),
(5, 201);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `career_id` (`career_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`user_id`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
