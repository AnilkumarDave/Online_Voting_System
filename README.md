🗳️ Online Voting System (Academic Project – BCA 6th Semester)

📅 Project Duration: 1 November 2014 – 31 December 2014 (≈ 2 months, Part-Time)
Academic Year: 6th Semester (Bachelor of Computer Application)
Institution: Shree S. V. Patel College of Computer Science & Business Management, Gujarat, India
University: Veer Narmad South Gujarat University
Mentor: Professor Dr. Ronal Vadiwala

🏫 Project Overview

This repository contains a reconstructed version of my 6th-semester academic project for portfolio purposes.
The project simulates an online voting system with the following key modules:
User registration and login (voter and admin roles)
Candidate and party management (admin)
Voting system with one vote per user
Election result calculation and display
Charts and statistics for each constituency, district, and overall votes
In October 2025, the project was modernised for PHP 8.2 compatibility and updated database structure.

🎯 Objectives
Build a functional online voting system for demonstration purposes
Implement admin and voter authentication with session management
Store and manage candidates, constituencies, districts, parties, and votes in MySQL
Generate real-time results, including overall, district-wise, and constituency-wise results
Visualize results using charts (Chart.js)

⚙️ Modernisation Note
Originally Built	Modernised & Uploaded
Aug–Sep 2014	Oct 2025

Modern updates include:
Improved login security using password_hash()
Updated UI with responsive sidebar navigation
Added attendance and grades modules
Cleaned and normalised MySQL schema
Updated for PHP 8.2 compatibility

🧩 System Features
👨‍💻 Admin Panel
Manage candidates (add, edit, delete)
Manage parties, districts, constituencies
View election results per district, constituency, and overall
Charts for votes per candidate and party

🧑‍💻 Voter Panel
Registration and login
Cast vote (one vote per user)
View overall results (after voting)

📂 Sample Data
Category	Examples
Parties	BJP, INC, AAP, Independent
Districts	Ahmedabad, Surat, Vadodara, Rajkot
Constituencies	8 sample constituencies
Candidates	15+ across parties and constituencies
Users	Admin + 3 demo voters
Votes	Pre-inserted for demonstration

💻 Project Files
File	Description
index.php	User login
register.php	User registration
vote.php	Voting page
result.php	Election results
admin/index.php	Admin dashboard
admin/add_candidate.php	Add candidate (admin)
admin/edit_candidate.php	Edit candidate (admin)
admin/delete_candidate.php	Delete candidate (admin)
db.php	Database connection
style.css	Shared CSS styles
README.md	Project documentation

⚠️ Limitations
Limitation	Description
No real-world voter authentication	Users are demo accounts only
Limited to demo data	Not suitable for real elections
Basic security	Plaintext passwords, minimal CSRF/XSS protection

🔭 Future Scope
Add email verification and OTP-based voter authentication
Implement responsive UI for mobile devices
Add audit logs for votes
Enhance security with prepared statements and hashing (bcrypt)
Deploy as a live web application

⏱️ Timeline (1 Nov – 31 Dec 2014)
Week	Task
Week 1	Requirement gathering, database design
Week 2	Setup MySQL & PHP environment
Week 3	User registration & login functionality
Week 4	Candidate, party, constituency CRUD operations
Week 5	Voting logic & session management
Week 6	Election result calculation & charts
Week 7	Testing, debugging, sample data insertion
Week 8	Final documentation, preparation, submission

🧠 Advantages / Learning Outcomes
Hands-on experience with PHP, MySQL, and JavaScript
Implementation of role-based access (admin & voter)
Real-time result calculation and visualization
Understanding relational database design and foreign key constraints

🚀 Quick Setup
# Clone repository
git clone https://github.com/AnilkumarDave/Online_Voting_System.git
cd Online_Voting_System

# Import database.sql in phpMyAdmin
# Update db.php if credentials differ
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting_system";
$conn = new mysqli($servername, $username, $password, $dbname);

# Start Apache & MySQL via XAMPP/WAMP
# Open in browser
http://localhost/Online_Voting_System/index.php

📜 Disclaimer
This project was originally developed as part of academic coursework in 2014 and later modernised in 2025.
All data used is fictional and created for educational purposes only.

✨ Author
Name: Anilkumar Dave
Email: daveanil48@gmail.com
