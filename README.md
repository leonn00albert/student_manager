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
 - Manage homepage CMS



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

