-- =============================================
-- Sandipani School Database
-- Database: school_sdb
-- =============================================

CREATE DATABASE IF NOT EXISTS school_sdb;
USE school_sdb;

-- =============================================
-- Table: users (Student / Staff login accounts)
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    full_name   VARCHAR(100),
    email       VARCHAR(100),
    role        ENUM('student','admin','teacher') DEFAULT 'student',
    class       VARCHAR(20),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin account (password: admin123)
INSERT INTO users (username, password, full_name, email, role)
VALUES ('admin', MD5('admin123'), 'Administrator', 'admin@sandipani.edu', 'admin');

-- Sample student accounts (password: student123)
INSERT INTO users (username, password, full_name, email, role, class) VALUES
('student1', MD5('student123'), 'Rahul Sharma',  'rahul@sandipani.edu',  'student', 'Class 10'),
('student2', MD5('student123'), 'Priya Patel',   'priya@sandipani.edu',  'student', 'Class 9'),
('student3', MD5('student123'), 'Aarav Mehta',   'aarav@sandipani.edu',  'student', 'Class 8');

-- =============================================
-- Table: applications (New admission applications)
-- =============================================
CREATE TABLE IF NOT EXISTS applications (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    dob         DATE NOT NULL,
    gender      ENUM('Male','Female','Other') NOT NULL,
    class       VARCHAR(20) NOT NULL,
    parent      VARCHAR(100) NOT NULL,
    phone       VARCHAR(15) NOT NULL,
    address     TEXT NOT NULL,
    status      ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    applied_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample application data
INSERT INTO applications (name, dob, gender, class, parent, phone, address, status) VALUES
('Sneha Verma',  '2013-05-10', 'Female', 'Class 5', 'Ramesh Verma',  '9876543210', '12 Lake View, Pune',    'Approved'),
('Karan Joshi',  '2012-08-22', 'Male',   'Class 6', 'Suresh Joshi',  '9876543211', '34 Hill Road, Mumbai',  'Pending'),
('Ananya Singh', '2014-02-14', 'Female', 'Class 4', 'Vikram Singh',  '9876543212', '56 Park Lane, Nashik',  'Pending');

-- =============================================
-- Table: contacts (Contact form messages)
-- =============================================
CREATE TABLE IF NOT EXISTS contacts (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    message     TEXT NOT NULL,
    is_read     TINYINT(1) DEFAULT 0,
    sent_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample contact messages
INSERT INTO contacts (name, email, message) VALUES
('Arun Kumar',   'arun@gmail.com',   'I would like to know more about the admission process.'),
('Meena Desai',  'meena@gmail.com',  'What are the school timings for Class 10?'),
('Rajesh Nair',  'rajesh@gmail.com', 'Please share the fee structure for this year.');

-- =============================================
-- Table: announcements
-- =============================================
CREATE TABLE IF NOT EXISTS announcements (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    content     TEXT NOT NULL,
    posted_by   VARCHAR(100) DEFAULT 'Admin',
    posted_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO announcements (title, content, posted_by) VALUES
('Annual Sports Day 2026',       'Annual Sports Day will be held on 15th April 2026. All students must participate.', 'Admin'),
('Exam Schedule Released',       'Mid-term examination schedule has been uploaded. Please check the Examination page.',  'Admin'),
('School Closed – Holi Holiday', 'School will remain closed on 14th March 2026 due to Holi celebrations.',              'Admin'),
('New e-Learning Portal',        'Students can now access study materials on the E-Learning page after login.',          'Admin');

-- =============================================
-- Table: results (Student exam results)
-- =============================================
CREATE TABLE IF NOT EXISTS results (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    student_id  INT NOT NULL,
    subject     VARCHAR(100) NOT NULL,
    marks       INT NOT NULL,
    total_marks INT NOT NULL DEFAULT 100,
    exam_type   VARCHAR(50) DEFAULT 'Mid-Term',
    exam_year   YEAR DEFAULT (YEAR(CURDATE())),
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO results (student_id, subject, marks, total_marks, exam_type) VALUES
(2, 'Mathematics',        85, 100, 'Mid-Term'),
(2, 'Science',            78, 100, 'Mid-Term'),
(2, 'English',            90, 100, 'Mid-Term'),
(2, 'Social Studies',     72, 100, 'Mid-Term'),
(2, 'Hindi',              88, 100, 'Mid-Term'),
(3, 'Mathematics',        92, 100, 'Mid-Term'),
(3, 'Science',            88, 100, 'Mid-Term'),
(3, 'English',            76, 100, 'Mid-Term'),
(3, 'Social Studies',     80, 100, 'Mid-Term'),
(3, 'Hindi',              84, 100, 'Mid-Term');

-- =============================================
-- Table: fees (Fee payment records)
-- =============================================
CREATE TABLE IF NOT EXISTS fees (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    student_id      INT NOT NULL,
    amount          DECIMAL(10,2) NOT NULL,
    fee_type        VARCHAR(100) DEFAULT 'Tuition Fee',
    payment_method  VARCHAR(50)  DEFAULT 'Cash',
    status          ENUM('Paid','Pending','Overdue') DEFAULT 'Pending',
    due_date        DATE,
    paid_date       DATE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO fees (student_id, amount, fee_type, payment_method, status, due_date, paid_date) VALUES
(2, 5000.00, 'Tuition Fee', 'Online',    'Paid',    '2026-01-10', '2026-01-08'),
(2, 500.00,  'Sports Fee',  'Cash',      'Paid',    '2026-01-10', '2026-01-09'),
(2, 5000.00, 'Tuition Fee', 'Online',    'Pending', '2026-04-10', NULL),
(3, 5000.00, 'Tuition Fee', 'Cash',      'Paid',    '2026-01-10', '2026-01-07'),
(3, 5000.00, 'Tuition Fee', 'Online',    'Overdue', '2026-03-10', NULL);

-- =============================================
-- Table: assignments
-- =============================================
CREATE TABLE IF NOT EXISTS assignments (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    class       VARCHAR(20)  NOT NULL,
    subject     VARCHAR(100) NOT NULL,
    title       VARCHAR(200) NOT NULL,
    description TEXT,
    due_date    DATE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO assignments (class, subject, title, description, due_date) VALUES
('Class 10', 'Mathematics',  'Algebra Assignment',    'Solve exercises 5.1 to 5.5 from the textbook.',   '2026-04-10'),
('Class 10', 'Science',      'Lab Report - Acids',    'Write a detailed report on the acid-base experiment performed in lab.', '2026-04-12'),
('Class 9',  'English',      'Essay Writing',         'Write a 500-word essay on "My Future Goals".',    '2026-04-08'),
('Class 9',  'Social Studies','Map Work',             'Draw and label the political map of India.',       '2026-04-15'),
('Class 8',  'Mathematics',  'Geometry Problems',     'Solve all problems in Chapter 6 – Triangles.',    '2026-04-11');

-- =============================================
-- Table: timetable
-- =============================================
CREATE TABLE IF NOT EXISTS timetable (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    class       VARCHAR(20)  NOT NULL,
    day         ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
    period      INT NOT NULL,
    subject     VARCHAR(100) NOT NULL,
    teacher     VARCHAR(100),
    start_time  TIME,
    end_time    TIME
);

INSERT INTO timetable (class, day, period, subject, teacher, start_time, end_time) VALUES
('Class 10', 'Monday',    1, 'Mathematics',   'Mr. Patil',    '08:00:00', '08:45:00'),
('Class 10', 'Monday',    2, 'Science',        'Mrs. Sharma',  '08:45:00', '09:30:00'),
('Class 10', 'Monday',    3, 'English',        'Ms. Gupta',    '09:45:00', '10:30:00'),
('Class 10', 'Monday',    4, 'Social Studies', 'Mr. Kulkarni', '10:30:00', '11:15:00'),
('Class 10', 'Tuesday',   1, 'Hindi',          'Mrs. Joshi',   '08:00:00', '08:45:00'),
('Class 10', 'Tuesday',   2, 'Mathematics',   'Mr. Patil',    '08:45:00', '09:30:00'),
('Class 10', 'Tuesday',   3, 'Computer',       'Mr. Mehta',    '09:45:00', '10:30:00'),
('Class 10', 'Tuesday',   4, 'English',        'Ms. Gupta',    '10:30:00', '11:15:00');

-- =============================================
-- DONE
-- =============================================
