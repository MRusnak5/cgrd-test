<?php

session_start();

include 'User.php';
$response = [];

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
          'username' => $_POST['username'],
          'password' => $_POST['password']
      ];

      $user = new User();
      $result = $user->login($data);
      echo json_encode($result);
      exit;
  } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
      if ($_GET['action'] === 'logout') {
          if (!isset($_SESSION['user_id'])) {
              $response['status'] = 'error';
              $response['message'] = 'No user session to log out.';
              echo json_encode($response);
              exit;
          }
          unset($_SESSION['user_id']);

          $response['status'] = 'success';
          $response['message'] = 'User is logged out.';
          
          echo json_encode($response);
          exit;
      }
  } else {
    //user logged in check
      if (isset($_SESSION['user_id'])) {
          $response['status'] = 'success';
          $response['message'] = 'User is logged in.';
      } else {
          $response['status'] = 'error';
          $response['message'] = 'User is not logged in.';
      }

      echo json_encode($response);
      exit;
  }
} catch (Exception $e) {
  $response['status'] = 'error';
  $response['message'] = 'Caught exception: ' . $e->getMessage();
  echo json_encode($response);
  exit;
}