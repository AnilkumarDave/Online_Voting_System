Online Voting System (Academic Project – BCA 6th Semester)

📅 Project Duration: 1 November 2014 – 31 December 2014 (≈ 2 months, Part-Time)  
Academic Year: 6th Semester (Bachelor of Computer Application)  
Institution: Shree S. V. Patel College of Computer Science & Business Management, Gujarat, India  
University: Veer Narmad South Gujarat University  
Mentor: Professor Dr. Ronal Vadiwala  

🏫 Project Overview
This project was originally built as part of my BCA coursework in 2014.

It is a web-based Online Voting System developed with PHP and MySQL.

Key features:

- User registration and login (voter and admin roles)
- Candidate and party management (admin)
- Voting system with one vote per user
- Election result calculation and display
- Charts and statistics for each constituency, district, and overall votes

In October 2025, the project was modernised for PHP 8.2 and updated database structure for portfolio purposes.

🎯 Project Objectives

- Digital voting simulation for demo purposes
- Admin and voter authentication with session management
- Manage candidates, constituencies, districts, parties, and votes in MySQL
- Generate real-time election results
- Visualise results with interactive charts using Chart.js

⚙️ Modernisation Note

| Originally Built | Modernised & Uploaded |
|------------------|------------------------|
| Aug–Sep 2014     | Oct 2025              |

Modern updates include:

- ✅ Improved login security using `password_hash()`
- ✅ Updated UI with responsive sidebar navigation
- ✅ Added attendance and grades modules
- ✅ Cleaned and normalised MySQL schema
- ✅ PHP 8.2 compatibility

🧩 System Features

👨‍💻 Admin Panel

- Manage candidates, parties, districts, constituencies  
- View election results per district, constituency, and overall  
- Charts for votes per candidate and party  

🧑‍💻 Voter Panel

- Registration and login  
- Cast vote (one vote per user)  
- View overall results  

📂 Sample Data

| Category    | Examples                                      |
|-------------|-----------------------------------------------|
| Parties     | BJP, INC, AAP, Independent                    |
| Districts   | Ahmedabad, Surat, Vadodara, Rajkot            |
| Constituencies | 8 sample constituencies                    |
| Candidates  | 15+ candidates across parties & constituencies|
| Users       | Admin + 3 demo voters                         |

💻 Project Files

| File                 | Description                  |
|----------------------|------------------------------|
| `index.php`          | User login                   |
| `register.php`       | User registration            |
| `vote.php`           | Voting page                  |
| `result.php`         | Election results             |
| `admin/index.php`    | Admin dashboard              |
| `admin/add_candidate.php`    | Add candidate (admin)   |
| `admin/edit_candidate.php`   | Edit candidate (admin)  |
| `admin/delete_candidate.php` | Delete candidate (admin)|
| `db.php`             | Database connection          |
| `style.css`          | Shared CSS styles            |
| `README.md`          | Project documentation        |

⚠️ Limitations

| Limitation                      | Description                       | Possible Improvement                          |
|---------------------------------|-----------------------------------|-----------------------------------------------|
| No real-world voter authentication | Users are demo accounts only    | Add ID/email/OTP verification                 |
| Single Admin Access             | Only admin can manage data        | Add multiple user roles                       |
| Local Deployment                | Works on XAMPP/WAMP only          | Deploy on cloud/remote server                 |
| Basic Security                  | Minimal CSRF/XSS protection       | Use prepared statements, HTTPS, stronger hardening |

🌟 Advantages

- ✅ Role-based access (Admin & Voter)
- ✅ Real-time vote calculation and visualisation
- ✅ Centralised management of candidates, parties, districts, and constituencies
- ✅ Easy deployment using XAMPP/WAMP
- ✅ Modernised version compatible with PHP 8.2

⏱️ Project Timeline

| Week | Task                                         |
|------|----------------------------------------------|
| Week 1 | Requirement gathering, database design    |
| Week 2 | Setup MySQL & PHP environment             |
| Week 3 | User registration & login functionality   |
| Week 4 | Candidate, party, constituency CRUD ops   |
| Week 5 | Voting logic & session management         |
| Week 6 | Election result calculation & charts      |
| Week 7 | Testing, debugging, sample data insertion |
| Week 8 | Final documentation, preparation, submission |

🔮 Future Scope

- Add email or OTP-based voter verification  
- Implement multi-user roles (Election Officer, Admin, Voter)  
- Advanced analytics dashboard for election results  
- Deploy online for real-time elections  
- Stronger security measures  

🚀 Quick Setup

```bash
# Clone repository
git clone https://github.com/AnilkumarDave/Online_Voting_System.git
cd Online_Voting_System
```

Import `database.sql` in phpMyAdmin.

Update `db.php` if credentials differ:

```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "online_voting_system";
$conn = new mysqli($servername, $username, $password, $dbname);
```

Start Apache & MySQL in XAMPP/WAMP and visit in a browser:

```text
http://localhost/Online_Voting_System/index.php
```

exit

## 🔧 Test Automation & QA (Java + Selenium + TestNG)

Alongside the core PHP + MySQL application, this project now includes a
separate **Java-based UI test suite** in the `/automation` folder.

The test suite demonstrates how I:

- Use **Java** with **TestNG** to structure end-to-end tests  
- Use **Selenium WebDriver** to automate browser interactions with the
  voting screens (login and casting a vote)  
- Apply a **Page Object Model** for maintainable test code  
- Use **Lombok** to keep page objects concise  
- Build and run tests with **Maven**, and integrate them into a simple
  **Jenkins** pipeline  

This reflects how a small academic project can be extended and treated
more like a real-world application with automated regression tests.

---

## 📜 Disclaimer

This project was developed for academic purposes in 2014 and modernised in 2025.  
All data is fictional and intended for educational/demo purposes only.

---

## ✨ Author

Name: Anilkumar Dave  
Email: daveanil48@gmail.com
