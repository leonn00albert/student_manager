-- Create Students table
CREATE TABLE Students (
  student_id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  date_of_birth DATE,
  gender VARCHAR(10),
  contact_number VARCHAR(20),
  email VARCHAR(255),
  address VARCHAR(255)
);

-- Create Courses table
CREATE TABLE Courses (
  course_id INT PRIMARY KEY AUTO_INCREMENT,
  course_name VARCHAR(255)
);

-- Create Enrollments table
CREATE TABLE Enrollments (
  enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  course_id INT,
  enrollment_date DATE,
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Create Attendance table
CREATE TABLE Attendance (
  attendance_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  course_id INT,
  date DATE,
  status VARCHAR(10),
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Create Grades table
CREATE TABLE Grades (
  grade_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  course_id INT,
  assignment_name VARCHAR(255),
  score DECIMAL(5,2),
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Create Messages table
CREATE TABLE Messages (
  message_id INT PRIMARY KEY AUTO_INCREMENT,
  sender_id INT,
  recipient_id INT,
  subject VARCHAR(255),
  message TEXT,
  date DATETIME,
  FOREIGN KEY (sender_id) REFERENCES Students(student_id),
  FOREIGN KEY (recipient_id) REFERENCES Students(student_id)
);

-- Create Library table
CREATE TABLE Library (
  book_id INT PRIMARY KEY AUTO_INCREMENT,
  book_title VARCHAR(255),
  author VARCHAR(255),
  publication_date DATE,
  available VARCHAR(3)
);

-- Create Borrowings table
CREATE TABLE Borrowings (
  borrowing_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  book_id INT,
  borrow_date DATE,
  return_date DATE,
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (book_id) REFERENCES Library(book_id)
);

-- Create Fees table
CREATE TABLE Fees (
  fee_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  description VARCHAR(255),
  amount DECIMAL(8,2),
  payment_status VARCHAR(10),
  FOREIGN KEY (student_id) REFERENCES Students(student_id)
);

-- Create Exams table
CREATE TABLE Exams (
  exam_id INT PRIMARY KEY AUTO_INCREMENT,
  course_id INT,
  exam_name VARCHAR(255),
  exam_date DATE,
  FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Create Results table
CREATE TABLE Results (
  result_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  exam_id INT,
  score DECIMAL(5,2),
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (exam_id) REFERENCES Exams(exam_id)
);

CREATE TABLE Teachers (
  teacher_id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  contact_number VARCHAR(20),
  email VARCHAR(255)
);

-- Create Classrooms table
CREATE TABLE Classrooms (
  classroom_id INT PRIMARY KEY AUTO_INCREMENT,
  classroom_name VARCHAR(255),
  teacher_id INT,
  FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id)
);



ALTER TABLE Courses
ADD COLUMN teacher_id INT,
ADD FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id);

-- Update Attendance table
ALTER TABLE Attendance
ADD COLUMN classroom_id INT,
ADD FOREIGN KEY (classroom_id) REFERENCES Classrooms(classroom_id);

-- Update Grades table
ALTER TABLE Grades
ADD COLUMN classroom_id INT,
ADD FOREIGN KEY (classroom_id) REFERENCES Classrooms(classroom_id);

-- Update Exams table
ALTER TABLE Exams
ADD COLUMN classroom_id INT,
ADD FOREIGN KEY (classroom_id) REFERENCES Classrooms(classroom_id);

ALTER TABLE Students
ADD COLUMN classroom_id INT,
ADD FOREIGN KEY (classroom_id) REFERENCES Classrooms(classroom_id);


CREATE TABLE Admins (
  admin_id INT PRIMARY KEY AUTO_INCREMENT,
  permissions VARCHAR(255),
  department VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  contact_email VARCHAR(255),
  contact_phone VARCHAR(20),
  address VARCHAR(255),
  city VARCHAR(255),
  country VARCHAR(255),
  password VARCHAR(255),
  type ENUM('student', 'teacher', 'admin'),
  teacher_id INT,
  admin_id INT,
  student_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login TIMESTAMP NULL,
  last_login_ip VARCHAR(45),
  FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id),
  FOREIGN KEY (admin_id) REFERENCES Admins(admin_id),
  FOREIGN KEY (student_id) REFERENCES Students(student_id)
);