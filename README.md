<h1>Career Guidance System</h1>

<h2>What This Project Is About</h2>
<p>
This project is a website designed to help people find the best career path for them. It's like a smart guide that learns about you – your skills, what you like, and how you prefer to work – and then gives you personalized job suggestions. It can even help you create a basic resume!
</p>

<p>The website has two types of users:</p>
<ul>
  <li><strong>Regular Users:</strong> People who want career advice.</li>
  <li><strong>Administrators (Admins):</strong> People who manage the website's content, like adding new jobs or skills.</li>
</ul>

<h2>Important: Configure MySQL to Use Port 3306</h2>
<p>This project uses port 3306 for MySQL. Please ensure your XAMPP settings are configured correctly:</p>
<ul>
  <li>Open XAMPP Control Panel.</li>
  <li>Go to Manage Servers tab.</li>
  <li>Select MySQL Database, then click Configure.</li>
  <li>Ensure the port number is set to 3306.</li>
  <li>Save the changes and restart XAMPP.</li>
</ul>

<h2>Login Credentials</h2>
<ul>
  <li><strong>User Account:</strong>
    <ul>
      <li>Email: <code>tester@gmail.com</code></li>
      <li>Password: <code>tester@123</code></li>
    </ul>
  </li>
  <li><strong>Admin Account:</strong>
    <ul>
      <li>Email: <code>admin@gmail.com</code></li>
      <li>Password: <code>Admin@123</code></li>
    </ul>
  </li>
</ul>


<h2>What It Can Do (Key Features)</h2>
<ul>
  <li><strong>Easy Sign-Up and Login:</strong> Create an account and log in easily.</li>
  <li><strong>Separate Admin Login:</strong> Admins have their own login page for security.</li>
  <li><strong>Your Personal Profile:</strong> Update your:
    <ul>
      <li>School/university name and graduation year</li>
      <li>Major and GPA</li>
    </ul>
  </li>
  <li><strong>Lots of Skills:</strong> Choose from many computer-related skills like Python, Java, Cloud, AI, etc., with a skill search bar.</li>
  <li><strong>Detailed Quiz:</strong> Questions about work environment, problem-solving, interests, and personality.</li>
  <li><strong>Work Experience Summary:</strong> Add your past job experiences.</li>
  <li><strong>Projects Summary:</strong> Describe your previous projects.</li>
  <li><strong>Smart Job Suggestions:</strong>
    <ul>
      <li>Top Career Paths with a "Compatibility Score"</li>
      <li>Suggested Skills to Learn</li>
      <li>Success Prediction Percentage</li>
    </ul>
  </li>
  <li><strong>Quick Resume Builder:</strong> Instantly generate and download a basic resume as PDF.</li>
  <li><strong>Admin Control Panel:</strong> Admins can:
    <ul>
      <li>Manage Careers (Add/Edit/Delete)</li>
      <li>Manage Skills (Add/Edit/Delete)</li>
      <li>Manage Users (View/Delete)</li>
    </ul>
  </li>
</ul>

<h2>What It's Built With (Technologies)</h2>
<ul>
  <li><strong>Frontend:</strong>
    <ul>
      <li><code>HTML</code> – Webpage structure</li>
      <li><code>CSS</code> – Styling</li>
      <li><code>JavaScript</code> – Interactivity</li>
    </ul>
  </li>
  <li><strong>Backend:</strong>
    <ul>
      <li><code>PHP</code> – Server-side logic and algorithms</li>
    </ul>
  </li>
  <li><strong>Database:</strong>
    <ul>
      <li><code>MySQL</code> – Data storage</li>
    </ul>
  </li>
</ul>

<h2>Project Files (Structure)</h2>
<pre>
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
├── assets/
│   ├── css/
│   │   └── style.css          # Main styles
│   └── js/
│       └── script.js          # JavaScript functionality
├── backend/
│   ├── process_admin_login.php
│   ├── process_login.php
│   └── process_registration.php
├── config/
│   └── config.php             # DB connection
├── user/
│   ├── dashboard.php
│   ├── generate_resume.php
│   ├── profile.php
│   └── recommendations.php
├── admin_login.php
├── index.php
├── login.php
├── logout.php
├── register.php
├── README.md
└── database_schema.sql
</pre>

<h2>Installation & Setup</h2>

<h3>1. Clone the Repository</h3>
<p>First, clone the project to your local machine using Git:</p>
<pre><code>git clone https://github.com/bishalranjit0606/Career-Guidance-System.git</code></pre>

<h3>2. Choose Your Setup Method</h3>
<p>You can run this project using either <strong>Docker</strong> (Recommended) or <strong>XAMPP</strong> (Manual Setup).</p>

<h2>Option A: Run with Docker (Easiest Way)</h2>
<p>You can run this project easily using Docker without setting up XAMPP manually.</p>

<h3>Prerequisites</h3>
<ul>
  <li>Make sure you have <strong>Docker Desktop</strong> installed and running.</li>
</ul>

<h3>Steps</h3>
<ol>
  <li>Open your terminal or command prompt.</li>
  <li>Navigate to the <code>docker</code> folder inside the project:
    <pre><code>cd docker</code></pre>
  </li>
  <li>Run the following command to start the app:
    <pre><code>docker-compose up -d --build</code></pre>
  </li>
  <li>Open your browser and go to:
    <a href="http://localhost:8080">http://localhost:8080</a>
  </li>
  <li>To view the database (phpMyAdmin), go to:
    <a href="http://localhost:8081">http://localhost:8081</a>
    <ul>
      <li><strong>Server:</strong> db</li>
      <li><strong>Username:</strong> root</li>
      <li><strong>Password:</strong> rootpassword</li>
    </ul>
  </li>
</ol>

<p>That's it! The database and everything else will be set up automatically.</p>

<h3>Stopping the App</h3>
<p>To stop the project, run:</p>
<pre><code>docker-compose down</code></pre>

<h2>Option B: Manual Setup with XAMPP</h2>
<p>If you prefer to run the project manually using XAMPP, follow these steps:</p>

<h3>1. Move Project Files</h3>
<ul>
  <li>Copy the <code>CareerGuidanceSystem</code> folder.</li>
  <li>Paste it into your XAMPP <code>htdocs</code> directory (usually <code>/Applications/XAMPP/xamppfiles/htdocs/</code> on Mac or <code>C:\xampp\htdocs\</code> on Windows).</li>
</ul>

<h3>2. Configure Database</h3>
<ul>
  <li>Start <strong>Apache</strong> and <strong>MySQL</strong> from the XAMPP Control Panel.</li>
  <li>Open your browser and go to <a href="http://localhost/phpmyadmin">http://localhost/phpmyadmin</a>.</li>
  <li>Create a new database named <code>career_guidance_db</code>.</li>
  <li>Click on the database name, then go to the <strong>Import</strong> tab.</li>
  <li>Choose the file <code>database/career_guidance_db.sql</code> from the project folder.</li>
  <li>Click <strong>Go</strong> to import the tables.</li>
</ul>

<h3>3. Configure Database Connection</h3>
<p>Ensure your <code>config/config.php</code> file is set to use the correct port (default is 3306). If you changed your MySQL port in XAMPP, update it in this file.</p>

<h3>4. Run the Website</h3>
<p>Open your browser and visit:</p>
<a href="http://localhost/CareerGuidanceSystem">http://localhost/CareerGuidanceSystem</a>
