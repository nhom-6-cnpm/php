<?php
// Bắt đầu session nếu chưa được bắt đầu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Quản lý sinh viên'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    .navbar {
        padding: 0;
    }

    .navbar-nav .nav-link {
        padding: 1rem;
        color: white;
    }

    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-nav .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                        href="index.php">Sinh Viên</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'section.php' ? 'active' : ''; ?>"
                        href="section.php">Học Phần</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dangky.php' ? 'active' : ''; ?>"
                        href="dangky.php">Đăng Kí (i)</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>"
                        href="login.php">Đăng Nhập</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-header">
        <div class="container">
            <h1 class="display-4"><?php echo $page_title ?? 'Quản lý Sinh viên'; ?></h1>
        </div>
    </div>
</body>

</html>