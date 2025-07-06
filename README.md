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

How to Get This Project Running on Your Computer (Step-by-Step Guide)
This project uses XAMPP, which helps your computer act like a web server and run the database.

Prerequisites (What you need before you start)
XAMPP: Download and install XAMPP for your operating system.

Download link: https://www.apachefriends.org/download.html

Web Browser: Like Chrome, Firefox, Edge, etc.

Text Editor: Like VS Code, Sublime Text, Notepad++, or even basic Notepad/TextEdit.

Git: (Optional, but good for managing code) If you plan to use Git commands, make sure it's installed.

Installation Steps (Follow carefully for your operating system)
For Windows Users:
Install XAMPP:

Download the XAMPP installer for Windows from the link above.

Run the installer. Follow the on-screen instructions. You can usually accept the default settings.

Once installed, open the XAMPP Control Panel.

Place Project Files:

Find your XAMPP installation folder. By default, it's usually C:\xampp.

Inside C:\xampp, there's a folder called htdocs. This is where your website files go.

Copy your entire CareerGuidanceSystem project folder (the one containing all the files and folders listed above) into C:\xampp\htdocs.

So, the path to your main index.php will be C:\xampp\htdocs\CareerGuidanceSystem\index.php.

Configure MySQL Port (Crucial: 3307):

In the XAMPP Control Panel, find the "MySQL" row.

Click the "Config" button next to MySQL and select my.ini. This will open a text file.

In the my.ini file, find the line that says port = 3306 (it's usually under a section like [mysqld]).

Change port = 3306 to port = 3307.

Save and close the my.ini file.

Stop MySQL in the XAMPP Control Panel (if it's running), then Start it again for the change to take effect.

Start Apache and MySQL:

In the XAMPP Control Panel, click "Start" next to "Apache" and "MySQL".

Their status should turn green.

Create Database and Tables:

Open your web browser and go to: http://localhost/phpmyadmin/

On the left side, click "New".

In the "Database name" field, type career_guidance_db and click "Create".

Now, on the left sidebar, click on the career_guidance_db database to select it.

Click the "SQL" tab at the top.

Import your project's database blueprint:

Find the database_schema.sql file in your CareerGuidanceSystem folder.

Open this database_schema.sql file in a text editor (like Notepad++ or VS Code).

Copy all the content from database_schema.sql.

Paste it into the large text area under the "SQL" tab in phpMyAdmin.

Click the "Go" button (usually at the bottom right) to run the commands. This will create all the necessary tables and fill them with initial data (like skills and careers).

For macOS Users:
Install XAMPP:

Download the XAMPP installer for macOS from the link above.

Run the .dmg file and drag the XAMPP application to your Applications folder.

Open the XAMPP application from your Applications folder.

Place Project Files:

Open your Terminal app.

Navigate to your XAMPP web folder:

cd /Applications/XAMPP/xamppfiles/htdocs/

Copy your entire CareerGuidanceSystem project folder (the one containing all the files and folders listed above) into this htdocs directory.

So, the path to your main index.php will be /Applications/XAMPP/xamppfiles/htdocs/CareerGuidanceSystem/index.php.

Configure MySQL Port (Crucial: 3307):

Open the XAMPP application on your macOS.

Go to the "Manage Servers" tab.

Stop MySQL Database (if it's running).

Go to the "Services" tab (or "Configure" for MySQL) in XAMPP.

Find the my.cnf file (usually located at /Applications/XAMPP/xamppfiles/etc/my.cnf).

Open my.cnf in a text editor (like TextEdit or VS Code).

Find the line that says port = 3306 (it's usually under a section like [mysqld]).

Change port = 3306 to port = 3307.

Save and close the my.cnf file.

Start MySQL Database again in XAMPP.

Start Apache and MySQL:

In the XAMPP application, go to "Manage Servers" and ensure both Apache Web Server and MySQL Database are running (their lights should be green).

Create Database and Tables:

Open your web browser and go to: http://localhost/phpmyadmin/

On the left side, click "New".

In the "Database name" field, type career_guidance_db and click "Create".

Now, on the left sidebar, click on the career_guidance_db database to select it.

Click the "SQL" tab at the top.

Import your project's database blueprint:

Find the database_schema.sql file in your CareerGuidanceSystem folder.

Open this database_schema.sql file in a text editor (like VS Code or TextEdit).

Copy all the content from database_schema.sql.

Paste it into the large text area under the "SQL" tab in phpMyAdmin.

Click the "Go" button (usually at the bottom right) to run the commands. This will create all the necessary tables and fill them with initial data (like skills and careers).

Running the Application (After Setup)
Make sure Apache and MySQL are running in your XAMPP Control Panel (Windows) or XAMPP application (macOS).

Open your web browser and go to:

http://localhost/CareerGuidanceSystem/

You should see the home page of the Career Guidance System!

How to Use the Website (First Time & Key Features)
Initial Access:
Public Home Page: Go to http://localhost/CareerGuidanceSystem/

User Registration: Click "Register" on the home page or go to http://localhost/CareerGuidanceSystem/register.php to create a new user account.

User Login: Click "User Login" on the home page or go to http://localhost/CareerGuidanceSystem/login.php to log in as a regular user.

Admin Login: Click "Admin Login" on the home page or go to http://localhost/CareerGuidanceSystem/admin_login.php to log in as an administrator.

How to Create an Admin Account:
First, Register a new regular user through the website (register.php).

Then, open your web browser and go to http://localhost/phpmyadmin/.

On the left sidebar, click on your database: career_guidance_db.

Click on the users table.

Find the user you just registered. Click the "Edit" button (pencil icon) next to their row.

Change the role field from user to admin.

Click "Go" to save the change. Now that user is an administrator!

Using the User Dashboard:
After logging in as a regular user, you'll be on your dashboard (user/dashboard.php).

My Profile: Go to user/profile.php. This is the most important page for getting good recommendations.

Fill in your academic details (University, Major, GPA, Graduation Year).

Select your skills: Use the search bar to quickly find and check off all the computer-related skills you have.

Answer the quiz: Answer all the questions about your interests and work style.

Summarize Experience & Projects: Write down your work experience and key projects in the provided text boxes.

Click "Save Profile and Quiz Answers" when done.

My Recommendations: Go to user/recommendations.php. Here you'll see:

Top Career Paths: Jobs that are a good match for you, with a compatibility score.

Skill Enhancement Suggestions: Ideas for new skills to learn.

Potential Success Percentages: How well you might fit into different careers.

Generate Resume: Go to user/generate_resume.php. This will show your personalized resume based on all the info you entered in your profile. You can use your browser's print function to save it as a PDF.

Using the Admin Dashboard:
After logging in as an administrator, you'll be on the admin dashboard (admin/dashboard.php).

Manage Careers: Add new job titles, update their descriptions, or remove old ones.

Manage Skills: Add new skills to the system, update existing skill names, or remove them.

Manage Users: See a list of all registered users and delete their accounts (this will also remove all their associated data like skills and quiz answers).

Ideas for Making It Even Better (Future Enhancements)
If you want to expand this project further, here are some ideas:

Admin can manage Quiz Questions: Let the admin add, edit, or delete the quiz questions themselves.

Better Text Editors: Use a fancy text editor (like TinyMCE or CKEditor) for writing job descriptions or experience summaries, allowing bold text, bullet points, etc.

More Advanced Job Matching: Explore more complex ways to match users to jobs, like using machine learning to learn from many users.

Show Data with Charts: Add graphs or charts to the recommendations page or admin dashboard to visualize data.

User Feedback: Let users rate how helpful the recommendations were.

Password Reset: Add a "Forgot Password" feature.

Job Posting Integration: Connect to real job websites to show actual job openings.

Credits & Thanks
Developed by: Bishal Ranjitkar

Special Thanks: To anyone who helped or guided me during this project.

License
This project is open-source, which means you're free to use, share, and change the code.
