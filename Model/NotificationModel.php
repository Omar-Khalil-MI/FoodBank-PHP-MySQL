<?php
require_once "pdo.php";

class NotificationModel {
    private $id;

    public function __construct($id = 0) {
        $this->id = $id;
    }

    public function toggleRead($status) {
        $sql = "UPDATE notifications SET is_read = :status WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $this->id]);
    }

    public function delete() {
        $sql = "DELETE FROM notifications WHERE id = :id";
        $stmt = Singleton::getpdo()->prepare($sql);
        return $stmt->execute(['id' => $this->id]);
    }

    public static function getUnreadCount($admin_id) {
        $sql = "SELECT COUNT(*) as total FROM notifications WHERE admin_id = :aid AND is_read = 0";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['aid' => $admin_id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'];
    }

    public static function getByAdmin($admin_id) {
        $sql = "SELECT * FROM notifications WHERE admin_id = :aid ORDER BY created_at DESC";
        $stmt = Singleton::getpdo()->prepare($sql);
        $stmt->execute(['aid' => $admin_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createLowStockNotifications($item_name, $amount) {
        $db = Singleton::getpdo();
        
        $stmt = $db->prepare("SELECT id FROM admin WHERE role = 'warehouse'");
        $stmt->execute();
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $msg = "Low Stock Alert: " . $item_name . " has only " . $amount . " units left.";
        $notifStmt = $db->prepare("INSERT INTO notifications (admin_id, message) VALUES (:aid, :msg)");
        
        foreach ($admins as $admin) {
            $notifStmt->execute(['aid' => $admin['id'], 'msg' => $msg]);
        }
    }
}