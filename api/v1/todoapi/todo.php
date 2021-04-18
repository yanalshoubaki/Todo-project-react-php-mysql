<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

require_once "init.php";

$data = json_decode(file_get_contents("php://input"));
$obj = json_encode($data);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $stmt = $db->querySelect('todo_task', '*', null);
    $result = $db->getAll($stmt);
    if ($result['status'] > 0) {
        $data = $db->fetchAll($result['query'], $result['status']);
        $obj = array('status' => 1, 'data' => $data);
        echo json_encode($obj);
    }
} else if (isset($_SERVER['REQUEST_METHOD']) == 'POST') {
    if ($data->action == "add") {
        $task_name = $data->task_name;
        $stmt = $db->queryInsert('todo_task', 'task_name, task_status', "'{$task_name}', 0");
        $result = $db->insertQuery($stmt);
        if ($result['status'] > 0) {
            $lastID = $db->lastInsertId();
            $stmt = $db->querySelect('todo_task', '*', "task_id=$lastID");
            $result = $db->getAll($stmt);
            if ($result['status'] > 0) {
                $data = $db->fetch($result['query'], $result['status']);
                $obj = array('data' => $data);
                echo json_encode($data);
            }
        }
    } else if ($data->action == "update") {
        $task_id = $data->task_id;
        $task_name = $data->task_name;
        $stmt = $db->queryUpdate('todo_task', 'task_name="' . $task_name . '"', "task_id=$task_id");
        $result = $db->insertQuery($stmt);

        if ($result['status'] > 0) {
            $stmt = $db->querySelect('todo_task', '*', "task_id=$task_id");
            $result = $db->getAll($stmt);
            if ($result['status'] > 0) {
                $data = $db->fetch($result['query'], $result['status']);
                $obj = array('data' => $data);
                echo json_encode($obj);
            }
        }
    } else if ($data->action == "done") {

        $task_status = $data->task_status;
        $task_id = $data->task_id;

        $stmt = $db->queryUpdate('todo_task', "task_status=$task_status", "task_id=$task_id");
        $result = $db->insertQuery($stmt);
        if ($result['status'] > 0) {
            $stmt = $db->querySelect('todo_task', '*', "task_id=$task_id");
            $result = $db->getAll($stmt);
            if ($result['status'] > 0) {
                $data = $db->fetchAll($result['query'], $result['status']);
                $obj = array('data' => $data, 'status' => 'checked');
                echo json_encode($obj);
            }
        }
    } else if ($data->action == "not_done") {

        $task_status = $data->task_status;
        $task_id = $data->task_id;

        $stmt = $db->queryUpdate('todo_task', "task_status=$task_status", "task_id=$task_id");
        $result = $db->insertQuery($stmt);
        if ($result['status'] > 0) {
            $stmt = $db->querySelect('todo_task', '*', "task_id=$task_id");
            $result = $db->getAll($stmt);
            if ($result['status'] > 0) {
                $data = $db->fetchAll($result['query'], $result['status']);
                $obj = array('data' => $data, 'status' => 'checked');
                echo json_encode($obj);
            }
        }
    } else if ($data->action == "delete") {

        $task_id = $data->task_id;
        $stmt = $db->queryDelete('todo_task', "task_id=$task_id");
        $result = $db->insertQuery($stmt);
        if ($result['status'] > 0) {
            $obj = array('result' => $result);
            echo json_encode($obj);
        }
    }
}
