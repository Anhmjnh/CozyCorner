<?php
// models/NewsModel.php
require_once __DIR__ . '/../core/Model.php';

class NewsModel extends Model {

    public function getNewsById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function getAdminNewsList($limit = 10, $offset = 0, $search = '', $danh_muc = '') {
        $sql = "SELECT * FROM news WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND tieu_de LIKE '%$search_esc%'";
        }
        if (!empty($danh_muc)) {
            $cat_esc = $this->conn->real_escape_string($danh_muc);
            $sql .= " AND danh_muc = '$cat_esc'";
        }
        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalAdminNewsCount($search = '', $danh_muc = '') {
        $sql = "SELECT COUNT(id) as total FROM news WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND tieu_de LIKE '%$search_esc%'";
        }
        if (!empty($danh_muc)) {
            $cat_esc = $this->conn->real_escape_string($danh_muc);
            $sql .= " AND danh_muc = '$cat_esc'";
        }
        return $this->conn->query($sql)->fetch_assoc()['total'] ?? 0;
    }

    public function getNewsForExport($search = '', $danh_muc = '')
    {
        $sql = "SELECT id, tieu_de, slug, danh_muc, luot_xem, trang_thai, created_at FROM news WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND tieu_de LIKE '%$search_esc%'";
        }
        if (!empty($danh_muc)) {
            $cat_esc = $this->conn->real_escape_string($danh_muc);
            $sql .= " AND danh_muc = '$cat_esc'";
        }
        $sql .= " ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestNews($limit = 3) {
        $stmt = $this->conn->prepare("SELECT * FROM news WHERE trang_thai = 'HienThi' ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getNewsByFilters($category = '', $limit = 12) {
        $where = "trang_thai = 'HienThi'";
        $params = [];
        $types = "";
        if (!empty($category) && $category !== 'Tất cả') {
            $where .= " AND danh_muc = ?";
            $params[] = $category;
            $types .= "s";
        }
        $query = "SELECT * FROM news WHERE $where ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $params[] = $limit;
        $types .= "i";
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function increaseViewCount($id) {
        $stmt = $this->conn->prepare("UPDATE news SET luot_xem = luot_xem + 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getRelatedNews($id, $limit = 3) {
        $stmt = $this->conn->prepare("SELECT * FROM news WHERE id != ? AND trang_thai = 'HienThi' ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function addNews($tieu_de, $noi_dung, $danh_muc, $trang_thai, $anh) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $tieu_de)));
        $slug = preg_replace('/-+/', '-', $slug) . '-' . time();
        
        $stmt = $this->conn->prepare("INSERT INTO news (tieu_de, slug, noi_dung, danh_muc, anh, trang_thai) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $tieu_de, $slug, $noi_dung, $danh_muc, $anh, $trang_thai);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateNews($id, $tieu_de, $noi_dung, $danh_muc, $trang_thai, $anh) {
        $stmt = $this->conn->prepare("UPDATE news SET tieu_de = ?, noi_dung = ?, danh_muc = ?, anh = ?, trang_thai = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $tieu_de, $noi_dung, $danh_muc, $anh, $trang_thai, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteNews($id) {
        $stmt = $this->conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>