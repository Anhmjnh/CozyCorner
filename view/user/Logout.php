<?php
// views/user/Logout.php
require_once __DIR__ . '/../../config.php';

header('Location: ' . BASE_URL . 'index.php?url=auth/logout');
exit;
