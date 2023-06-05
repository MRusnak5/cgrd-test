<?php
// User.php
require_once 'Database.php';

class  News{
    private $db;

    public function __construct() {
        try {
            $this->db = new Database();
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function create()
    {
        $newsTitle = $_POST['title'];
        $newsDescription = $_POST['description'];

        $sql = "INSERT INTO news (title, description) VALUES (:title, :description)";
        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindParam(':title', $newsTitle);
        $stmt->bindParam(':description', $newsDescription);

        if ($stmt->execute()) {
             return (['status' => 'success', 'message' => 'News was successfully created!']);
        } else {
             return (['status' => 'error', 'message' => 'Failed to create news item.']);
        }
    }
    
    public function read()
    {
        $sql = "SELECT * FROM news";
        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->execute();

        $newsItems = $stmt->fetchAll();

        if($newsItems){
             return (['status' => 'success', 'message' => 'News Loaded.','data' => $newsItems]);
        } else {
             return (['status' => 'error', 'message' => 'No news items found.']);
        }
    }
    
    public function update()
    {
        $newsId = $_POST['id'];
        $newsTitle = $_POST['title'];
        $newsDescription = $_POST['description'];

        $sql = "UPDATE news SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindParam(':id', $newsId);
        $stmt->bindParam(':title', $newsTitle);
        $stmt->bindParam(':description', $newsDescription);

        if ($stmt->execute()) {
             return (['status' => 'success', 'message' => 'News was successfully changed!']);
        } else {
             return (['status' => 'error', 'message' => 'Failed to update news item.']);
        }
    }
    
    public function delete()
    {
        $newsId = $_POST['id'];

        $sql = "DELETE FROM news WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindParam(':id', $newsId);

        if ($stmt->execute()) {
             return (['status' => 'success', 'message' => 'News was deleted!']);
        } else {
             return (['status' => 'error', 'message' => 'Failed to delete news item.']);
        }
    }
}
?>