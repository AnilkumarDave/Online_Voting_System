Online Voting System (Academic Project – BCA 6th Semester)

Author: Anilkumar Dave
Program: Bachelor of Computer Application (BCA)
Duration: 1 November 2014 – 31 December 2014 (≈ 2 months, part-time)
Academic Year: 6th Semester
Institution: Shree S. V. Patel College of Computer Science & Business Management, Gujarat, India
University: Veer Narmad South Gujarat University
Mentor: Professor Dr. Ronal Vadiwala

Overview

This repository contains a reconstructed version of my 6th-semester academic project, rebuilt for portfolio and educational purposes. The original project was submitted as a mini-project during my BCA program.

All data used in this project (users, candidates, votes, parties) are fictitious and intended solely for demonstration and testing.

The project simulates an online voting system with the following key modules:

User registration and login (voter and admin roles)

Candidate and party management (admin)

Voting system with one vote per user

Election result calculation and display

Charts and statistics for each constituency, district, and overall votes

⚙️ Modernisation Note

Originally built: Aug–Sep 2014 (Academic project)

Modernised & uploaded: Oct 2025

Modern updates include:

Improved login security using password_hash()

Updated UI with responsive sidebar navigation

Added attendance and grades modules

Cleaned and normalised MySQL schema

Updated for PHP 8.2 compatibility

Objectives

Build a functional online voting system for demonstration purposes.

Implement admin and voter authentication with session management.

Store and manage candidates, constituencies, districts, parties, and votes in MySQL.

Generate real-time results, including overall leading party, district-wise, and constituency-wise results.

Visualize results using charts (Chart.js).

High-Level Methodology

Database design: Relational structure with tables for users, candidates, votes, parties, districts, and constituencies.

Backend: PHP + MySQL for CRUD operations and voting logic.

Frontend: HTML, CSS, JavaScript, and Chart.js for result visualization.

Result calculation: Overall party votes, district/constituency candidate votes, and percentages.

System Features
Admin Panel

Manage candidates (add, edit, delete)

Manage parties, districts, constituencies

View election results per district, constituency, and overall

Charts for votes per candidate and party

Voter Panel

Registration and login

Cast vote (one vote per user)

View overall results (after voting)

Sample Data

Parties: BJP, INC, AAP, Independent

Districts: Ahmedabad, Surat, Vadodara, Rajkot

Constituencies: 8 sample constituencies

Candidates: 15+ candidates across parties and constituencies

Users: Admin + 3 demo voters

Votes: Sample votes pre-inserted for demonstration

Project Files

index.php – User login

register.php – User registration

vote.php – Voting page

result.php – Election results (overall, district, constituency)

admin/index.php – Admin dashboard

admin/add_candidate.php – Add candidate (admin)

admin/edit_candidate.php – Edit candidate (admin)

admin/delete_candidate.php – Delete candidate (admin)

db.php – Database connection

style.css – Shared CSS styles

README.md – Project documentation

Disclaimer

All database content is self-created for demo and testing purposes.

This project is for educational/demo purposes only. Passwords are stored in plain text, and protections against CSRF, XSS, and SQL injection are minimal.

Do not use this system for real elections.

Advantages / Learning Outcomes

Hands-on experience with PHP, MySQL, and JavaScript

Implementation of role-based access (admin & voter)

Real-time result calculation and visualization

Understanding relational database design and foreign key constraints

Limitations

No real-world voter authentication (e.g., ID verification)

Limited to demo data; not suitable for real elections

Security measures are basic for academic purposes

Future Scope

Add email verification and OTP-based voter authentication

Implement responsive UI for mobile devices

Add audit logs for votes

Enhance security with prepared statements and hashing (bcrypt)

Deploy as a web application with live database

Timeline (1 Nov – 31 Dec 2014)
Week	Tasks
Week 1 (Nov 1–7)	Requirement gathering, database design
Week 2 (Nov 8–14)	Setup MySQL, PHP environment
Week 3 (Nov 15–21)	User registration & login functionality
Week 4 (Nov 22–30)	Candidate, party, constituency CRUD operations
Week 5 (Dec 1–7)	Voting logic & session management
Week 6 (Dec 8–14)	Election result calculation & charts
Week 7 (Dec 15–21)	Testing, debugging, sample data insertion
Week 8 (Dec 22–31)	Final documentation, preparation, submission
Conclusion

The Online Voting System demonstrates the design and implementation of a simple, secure, and functional voting platform. It provides role-based access, real-time results, and a clear relational database structure, suitable for educational purposes. The modernised version ensures compatibility with current PHP versions and includes enhanced security and UI improvements.

Quick Setup – Online Voting System
Requirements

Web Server: XAMPP, WAMP, or LAMP (PHP ≥ 7.0, MySQL/MariaDB)

Browser: Chrome, Firefox, Edge, etc.

Code Editor: VS Code, Sublime Text, PHPStorm

1. Clone Repository
git clone https://github.com/yourusername/online-voting-system.git
cd online-voting-system

2. Database Setup

Open phpMyAdmin (or any MySQL client).

Create a database:

CREATE DATABASE online_voting_system;


Import database.sql from the repository to create tables and sample data.

Update db.php if your DB credentials differ:

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_voting_system";
$conn = new mysqli($servername, $username, $password, $dbname);

3. Configure Admin User

Default admin credentials:

Username: admin

Password: admin123

Admin role is set as admin in the users table.

Additional users or voters can be added via SQL or registration form.

4. Launch Project

Start Apache and MySQL in XAMPP/WAMP.

Place the project folder in htdocs (XAMPP) or www (WAMP).

Open browser and visit:

http://localhost/online-voting-system/index.php

Notes

Charts: Uses Chart.js for vote visualization.

Data: All sample users, candidates, votes are self-created for demo purposes.

Security: This project is for educational/demo purposes only.