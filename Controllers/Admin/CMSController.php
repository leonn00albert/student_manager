<?php
namespace Controllers\Admin;
use Artemis\Core\DataBases\DB;

class CMSController
{

    public $showIndex;
    public $update;

    public function __construct()
    {
        $db = DB::new(DB_TYPE, DB_NAME, DB_PASSWORD, DB_DRIVER, DB_HOST, DB_USER);
        $this->showIndex = function ($req, $res) use ($db) {
            $query = [
                "sql" => "SELECT * FROM homepage_cms 
                INNER JOIN courses ON homepage_cms.featured_course = courses.course_id
                WHERE ID = 1",
            ];

            $coursesQuery = [
                "sql" => "SELECT course_id, course_name FROM courses",
            ];
            $data = [
                "template" => "cms.php",
                "courses" => $db->find($coursesQuery),
                ...$db->find($query)[0]
            ];
        
            $res->render("admin/index", $data);
            $res->status(200);
        };
 
        $this->update = function ($req, $res) use ($db) {
            $sql = "UPDATE homepage_cms
            SET title = :title,
                hero_image = :hero_image,
                hero_title = :hero_title,
                hero_text = :hero_text,
                cta_text = :cta_text,
                cta_url = :cta_url,
                featured_course = :course_id
            WHERE id = :id";
        
            $clean = [
                "title" => htmlspecialchars($_POST["title"]),
                "hero_image" => htmlspecialchars($_POST["hero_image"]),
                "hero_title" => htmlspecialchars($_POST["hero_title"]),
                "hero_text" => htmlspecialchars($_POST["hero_text"]),
                "cta_text" => htmlspecialchars($_POST["cta_text"]),
                "cta_url" => htmlspecialchars($_POST["cta_url"]),
                "course_id" => htmlspecialchars($_POST["course_id"]),
            ];
            $stmt = $db->conn()->prepare($sql);
            $stmt->bindValue(':title',   $clean["title"]);
            $stmt->bindValue(':hero_image', $clean["hero_image"]);
            $stmt->bindValue(':hero_title', $clean["hero_title"]);
            $stmt->bindValue(':hero_text', $clean["hero_text"]);
            $stmt->bindValue(':cta_text', $clean["cta_text"]);
            $stmt->bindValue(':cta_url', $clean["cta_url"]);
            $stmt->bindValue(':course_id', $clean["course_id"]);
            $stmt->bindValue(':id', 1);
            $stmt->execute();
            $db->close();
            $res->redirect("/admin/cms");
            $res->status(301);
        };
    }
}
