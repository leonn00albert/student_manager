## Module 1 Project

Create a web application to manage students. Each student should have the following: a registration number, name, grade, and classroom (it can be static classrooms).
The user should be able to:
Add a new student;
List the students;
Update a student;
Delete a student.
Restrictions:
The grade should be a number from 0 to 10;
Duplicate registration numbers are NOT allowed.
DEADLINE: 01.06.2023


---
Backend: 

I am using my own build Artemis framework to do the routing which also includes a JSON based Database 

Frontend:
everything is pure javascript 
I used a special bootstrap theme found one https://bootswatch.com/ 


## Install


```bash 
git clone https://github.com/leonn00albert/student_manager.git
cd student_manager
composer install
php -S localhost:8000 .\server.php

```

## Usage

Features 

Create 
 - Student -> create new student entry 
 - Classroom -> create a new classroom entry 
Tools 
 - Create PDF -> get a pdf file with student data
 - Logs -> go logs of activity 
 - Seed data -> create data 0 - 10 entries
 - clear data -> clear all student and class room data



result : <br>

Students classroom and progress

[![m2-student-manager-1.jpg](https://i.postimg.cc/bwK8BCrj/m2-student-manager-1.jpg)](https://postimg.cc/k2FkVyWj)

Students Chat

[![m2-student-manager-2.jpg](https://i.postimg.cc/WtL6KcBk/m2-student-manager-2.jpg)](https://postimg.cc/q6w3hSMJ)

Teacher reports
[![m2-student-manager-4.jpg](https://i.postimg.cc/02K9015C/m2-student-manager-4.jpg)](https://postimg.cc/N5YhQVHy)

Teacher classroom management
[![m2-student-manager-5.jpg](https://i.postimg.cc/vm2QvYn3/m2-student-manager-5.jpg)](https://postimg.cc/wtJ8qd0m)

Admin CMS for homepage
[![m2-student-manager-6.jpg](https://i.postimg.cc/tRxXhH4N/m2-student-manager-6.jpg)](https://postimg.cc/kD73mz82)

