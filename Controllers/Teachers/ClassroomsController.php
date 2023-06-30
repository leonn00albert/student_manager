<?php
namespace Controllers\Teachers;

use Artemis\Core\DataBases\DB;
use Exception;

class ClassroomsController
{

    public $showIndex;
    public $showEdit;
    public $showReport;
    public $create;
    public $update;
    public $show;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {

            $teacherQuery = [
                "sql" => "SELECT teacher_id FROM teachers WHERE user_id = " . $_SESSION["user_id"]
            ];

            $teacher = $db->find($teacherQuery)[0];

            $query = [
                "sql" => "SELECT * FROM courses
                INNER JOIN classrooms ON courses.classroom_id = classrooms.classroom_id
                WHERE courses.teacher_id = " . $teacher["teacher_id"]
            ];

            $data = [
                "template" => "classrooms.php",
                "classrooms" => $db->find($query)
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };

        $this->show = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT *, enrollments.classroom_id FROM enrollments
                INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                INNER JOIN students ON enrollments.student_id = students.student_id
                INNER JOIN users ON students.user_id = users.user_id
                WHERE classrooms.classroom_id = :id",
                "params" => [
                    "id" => $id
                ]
            ];

            $gradesQuery = [
                "sql" => "SELECT * FROM grades
                INNER JOIN students ON grades.student_id = students.student_id
                INNER JOIN users ON students.user_id = users.user_id
                INNER JOIN sections ON grades.section_id = sections.section_id
                WHERE grades.classroom_id = :id
                AND grades.is_archived = 0",
                "params" => [
                    "id" => $id
                ]
            ];

            $bulletinsQuery = [
                "sql" => "SELECT * FROM bulletins
                WHERE bulletins.classroom_id = :id",
                "params" => [
                    "id" => $id
                ]
            ];


            $progressQuery = [
                "sql" => "SELECT *, COUNT(g.grade_id) AS graded_sections
                FROM Sections s
                LEFT JOIN Grades g ON s.section_id = g.section_id
                LEFT JOIN users u ON u.user_id = g.student_id
                WHERE g.grade_status = 'Graded'
                AND g.classroom_id = :id
                GROUP BY g.student_id",
                "params" => [
                    "id" => $id
                ]
            ];


            $progressQuery = [
                "sql" => "SELECT * FROM progress
                WHERE classroom_id = :id",
                "params" => [
                    "id" => $id
                ]

            ];

            $result = $db->find($query);
            $data = [
                "template" => "classrooms/show.php",
                "classroom" =>   $result[0],
                "students" =>   $result,
                "grades" =>   $db->find($gradesQuery),
                "progress" => $db->find($progressQuery),
                "bulletins" =>   $db->find($bulletinsQuery),
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
           // --TODO MAKE ADMIN ONLY 
           $id = $req->params()["id"];
           $teachersQuery = [
               "sql" => "SELECT * FROM teachers
            INNER JOIN users ON teachers.user_id = users.user_id"
           ];
           $coursesQuery = [
               "sql" => "SELECT * FROM courses"
           ];

           $classroomsQuery = [
            "sql" => "SELECT * FROM classrooms WHERE classroom_id = :id",
            "params" => [
                "id" => $id
            ]
        ];
        
           $data = [
               "template" => "classrooms/edit.php",
               "courses" => $db->find($coursesQuery),
               "teachers" => $db->find($teachersQuery),
               "classroom" => $db->find($classroomsQuery)[0]
           ];

           $res->render("teachers/index", $data);
           $res->status(200);
        };
        $this->showReport = function ($req, $res) use ($db) {
            $id = $req->params()["id"];
            $query = [
                "sql" => "SELECT *, enrollments.classroom_id FROM enrollments
                INNER JOIN classrooms ON enrollments.classroom_id = classrooms.classroom_id
                INNER JOIN students ON enrollments.student_id = students.student_id
                INNER JOIN users ON students.user_id = users.user_id
                WHERE classrooms.classroom_id = :id",
                "params" => [
                    "id" => $id
                ]
            ];


            $progressQuery = [
                "sql" => "SELECT * FROM progress
                WHERE classroom_id = :id",
                "params" => [
                    "id" => $id
                ]

            ];

            function calculateGrade($totalPoints, $studentScore) {
                $percentage = ($studentScore / $totalPoints) * 100;
                
                if ($percentage >= 90) {
                    return 'A';
                } elseif ($percentage >= 80) {
                    return 'B';
                } elseif ($percentage >= 70) {
                    return 'C';
                } elseif ($percentage >= 60) {
                    return 'D';
                } elseif ($percentage >= 50) {
                    return 'E';
                } else {
                    return 'F';
                }
            }

            $progress = array_map(function ($elm) {
                $total_points = (int) $elm["sections"] * 10;
                $student_score = (int)  $elm["total_score"];
                $elm["grade"] = calculateGrade($total_points,$student_score);
                $elm["max_score"] =   $total_points ;
                return $elm;
            },$db->find($progressQuery));

            $result = $db->find($query);
            $data = [
                "template" => "classrooms/report.php",
                "classroom" =>   $result[0],
                "students" =>   $result,
                "progress" => $progress,
                
            ];
            $res->render("teachers/index", $data);
            $res->status(200);
        };
        $this->showEdit = function ($req, $res) use ($db) {
           // --TODO MAKE ADMIN ONLY 
           $id = $req->params()["id"];
           $teachersQuery = [
               "sql" => "SELECT * FROM teachers
            INNER JOIN users ON teachers.user_id = users.user_id"
           ];
           $coursesQuery = [
               "sql" => "SELECT * FROM courses"
           ];

           $classroomsQuery = [
            "sql" => "SELECT * FROM classrooms WHERE classroom_id = :id",
            "params" => [
                "id" => $id
            ]
        ];
        
           $data = [
               "template" => "classrooms/edit.php",
               "courses" => $db->find($coursesQuery),
               "teachers" => $db->find($teachersQuery),
               "classroom" => $db->find($classroomsQuery)[0]
           ];

           $res->render("teachers/index", $data);
           $res->status(200);
        };
        $this->create = function ($req, $res) use ($db) {
        };

        $this->update = function ($req, $res) use ($db) {

            try {
                $id = $req->params()["id"];
                $query = "UPDATE classrooms SET 
                            classroom_name = ?,
                            course_id = ?,
                            teacher_id = ?
                          WHERE classroom_id = ?";
    
                $userData = [
                    $req->sanitized["classroom_name"],
                    $req->sanitized["course_id"],
                    $req->sanitized["teacher_id"],
                    $id
                ];
    
                $statement = $db->conn()->prepare($query);
    
                foreach ($userData as $index => $value) {
                    $statement->bindValue($index + 1, $value);
                }
    
                $statement->execute();
    
                if ($statement->rowCount() > 0) {
                    setAlert("success", "Successfully updated classroom");

                    $res->redirect("/teachers/classrooms");
                    $res->status(301);
                } else {
                    setAlert("danger", "Something went wrong: Could not update classroom");
                     $res->redirect("/teachers/classrooms");
                    $res->status(301);
                }
    
                $db->close();
            }
            catch(Exception $e) {
             
                    setAlert("danger", "Something went wrong: " . $e->getMessage());

                }
           
        };
    }
}
