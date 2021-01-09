<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

if (!$link) {
    echo 'データベースとの接続に失敗しました' . PHP_EOL;
    echo 'Debugging Error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo 'データベースに接続できました' . PHP_EOL;

$sql = 'SELECT time, created_at FROM yukikaki_logs;';

$results = mysqli_query($link, $sql);
while ($yukikaki = mysqli_fetch_assoc($results)) {
    $calorie = $yukikaki['time'] * 4;
    echo '日時：' . $yukikaki['created_at'] . PHP_EOL;
    echo '時間：' . $yukikaki['time'] . '分' . PHP_EOL;
    echo 'カロリー：' . $calorie . 'kcal' . PHP_EOL;
}

mysqli_free_result($results);
