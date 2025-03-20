<?php
require_once 'config.php';

$page_title = 'Danh sách Học phần';

// Lấy danh sách học phần
try {
    $stmt = $conn->query("SELECT * FROM hocphan");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

require_once 'header.php';
?>

<div class="container">
    <h1 class="my-4">Danh sách học phần</h1>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">Danh sách học phần</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã Học Phần</th>
                            <th>Tên Học Phần</th>
                            <th>Số Tín Chỉ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($subjects as $subject): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject['MaHP']); ?></td>
                            <td><?php echo htmlspecialchars($subject['TenHP']); ?></td>
                            <td><?php echo htmlspecialchars($subject['SoTinChi']); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="register.php?id=<?php echo urlencode($subject['MaHP']); ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-user-plus"></i> Đăng ký
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>

</html>