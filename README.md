# CyberSafe — Interactive Cybersecurity Awareness & Phishing Education Portal

A full-stack, responsive web application developed for college computer science engineering (CSE) curricula, specifically designed for university **Web Programming and Cybersecurity Laboratory** project evaluations.

Built using **HTML5, CSS3, vanilla JavaScript, PHP, and MySQL** without external frontend frameworks or heavy dependencies.

---

## 1. Project Abstract

In the modern digital landscape, human error remains the primary root cause for over 80% of successful enterprise and institutional cybersecurity breaches. While organizations invest heavily in firewalls, intrusion detection systems, and automated filters, threat actors routinely bypass these perimeter defenses by exploiting cognitive vulnerabilities—such as urgency, trust, and fear—through targeted phishing, deceptive social engineering, and malicious attachments.

**CyberSafe** is an interactive, educational web portal engineered to bridge the gap between abstract cybersecurity theory and practical defensive behavior for students and emerging developers. The portal features six structured learning modules, a safe interactive **Phishing Threat Simulator** that trains students to inspect spoofed headers and concealed URLs, an **Interactive 15-Question Assessment Engine** with instant feedback and score tracking, and a dynamic **Student Dashboard** that displays real analytics. Developed using pure vanilla web standards (HTML5, CSS3, ES6 JavaScript) and a secure server-side architecture (PHP PDO, prepared statements, CSRF protection, and MySQL), CyberSafe offers an intuitive user experience and an easily explainable codebase for university examination and viva voce defense.

---

## 2. Problem Statement

College students and young professionals are among the most frequent targets of modern cybercrime—including academic scholarship scams, fake exam fee portals, malicious software cracks, and unencrypted public Wi-Fi snooping. Existing cybersecurity education in academic curricula often suffers from:

1. **Theoretical Passivity**: Students memorize definitions (e.g., "what is a Trojan") without ever visually inspecting an actual deceptive email header or discovering lookalike URLs.
2. **High Barrier to Safe Experimentation**: Students cannot safely practice identifying real malware or live phishing attacks without risking system infection.
3. **Lack of Immediate Reinforcement**: Traditional static lecture slides do not evaluate whether a student can spot artificial urgency or recognize dangerous double file extensions in real time.
4. **Credential Re-use Risks**: Novice developers frequently hardcode credentials or fall victim to credential stuffing due to a lack of practical understanding of password entropy and authentication factors.

**CyberSafe** solves these issues by providing a zero-risk sandbox where students interact with realistic, safe scenarios and receive immediate pedagogical explanations.

---

## 3. Existing System vs. Proposed System

| Parameter | Existing System (Static College Tutorials) | Proposed System (**CyberSafe**) |
| :--- | :--- | :--- |
| **Interactivity** | Static text articles and PDF lecture notes | Hands-on phishing inbox simulator and interactive question stepper |
| **Threat Inspection** | Theoretical screenshots with arrows | Dynamic hoverable URL tooltips, header inspection, and red flag checklist |
| **Progress Persistence** | No persistence; read-only | Real-time database tracking of completed modules and assessment scores |
| **Assessment Quality** | Multiple-choice questions with only answer keys | 15 comprehensive MCQs with instant pedagogical rationale and post-quiz review |
| **Student Analytics** | None | Personalized dashboard with readiness tier badges and recommended topics |
| **Security Architecture** | Vulnerable demo code or unparameterized SQL | Industry-standard PHP PDO prepared statements, CSRF tokens, and password hashing |

---

## 4. Objectives of the Project

1. **Educate**: Deliver comprehensive, beginner-friendly instruction across 6 core cybersecurity disciplines (Phishing, Malware, Passwords, Social Engineering, Wi-Fi Safety, and MFA).
2. **Simulate**: Provide an interactive mock email client where students inspect realistic threats, discover concealed traps, and submit informed verdicts safely.
3. **Assess**: Test and reinforce student comprehension with an interactive 15-question multiple-choice examination featuring progress tracking and explanations.
4. **Quantify Progress**: Visualize student defense metrics, historical attempts, and readiness badges on a personalized student dashboard.
5. **Demonstrate Best Web Practices**: Exhibit clean code structure, semantic HTML5 markup, responsive CSS, client-side input validation, server-side parameterization, and secure session handling.

---

## 5. System Requirements

### Hardware Requirements
- **Processor**: Intel Core i3 / AMD Ryzen 3 or equivalent (minimum 1.5 GHz)
- **RAM**: 4 GB RAM (8 GB recommended for running local development stacks)
- **Storage**: 200 MB free hard drive space for application files and database
- **Display**: Responsive across 360px mobile viewports up to 1920x1080 desktop screens

### Software Prerequisites
- **Operating System**: Windows 10/11, macOS, or Linux (Ubuntu, Debian, Fedora)
- **Local Web Server Stack**: [XAMPP](https://www.apachefriends.org/) (Recommended for college labs), WampServer, Laragon, or PHP 7.4+ Built-in CLI Server
- **Database Engine**: MySQL 5.7+ or MariaDB 10.4+
- **Web Browser**: Any modern browser (Google Chrome, Mozilla Firefox, Microsoft Edge, Safari)

---

## 6. Technologies Used & Architectural Justification

### 1. HTML5 (Semantic Structure)
- Uses descriptive elements (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<aside>`, `<footer>`) rather than unsemantic `<div>` containers.
- Guarantees high accessibility (a11y), screen-reader readability, and compliance with college project evaluation guidelines.

### 2. CSS3 (Modern Vanilla Styling)
- **Zero Third-Party CSS Frameworks**: Built without Bootstrap or Tailwind so that styling rules, Flexbox, and CSS Grid can be explained during academic evaluations.
- **Cybersecurity Dark Theme**: Dark navy background (`#0b1120`, `#0f172a`) paired with electric cyan (`#00f2fe`) and shield emerald green (`#10b981`) accents.
- **Responsive Layout**: Adapts dynamically across mobile smartphones, tablets, and wide monitors using CSS media queries.

### 3. Vanilla JavaScript (ES6+)
- **Event-Driven DOM Manipulation**: Drives the single-question stepper, instant option verification, scenario tabs, and interactive red-flag checklist.
- **Asynchronous AJAX (`fetch`)**: Transmits progress data, quiz scores, and simulation attempts to backend endpoints in the background without full page reloads.
- **Resilient Fallback**: Stores progress in browser `localStorage` to ensure the platform functions even if the database is temporarily offline.

### 4. PHP (Hypertext Preprocessor)
- **Modular Templates**: Unified header (`includes/header.php`) and footer (`includes/footer.php`) enforce clean code reuse across all pages.
- **PHP Data Objects (PDO)**: Modern, vendor-agnostic database abstraction layer that enforces prepared statements with bound parameters to eliminate SQL Injection.
- **Security & Session Handling**: CSRF protection tokens via `$_SESSION['csrf_token']`, password hashing via `password_hash($pwd, PASSWORD_DEFAULT)` using bcrypt, and HTML entity escaping via `htmlspecialchars()`.

### 5. MySQL (Relational Database)
- **Normalized Relational Schema**: 6 structured tables (`users`, `topics`, `learning_progress`, `quiz_attempts`, `simulator_attempts`, `feedback`) linked with foreign keys and cascade rules.
- **InnoDB Storage Engine**: Guarantees ACID compliance, transactional integrity, and relational constraints.

---

## 7. Project Folder Structure

```text
cybersaafe/
├── index.php                   # Home Page: Hero banner, metrics snapshot, and feature spotlights
├── learn.php                   # Learning Center: 6 modular topics with "Mark as Completed" toggles
├── simulator.php               # Phishing Simulator: Safe interactive email client & red-flag inspector
├── quiz.php                    # Interactive Cyber Quiz: 15 MCQs with dynamic progression & review
├── dashboard.php               # Student Dashboard: Real statistics, readiness badges, and attempt logs
├── feedback.php                # Contact & Feedback Form: Server-side validated feedback collection
├── login.php                   # Student Access: Login, Registration, and one-click Guest Student mode
├── logout.php                  # Safe session destruction and redirection
├── includes/
│   ├── config.example.php      # Configuration template safe for Git repositories
│   ├── config.php              # Local database credentials and app constants
│   ├── db.php                  # PDO database connection handler with graceful offline fallback
│   ├── auth.php                # Session security, user context, guest initialization, and CSRF
│   ├── header.php              # Shared HTML head, dark navigation bar, and active link indicators
│   └── footer.php              # Shared footer, educational disclaimers, and toast container
├── assets/
│   ├── css/
│   │   └── style.css           # Core stylesheet (dark navy theme, cards, typography, animations)
│   └── js/
│       ├── main.js             # Mobile navigation drawer, global toast notifications, helpers
│       ├── learn.js            # Topic completion toggle via AJAX & modal management
│       ├── simulator.js        # 5 phishing scenarios, hotspot inspection, verdict evaluation
│       └── quiz.js             # 15-question interactive quiz engine, scoring math, detailed review
├── api/
│   ├── submit_quiz.php         # POST: Validates and persists quiz score in MySQL
│   ├── submit_feedback.php     # POST: Validates and saves contact feedback
│   ├── update_progress.php     # POST: Toggles topic completion status for active student
│   └── record_simulation.php   # POST: Records phishing simulator attempts and accuracy
├── database/
│   └── database.sql            # MySQL schema DDL & pre-seeded curriculum content
└── README.md                   # Full college documentation, setup guide, and viva Q&A
```

---

## 8. Step-by-Step Installation & Setup Guide

### Method 1: Using XAMPP (Standard College Lab Setup)

1. **Install XAMPP**:
   - Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/) (includes Apache, PHP, and MySQL).
2. **Move Project Folder**:
   - Copy or move the `cybersaafe` folder into your XAMPP web root directory:
     ```text
     C:\xampp\htdocs\cybersaafe
     ```
3. **Start Apache & MySQL**:
   - Open the **XAMPP Control Panel**.
   - Click **Start** next to **Apache**.
   - Click **Start** next to **MySQL**.
4. **Import Database Schema**:
   - Open your web browser and navigate to `http://localhost/phpmyadmin`.
   - Click **New** in the left sidebar and create a database named:
     ```text
     cybersafe_db
     ```
   - Click the **Import** tab at the top.
   - Click **Choose File** and select `C:\xampp\htdocs\cybersaafe\database\database.sql`.
   - Click **Import** (or **Go**) at the bottom. You will see success messages confirming that all 6 tables and seed data were created.
5. **Verify Configuration**:
   - Open `C:\xampp\htdocs\cybersaafe\includes\config.php`.
   - The default XAMPP credentials (`DB_HOST = 'localhost'`, `DB_USER = 'root'`, `DB_PASS = ''`) will work immediately without changes.
6. **Launch the Application**:
   - Open your web browser and visit:
     ```text
     http://localhost/cybersaafe/index.php
     ```

---

### Method 2: Running with PHP CLI Built-in Server

If you have PHP installed on your system PATH:

1. Open PowerShell or Command Prompt in the project folder:
   ```bash
   cd c:\cybersaafe
   ```
2. Start PHP's built-in web server:
   ```bash
   php -S localhost:8000
   ```
3. Open your browser and navigate to:
   ```text
   http://localhost:8000
   ```
*(Note: If MySQL is not running, the application will automatically enter **Standalone Offline Mode**, allowing you to test the interactive simulator and quiz without crashing).*

---

## 9. Functional Modules Description

### 1. Home Module (`index.php`)
- Welcoming hero section with clear call-to-action buttons ("Start Learning", "Launch Phishing Simulator", "Take Cyber Quiz").
- Dynamic statistics cards calculating genuine learner counts, completed modules, and average quiz scores directly from MySQL.
- Feature highlight cards for the four primary security vectors.

### 2. Learning Center Module (`learn.php`)
- Six structured curriculum modules:
  1. **Phishing Attacks & Email Spoofing**: Spear phishing, whaling, clone phishing, and domain inspection.
  2. **Malware & Ransomware Defense**: Trojans, keyloggers, ransomware encryption, and backup hygiene.
  3. **Password Security & Passkeys**: Entropy, passphrases, brute-force mitigation, and credential stuffing.
  4. **Social Engineering**: Pretexting, baiting, tailgating, and psychological manipulation.
  5. **Safe Browsing & Public Wi-Fi Risks**: Man-in-the-Middle (MitM) attacks, SSL certificates, and VPNs.
  6. **Multi-Factor Authentication (MFA)**: Knowledge, Possession, and Inherence factors; TOTP vs SMS.
- Modal dialogues for each topic providing technical overviews, realistic campus scenarios, warning signs checklists, and defense protocols.
- "Mark as Completed" button that asynchronously saves progress in MySQL and updates a real-time progress bar.

### 3. Phishing Simulator Module (`simulator.php`)
- An interactive simulated email client displaying 5 realistic scenarios (3 phishing attacks, 2 legitimate campus advisories).
- Interactive hover tooltips over hyperlinks revealing hidden destination URLs.
- Red-flag checklist helping students spot suspicious sender domains, artificial urgency, lookalike links, and disguised attachments (e.g., `.pdf.exe`).
- Dual verdict action buttons (`[Flag as Phishing]` vs `[Verify as Legitimate]`).
- Instant pedagogical debrief breaking down why the message was safe or malicious, citing specific clues and actionable defense rules.

### 4. Cyber Quiz Assessment Module (`quiz.php`)
- 15 comprehensive multiple-choice questions covering all six curriculum modules.
- Single-question stepper with an animated progress bar and running score indicator.
- Immediate feedback explaining the underlying security rationale upon selecting an option.
- Comprehensive post-quiz results screen displaying:
  - Total score and percentage dial.
  - Cybersecurity Readiness Tier badge (Master Cyber Defender, Security Practitioner, Trainee Defender).
  - Detailed review list of all 15 questions highlighting student answers, correct answers, and full explanations.
  - Automatic database score persistence with duplicate-submission protection.

### 5. Student Dashboard Module (`dashboard.php`)
- Student profile card with user avatar, registered email, and dynamic overall readiness percentage.
- 4 real metric cards (Modules Completed, Best Quiz Score, Total Quiz Attempts, Phishing Accuracy Rate).
- Historical quiz attempt log with timestamps, scores, percentages, and pass/review status.
- Curriculum completion matrix showing completed vs unfinished modules.
- Intelligent recommendation engine directing the student to their next unfinished topic.
- Clean empty states when accessed by brand new students.

### 6. Contact & Feedback Module (`feedback.php`)
- Semantic input form for student inquiries, bug reports, and scenario recommendations.
- Dual-layer validation (JavaScript client-side + PHP server-side).
- CSRF token protection and PDO prepared statements preventing SQL injection and XSS.

### 7. Student Authentication (`login.php`, `logout.php`)
- Secure registration and login using `password_hash()` (bcrypt) and `password_verify()`.
- **One-Click Guest Student Mode**: Evaluators and professors can test all features immediately without filling out registration forms, while still maintaining session-isolated progress tracking.

---

## 10. Test Cases & Verification Results

| Test Case ID | Feature / Component | Input / Action | Expected Result | Actual Result | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| **TC-01** | Navigation Bar | Click each navigation link across desktop and mobile drawer | Active page highlights with cyan underline; smooth page transition | Active page highlights accurately on all routes | **PASS** |
| **TC-02** | Mobile Responsiveness | View at 375px (mobile) and 768px (tablet) viewports | Layout stacks cleanly; hamburger drawer opens and closes smoothly | Full responsive adaptation without horizontal overflow | **PASS** |
| **TC-03** | Learning Center | Click "Mark as Done" on Module #1 | Button updates to "✓ Completed", card highlights green, progress bar advances to 17% | Progress bar updates immediately; saves to DB and localStorage | **PASS** |
| **TC-04** | Phishing Simulator | Inspect Case 1, hover over link, click "Flag as Phishing" | Destination URL reveals spoofed address; debrief displays "Correct Assessment" with clue breakdown | Clues display accurately; accuracy score updates to 100% | **PASS** |
| **TC-05** | Phishing Simulator | Submit "Flag as Phishing" on Case 2 (Legitimate Library Email) | Debrief displays "Incorrect Assessment" and explains why the email was authentic | Correct pedagogical feedback shown; scenario marked red | **PASS** |
| **TC-06** | Cyber Quiz Progression | Answer Q1 and click "Next Question" | Option button highlights green/red; explanation appears; progress advances to Question 2 of 15 | Smooth progression with accurate running score | **PASS** |
| **TC-07** | Cyber Quiz Scoring | Complete all 15 questions | Final score and percentage calculated accurately; detailed review list renders all 15 questions | Exact score calculated; recorded in database | **PASS** |
| **TC-08** | Anti-Duplicate Submit | Retake or submit quiz multiple times | Previous submission locks; prevents duplicate score inflation | Only single attempt logged per submission flow | **PASS** |
| **TC-09** | Feedback Form (Invalid) | Submit empty form or invalid email | Client and server validation block submission; displays clear error alert | Informative alert displays highlighting required fields | **PASS** |
| **TC-10** | Feedback Form (Valid) | Submit valid feedback with CSRF token | Success alert displays; record stored in `feedback` table | Stored securely with prepared statements | **PASS** |
| **TC-11** | Guest Access | Click "Continue as Guest Student" on Login page | Generates unique guest session ID; redirects directly to student dashboard | Instant dashboard access with isolated tracking | **PASS** |
| **TC-12** | Database Fallback | Open portal with MySQL server stopped | Header shows graceful standalone banner; quiz and simulator remain fully operational | Zero unhandled PHP fatal errors; graceful offline fallback | **PASS** |

---

## 11. Security Implementation Highlights

1. **SQL Injection Defense**: Every dynamic database operation uses PDO prepared statements with parameter binding (`$stmt->prepare(...)` and `$stmt->execute([...])`). Unsanitized variables are never concatenated directly into SQL query strings.
2. **Cross-Site Scripting (XSS) Defense**: All user-supplied inputs and database records rendered in HTML pass through `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`.
3. **Cross-Site Request Forgery (CSRF) Defense**: State-changing forms embed cryptographically strong random tokens (`bin2hex(random_bytes(32))`) validated via `hash_equals()`.
4. **Credential Security**: Passwords are never stored in plaintext. They are hashed using `password_hash($password, PASSWORD_DEFAULT)` which employs the secure bcrypt hashing algorithm with automatic salting.
5. **No Exposure of Secrets**: Credentials are kept within server-side PHP files (`includes/config.php`) and are never exposed in client-side HTML or JavaScript files.

---

## 12. University Viva Voce Q&A (Examiner Preparation)

### Q1: What is the main objective of your project CyberSafe?
> **Answer**: CyberSafe is an interactive cybersecurity awareness portal designed to educate college students about critical digital threats (phishing, malware, passwords, social engineering, Wi-Fi safety, and MFA). Unlike static websites, it provides an interactive phishing email inspection sandbox and a 15-question assessment quiz that tracks real learning progress in a MySQL database.

### Q2: Why did you choose PHP and MySQL instead of frontend frameworks like React or Angular?
> **Answer**: For a college Web Programming project, using standard HTML5, CSS3, vanilla JavaScript, PHP, and MySQL demonstrates a solid understanding of foundational web architecture: the Document Object Model (DOM), HTTP request-response lifecycles, session cookies, and relational database management. It avoids black-box framework abstractions and ensures fast, lightweight performance on standard university lab machines.

### Q3: How did you prevent SQL Injection in your PHP code?
> **Answer**: We utilized PHP Data Objects (PDO) with prepared statements. In a prepared statement, the SQL query structure is sent to the database engine first with placeholders (`?`). The user input is transmitted separately in the execute step. Because the database engine treats user data strictly as literal values rather than executable code, SQL injection is completely prevented.

### Q4: How does your phishing simulator help students detect malicious emails?
> **Answer**: The simulator presents five realistic, fictional scenarios. Students can hover over links to inspect the actual destination URL (detecting lookalike domains), examine the full sender address rather than just the display name, identify artificial urgency tactics, and spot dangerous disguised file extensions (such as `.pdf.exe`). After each decision, the system provides an immediate educational debrief.

### Q5: What is Cross-Site Scripting (XSS) and how is CyberSafe protected against it?
> **Answer**: XSS occurs when malicious scripts are injected into web pages viewed by other users. We protect CyberSafe by sanitizing all dynamic output using the `htmlspecialchars()` function with `ENT_QUOTES` and `UTF-8` encoding. This converts special characters like `<` and `>` into their safe HTML entities (`&lt;` and `&gt;`), ensuring the browser renders them as text rather than executing them as script tags.

### Q6: How does the "Guest Student" mode work?
> **Answer**: When an examiner or student clicks "Continue as Guest Student", PHP generates a session-backed identifier (`guest_[hash]`) and stores it in `$_SESSION`. This allows the user to complete quizzes and mark modules as completed with full dashboard tracking during a live lab demonstration without needing to create a temporary email or password.

### Q7: What are the three core authentication factors in Multi-Factor Authentication?
> **Answer**: 
> 1. *Something you know* (Knowledge factor: password or PIN).
> 2. *Something you have* (Possession factor: smartphone with TOTP authenticator app or hardware FIDO2 key).
> 3. *Something you are* (Inherence factor: biometrics such as fingerprint or facial recognition).

---

## 13. Limitations & Future Enhancements

### Current Limitations
- The phishing simulator currently includes 5 pre-configured educational scenarios.
- Email delivery is simulated locally; the application does not send live outgoing notification emails.
- Course progress is tracked on a per-user account or session basis without automated certificate PDF generation.

### Future Enhancements
1. **Dynamic Phishing Scenario Creator**: An administrative module enabling professors to draft and deploy new simulated phishing campaigns to class cohorts.
2. **Automated Completion Certificate**: Generating downloadable, digitally signed PDF certificates of completion with QR verification upon scoring over 80% on the quiz.
3. **SMS Smishing Simulator**: Adding mobile chat interfaces simulating SMS package delivery and OTP theft scams.
4. **Gamification & Leaderboard**: Adding campus-wide student leaderboards and achievement badges to incentivize security training.

---

## 14. Academic Declaration & Credits

- **Course**: B.E. Computer Science and Engineering — Web Programming & Security Project
- **Project Title**: CyberSafe — Interactive Cybersecurity Awareness Portal
- **Authors**: Student Engineering Team
- **Notice**: All educational scenarios, domains, and trademarks used in the simulations are fictional and intended solely for benign academic defense training.
