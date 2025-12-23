<?php
require_once "../Model/NotificationModel.php";
require_once "AuthCheck.php";

if (!isset($_SESSION)) session_start();
AuthCheck::requireAdminLogin();

class NotificationController {
    
    public function handleRequest() {
        $command = isset($_GET['cmd']) ? $_GET['cmd'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        if ($id > 0) {
            $notif = new NotificationModel($id);
            
            if ($command == 'read') {
                $notif->toggleRead(1);
            } else if ($command == 'unread') {
                $notif->toggleRead(0);
            } else if ($command == 'delete') {
                $notif->delete();
            }
        }

        header("Location: ItemController.php");
        exit();
    }
}

$controller = new NotificationController();
$controller->handleRequest();