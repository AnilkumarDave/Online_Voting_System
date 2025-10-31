📝 Online Voting System (Academic Project – BCA 6th Semester)

Author: Anilkumar Dave
Program: Bachelor of Computer Application (BCA)
Duration: 1 Nov 2014 – 31 Dec 2014 (≈ 2 months, part-time)
Academic Year: 6th Semester
Institution: Shree S. V. Patel College of Computer Science & Business Management, Gujarat, India
University: Veer Narmad South Gujarat University
Mentor: Professor Dr. Ronal Vadiwala

🚀 Overview

This project simulates an online voting system for educational and portfolio purposes. It includes:

User registration & login: Voter and admin roles

Candidate & party management: Admin can add/edit/delete

Voting system: One vote per user

Election results: Real-time calculation and display

Visualizations: Charts for constituency, district, and overall votes

⚙️ Modernisation Note

Originally built: Aug–Sep 2014

Modernised & uploaded: Oct 2025

Updates:

Improved login security using password_hash()

Responsive sidebar navigation UI

Added attendance & grades modules

Cleaned & normalised MySQL schema

PHP 8.2 compatibility

📂 Project Files
File	Description
index.php	User login page
register.php	User registration page
vote.php	Voting page
result.php	Election results (overall, district, constituency)
admin/index.php	Admin dashboard
admin/add_candidate.php	Add candidate (admin)
admin/edit_candidate.php	Edit candidate (admin)
admin/delete_candidate.php	Delete candidate (admin)
db.php	Database connection
style.css	Shared CSS styles
README.md	Project documentation
🔎 Key Features
Admin Panel

Candidate management (add/edit/delete)

Party, district, and constituency management

View election results (district/constituency/overall)

Charts per candidate and party

Voter Panel

Registration & login

Cast vote (one vote per user)

View overall results

📊 Sample Data

Parties: BJP, INC, AAP, Independent

Districts: Ahmedabad, Surat, Vadodara, Rajkot

Constituencies: 8 sample constituencies

Candidates: 15+ across parties & constituencies

Users: Admin + 3 demo voters

Votes: Pre-inserted for demonstration

🧩 System Methodology

Database: Relational tables for users, candidates, votes, parties, districts, constituencies

Backend: PHP + MySQL (CRUD & voting logic)

Frontend: HTML, CSS, JavaScript, Chart.js

Result calculation: Overall, district-wise, and constituency-wise percentages

🛠️ Tech Stack

PHP 8.2+

MySQL / MariaDB

HTML, CSS, JavaScript

Chart.js

⚠️ Limitations

No real-world voter authentication (e.g., ID verification)

Only demo data, not suitable for real elections

Basic security: plaintext passwords, minimal CSRF/XSS protection

🔭 Future Scope

Email verification & OTP-based voter authentication

Responsive UI for mobile devices

Vote audit logs

Stronger security (prepared statements, bcrypt)

Deploy as a live web application

📅 Timeline (1 Nov – 31 Dec 2014)
Week	Tasks
Week 1	Requirement gathering, database design
Week 2	Setup MySQL & PHP environment
Week 3	User registration & login functionality
Week 4	Candidate/party/constituency CRUD operations
Week 5	Voting logic & session management
Week 6	Election result calculation & charts
Week 7	Testing, debugging, sample data insertion
Week 8	Final documentation & submission
🧠 Lessons Learned

Hands-on experience with PHP, MySQL, and JavaScript

Role-based access implementation (admin & voter)

Real-time results & data visualization

Understanding relational database design and foreign key constraints

🚀 Quickstart
# Clone repo
git clone https://github.com/AnilkumarDave/Online_Voting_System.git
cd Online_Voting_System

# Open in XAMPP/WAMP
# Import database.sql via phpMyAdmin

# Update db.php if credentials differ
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting_system";
$conn = new mysqli($servername, $username, $password, $dbname);

# Start Apache & MySQL
# Visit in browser
http://localhost/Online_Voting_System/index.php
