<?php
namespace Utils\Notifications;;
class Notification{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function create($user_id, $message, $link) {
        $query = "INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)";
        $stmt = $this->db->conn()->prepare($query);
        $stmt->execute([$user_id, $message, $link]);
        $stmt->closeCursor();
    }
}