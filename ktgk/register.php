<?php
require_once 'config.php';

$page_title = 'Đăng ký Học phần';

if (!isset($_GET['id'])) {
    header("Location: section.php");
    exit();
}

$id = $_GET['id'];

// Debug information
echo "<pre>";
echo "ID from URL: " . htmlspecialchars($id) . "\n";
echo "</pre>";

// Lấy thông tin học phần
try {
    $sql = "SELECT * FROM hocphan WHERE MAHP = ?";
    echo "<pre>";
    echo "SQL Query: " . $sql . "\n";
    echo "Parameter value: " . htmlspecialchars($id) . "\n";
    echo "</pre>";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$subject) {
        echo "<pre>";
        echo "No subject found with MAHP = " . htmlspecialchars($id) . "\n";
        echo "</pre>";
    }

    // Lấy danh sách sinh viên chưa đăng ký học phần này
    $stmt = $conn->prepare("
        SELECT * FROM sinhvien 
        WHERE MaSV NOT IN (
            SELECT MaSV FROM register WHERE MAHP = ?
        )
    ");
    $stmt->execute([$id]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Xử lý đăng ký khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO register (MaDK, MaSV, MAHP, NgayDK) VALUES (NULL, ?, ?, NOW())");
        $stmt->execute([$_POST['student_id'], $id]);
        
        header("Location: hocphan.php");
        exit();
    } catch(PDOException $e) {
        $error = "Lỗi đăng ký: " . $e->getMessage();
    }
}

require_once 'header.php';
?>

<div class="container">
    <?php if ($subject): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Thông tin học phần</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Mã học phần:</dt>
                <dd class="col-sm-9"><?php echo htmlspecialchars($subject['MAHP']); ?></dd>

                <dt class="col-sm-3">Tên học phần:</dt>
                <dd class="col-sm-9"><?php echo htmlspecialchars($subject['TenHP']); ?></dd>

                <dt class="col-sm-3">Số tín chỉ:</dt>
                <dd class="col-sm-9"><?php echo htmlspecialchars($subject['SoTinChi']); ?></dd>
            </dl>
        </div>
    </div>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($students)): ?>
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0"><i class="fas fa-user-plus"></i> Đăng ký sinh viên</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="student_id" class="form-label">Chọn sinh viên:</label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        <option value="">-- Chọn sinh viên --</option>
                        <?php foreach($students as $student): ?>
                        <option value="<?php echo htmlspecialchars($student['MaSV']); ?>">
                            <?php echo htmlspecialchars($student['MaSV'] . ' - ' . $student['HoTen']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Đăng ký
                    </button>
                    <a href="hocphan.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Không có sinh viên nào có thể đăng ký học phần này.
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> Không tìm thấy thông tin học phần
    </div>
    <?php endif; ?>
    <a href="hocphan.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

</body>

</html>