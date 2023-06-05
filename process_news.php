<?php
  session_start();

  include 'News.php';
  $response = [];
  $news = new News();
  
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'create':
            $result = $news->create();
            echo json_encode($result);
            exit;
        case 'read':
            $result = $news->read();
            echo json_encode($result);
            exit;
        case 'update':
            $result = $news->update();
            echo json_encode($result);
            exit;
        case 'delete':
            $result = $news->delete();
            echo json_encode($result);
            exit;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
    echo json_encode($result);
    exit;
}