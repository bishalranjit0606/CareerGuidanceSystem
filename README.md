Career Guidance System
What This Project Is About
This project is a website designed to help people find the best career path for them. It's like a smart guide that learns about you – your skills, what you like, and how you prefer to work – and then gives you personalized job suggestions. It can even help you create a basic resume!

The website has two types of users:

Regular Users: People who want career advice.

Administrators (Admins): People who manage the website's content, like adding new jobs or skills.

What It Can Do (Key Features)
Easy Sign-Up and Login: You can create an account and log in easily.

Separate Admin Login: Admins have their own special login page for better security.

Your Personal Profile: You can update your details, like:

Your school/university name and graduation year.

Your major and GPA (grades).

Lots of Skills: Choose from a big list of computer-related skills (like Python, Java, Cloud, AI, etc.). There's even a search bar to find skills quickly!

Detailed Quiz: Answer questions about your ideal work environment, how you solve problems, what interests you, and your personality.

Work Experience Summary: Write down your past job experiences.

Projects Summary: Describe any projects you've worked on.

Smart Job Suggestions:

Top Career Paths: Get job ideas that are a good match for you, with a "Compatibility Score."

Skills to Learn: It suggests new skills that would be helpful for jobs you're interested in.

Success Prediction: Get a percentage score showing how well you might fit into different careers.

Quick Resume Builder: Create a basic resume instantly using all the information from your profile. You can then print it or save it as a PDF.

Admin Control Panel: If you're an admin, you can easily:

Manage Careers: Add, change, or remove job titles and their descriptions.

Manage Skills: Add, change, or remove skills available on the site.

Manage Users: See all user accounts and safely delete them if needed.

What It's Built With (Technologies)
Frontend (What you see in your browser):

HTML: For the structure of the web pages.

CSS: For making the website look good (colors, fonts, layout).

JavaScript: For interactive parts, like the skill search bar.

Backend (What works behind the scenes):

PHP: The programming language that handles user requests, talks to the database, and runs the smart algorithms.

Database (Where all the information is stored):

MySQL: A popular database system.

Project Files (Structure)
Here's how the project folders and files are organized:

CareerGuidanceSystem/
├── admin/                     # Files for the Admin Panel
│   ├── dashboard.php          # Admin's main page
│   ├── manage_careers.php     # Add/Edit/Delete job careers
│   ├── manage_skills.php      # Add/Edit/Delete skills
│   └── manage_users.php       # View and delete user accounts
├── algorithms/                # PHP files for the smart recommendation logic
│   ├── association_rule_mining.php # Suggests new skills
│   ├── career_scoring.php     # Calculates job compatibility scores
│   └── linear_regression.php  # Predicts success percentages
├── assets/                    # Design and interactive files
│   ├── css/
│   │   └── style.css          # Main styles for the whole website
│   └── js/
│       └── script.js          # (Currently not heavily used, but ready for more JavaScript)
├── backend/                   # PHP files that process forms and data
│   ├── process_admin_login.php # Handles admin login
│   ├── process_login.php      # Handles regular user login
│   └── process_registration.php # Handles new user sign-ups
├── config/                    # Important settings
│   └── config.php             # Database connection details
├── user/                      # Files for regular users
│   ├── dashboard.php          # User's main page
│   ├── generate_resume.php    # Creates the resume
│   ├── profile.php            # Page to update personal info, skills, and quiz answers
│   └── recommendations.php    # Shows job recommendations
├── admin_login.php            # Separate login page for Admins
├── index.php                  # The main home page of the website
├── login.php                  # Login page for regular users
├── logout.php                 # Logs users out
├── register.php               # Sign-up page for new users
├── README.md                  # This document!
└── database_schema.sql        # The blueprint for your database (tables and initial data)

