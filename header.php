<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lab09 Library</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="public/css/style.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">

<?php $active = $_GET['c'] ?? 'book'; ?>
<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?= $active==='book' ? 'active' : '' ?>" href="index.php?c=book">Sách</a></li>
                <li class="nav-item"><a class="nav-link <?= $active==='member' ? 'active' : '' ?>" href="index.php?c=member">Độc giả</a></li>
                <li class="nav-item"><a class="nav-link <?= $active==='borrow' ? 'active' : '' ?>" href="index.php?c=borrow">Mượn/Trả</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-4">
