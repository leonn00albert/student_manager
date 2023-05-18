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

start server

```bash 
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
![screenshot](https://github.com/leonn00albert/student_manager/blob/main/student-manager.gif)
