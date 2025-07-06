Career Guidance System
What This Project Does
This is a website that helps people figure out what career might be a good fit for them. It asks you about your skills, what you like, and how you prefer to work, then suggests jobs and even helps you build a basic resume. It has two main types of users: regular people looking for career help, and administrators who manage the website's information.

Main Things It Can Do
Easy Sign-Up and Login: You can create an account and log in, whether you're a regular user or an admin.

Separate Admin Login: Admins have their own special login page for extra security.

Your Personal Profile: You can fill in your school details (like your major and grades), pick all the computer skills you have, and answer a fun quiz about your interests. You can also write down your work experiences and projects.

Smart Job Suggestions:

It gives you job ideas that match your skills and quiz answers.

It suggests new skills you might want to learn to help you get certain jobs.

It even guesses how well you might do in different careers based on your info.

Quick Resume Builder: It can create a simple resume for you, using all the information you put in your profile. You can then print it or save it as a PDF.

Admin Control Panel: If you're an admin, you can easily add, change, or remove job titles and skills on the website. You can also see and manage all the user accounts.

What It's Built With
Front-End (What you see): Standard web languages like HTML, CSS (for styling), and a bit of JavaScript (for things like searching skills).

Back-End (What makes it work): PHP (a popular web programming language).

Database (Where information is stored): MySQL (a common database system).

How to Get It Running on Your Computer (for Mac users with XAMPP)
This project is set up to run on a Mac using a tool called XAMPP.

What You Need
XAMPP for Mac: Download and install it from https://www.apachefriends.org/download.html. It helps your computer act like a web server.

Mac Terminal: You'll use this to type in a few commands.

Steps to Install
Put the Project Files in the Right Place:

Open your Terminal app.

Go to your XAMPP web folder:

cd /Applications/XAMPP/xamppfiles/htdocs/

Copy your entire CareerGuidanceSystem folder (the one with all the project files) into this htdocs folder.

Set Up the Database (IMPORTANT: Port 3307):

Open the XAMPP app on your Mac.

Go to "Manage Servers" and make sure Apache Web Server and MySQL Database are running.

Crucial Step for MySQL: This project uses MySQL on a special port (3307) instead of the usual one (3306).

Stop MySQL Database in XAMPP.

In XAMPP, go to the "Services" tab (or "Configure" for MySQL).

Find the my.cnf file (usually at /Applications/XAMPP/xamppfiles/etc/my.cnf).

Open my.cnf with a text editor (like TextEdit or VS Code).

Look for port = 3306 (under the [mysqld] section) and change it to port = 3307.

Save the file.

Start MySQL Database again in XAMPP.

Create the Database and Tables:

Open your web browser and go to http://localhost/phpmyadmin/.

On the left side, click "New".

Type career_guidance_db as the database name and click "Create".

Now, click on career_guidance_db on the left side to select it.

Click the "SQL" tab at the top.

You need to get your database's blueprint (schema) and starting data.

In phpMyAdmin, with career_guidance_db selected, go to the "Export" tab.

Choose "Custom" export.

Make sure all tables are selected.

Choose "Save output to a file" (SQL format).

Make sure "Structure" (the table design) and "Data" (the info inside) are both checked.

Click "Go". This will download a file.

Rename this downloaded file to database_schema.sql and put it in your main CareerGuidanceSystem/ folder.

Back in the "SQL" tab in phpMyAdmin, paste everything from your database_schema.sql file into the big text box.

Click "Go" to run it. This will create all the tables and fill them with initial data.

How to Use the Website
Make sure Apache and MySQL are running in your XAMPP app.

Open your web browser and go to:

http://localhost/CareerGuidanceSystem/

First Time Using It?
Sign Up as a Regular User: Click "Register" to make a new account for yourself.

Become an Admin (if you want to manage things): After you sign up as a regular user, go to http://localhost/phpmyadmin/. Find your new user in the users table, click "Edit", and change their role from user to admin.

Log In: Use your new account to log in!

What You Can Do (Quick Guide)
Home Page: http://localhost/CareerGuidanceSystem/ (The main page everyone sees)

Your User Account:

My Profile: Update your school info, pick your skills (use the search bar!), answer the quiz, and write about your work and projects.

My Recommendations: See job ideas, skills to learn, and how well you might fit different careers.

Generate Resume: Create your resume instantly!

Admin Account (Website Manager):

Manage Careers: Add or change job titles and their descriptions.

Manage Skills: Add or change the list of skills available.

Manage Users: See all users and delete accounts if needed.

Ideas for Making It Even Better (Future Plans)
Let admins add or change quiz questions.

Add a fancy text editor for writing job descriptions or experience summaries.

Make the resume builder even more detailed (add specific job entries, not just summaries).

Add charts or graphs to show data.

Let users give feedback on the job suggestions.


