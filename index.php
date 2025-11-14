<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Career Guidance System</title>
    <style>
        /* Define a simple color palette */
        :root {
            --primary-color: #007bff; /* A simple, professional blue */
            --secondary-color: #6c757d; /* Standard grey */
            --background-light: #f8f9fa; /* Off-white for body */
            --background-medium: #e9ecef; /* Light grey for sections/navbar */
            --text-dark: #212529;
            --border-color: #ced4da;
        }

        /* Basic styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Slightly better font */
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 30px 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            margin: 0;
        }

        .header p {
            font-size: 16px;
        }

        /* Navigation */
        .navbar {
            background-color: var(--background-medium);
            border-bottom: 1px solid var(--border-color);
            padding: 10px;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            display: inline;
            margin: 0 15px;
        }

        .navbar a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border: 1px solid transparent;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .navbar a:hover {
            background-color: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        /* Main Content Layout */
        .main-content {
            max-width: 960px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .section {
            background-color: white;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
            border-radius: 6px; /* A little rounding */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Very light shadow */
            text-align: center;
        }

        h2 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 5px;
            display: inline-block;
            font-size: 24px;
        }

        /* Features Grid - Simple layout using flex for wrapping */
        .features-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .feature-item {
            width: 100%;
            max-width: 300px;
            border: 1px solid var(--border-color);
            padding: 15px;
            background-color: #fefefe;
            border-radius: 4px;
            text-align: left;
        }

        .feature-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background-color: var(--primary-color); /* Colored circle/square */
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 4px;
            float: left;
            margin-right: 15px;
        }

        .feature-item h3 {
            margin-top: 0;
            font-size: 18px;
            color: var(--text-dark);
        }

        .feature-item p {
            font-size: 14px;
            margin-top: 5px;
            color: var(--secondary-color);
        }
        
        /* Clear float on item */
        .feature-item::after {
            content: "";
            display: table;
            clear: both;
        }

        /* CTA Buttons */
        .cta-buttons {
            margin-top: 25px;
        }

        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 8px;
            display: inline-block;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268; /* Darker grey on hover */
        }

        /* Footer */
        .footer {
            background-color: var(--text-dark);
            color: white;
            padding: 15px;
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
        }

        /* Mobile Adjustments */
        @media (max-width: 600px) {
            .feature-item {
                max-width: 100%;
            }
            .navbar li {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome to Career Guidance System</h1>
        <p>Your Path to a Brighter Future</p>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">User Login</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="admin_login.php">Admin Login</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <section class="section hero-section">
            <h2>Discover Your Ideal Career!</h2>
            <p>
                Our Career Guidance System helps you explore career paths, enhance your skills, and predict your potential for success.
                Take our quiz, list your skills, and let our intelligent algorithms guide you.
            </p>
        </section>

        <section class="section">
            <h2>Our Features</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">1</div>
                    <h3>Personalized Recommendations</h3>
                    <p>Get tailored career suggestions based on your unique skills, interests, and quiz answers.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">2</div>
                    <h3>Skill Enhancement</h3>
                    <p>Identify complementary skills to learn, boosting your profile for your desired career.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">3</div>
                    <h3>Success Prediction</h3>
                    <p>See a compatibility score for various careers, helping you choose with confidence.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">4</div>
                    <h3>Instant Resume Generation</h3>
                    <p>Generate a basic resume with your profile information and skills in just a few clicks.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">5</div>
                    <h3>Course Suggestions</h3>
                    <p>Receive curated course recommendations tailored to your skill enhancement needs.</p>
                </div>
            </div>
        </section>

        <section class="section cta-section">
            <p>Ready to start your journey?</p>
            <div class="cta-buttons">
                <a href="register.php" class="btn btn-primary">Register Now</a>
                <a href="login.php" class="btn btn-secondary">Login</a>
            </div>
        </section>
    </main>

</body>
</html>