## Module 2 Project
Update the module 1 project to use the MySQL database instead of the filesystem.

Create a new page to manage (add, read, update, and delete) the classrooms. The classrooms should be listed on the page form to insert/update students (the table of students should contain the classroom ID - one-to-many).

    Add a report that shows the students by classroom.
    Add a login page

---
Backend: 

I am using my own build Artemis framework to do the routing which also includes a JSON based Database 

Frontend:
everything is pure javascript 
I used a special bootstrap theme found one https://bootswatch.com/ 


## Install

Import the sql from the database.sql file into your mysql / mariadb app

```bash 
git clone https://github.com/leonn00albert/student_manager.git
cd student_manager
composer install
php -S localhost:8000 .\server.php

```

Test accounts

student@test.com 
teacher@test.com 
admin@test.com 

PW:



## Features
**Students**
 - Can enroll for courses
 - Message classmates
 - download books from the library
 - submit assignments to progress
 - 
**Teachers:**
 - Can grade student assignments
 - Edit courses add modules and sections
 - Manage classrooms and post notifications on the classroom bulletin board
 - see classroom reports

**Admins**
 - Manage users
 - Add library items
 - Add new courses



result : <br>


![screenshot](https://github.com/leonn00albert/student_manager/blob/main/m1project.PNG)
