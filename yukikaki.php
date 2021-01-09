<?php
declare(strict_types=1);

function validate($time)
{
    $error = [];
    if ($time <= 0) {
        $error['time'] = '雪掻きした時間を入力してください';
    }

    return $error;
}

function createLog($link)
{
    echo '〇雪掻き記録を登録する' . PHP_EOL;
        echo '何分雪掻きしましたか？ ';
        $time = (int)trim(fgets(STDIN));
        // $today = date("n/j");

        $validated = validate($time);
        if (count($validated) > 0) {
            foreach ($validated as $error) {
                echo $error . PHP_EOL;
            }
            return;
        }

        $sql = <<<EOT
INSERT INTO yukikaki_logs (
    time
) VALUES (
    $time
);
EOT;
        mysqli_query($link, $sql);

        echo '登録が完了しました' . PHP_EOL . PHP_EOL;
        echo 'doskoi';

        // return [
        //     'date' => $today,
        //     'minutes' => $time
        // ];
}

function listLogs($link)
{
    echo '〇これまでの雪掻き記録' . PHP_EOL;

    $count_yukikaki = 0;
    $sum_minutes = 0;
    $sum_calories = 0;

    $sql = 'SELECT time, created_at FROM yukikaki_logs;';

    $results = mysqli_query($link, $sql);
    while ($yukikaki = mysqli_fetch_assoc($results)) {
        $calorie = $yukikaki['time'] * 4;
        echo '日時：' . $yukikaki['created_at'] . PHP_EOL;
        echo '時間：' . $yukikaki['time'] . '分' . PHP_EOL;
        echo 'カロリー：' . $calorie . 'kcal' . PHP_EOL;

        $count_yukikaki += 1;
        $sum_minutes += $yukikaki['time'];
        $sum_calories += $calorie;
    }

    mysqli_free_result($results);

        // foreach ($yukikaki_logs as $yukikaki_log) {
        //     echo '日付：         ' . $yukikaki_log['date'] . PHP_EOL;
        //     echo '時間：         ' . $yukikaki_log['minutes'] . '分' . PHP_EOL;
        //     $calorie = $yukikaki_log['minutes'] * YUKIKAKI_CALORIE;
        //     echo '消費カロリー： ' . $calorie . 'kcal' . PHP_EOL;
        //     echo '----------------------' . PHP_EOL;

            // $count_yukikaki += 1;
            // $sum_minutes += $yukikaki_log['minutes'];
            // $sum_calories += $calorie;
        // }

        echo '雪掻き回数：        ' . $count_yukikaki . '回' . PHP_EOL;
        echo '合計時間：         ' . $sum_minutes . '分' . PHP_EOL;
        echo '合計消費カロリー： ' . $sum_calories . 'kcal' . PHP_EOL . PHP_EOL;
}

function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging Error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    echo 'データベースと接続しました' . PHP_EOL;

    return $link;
}

const YUKIKAKI_CALORIE = 4;
$yukikaki_logs = [];

// echo '・前回の雪掻き' . PHP_EOL;
// echo '日付：1/7' . PHP_EOL;
// echo '時間（分）：60分' . PHP_EOL;
// echo '消費カロリー：400kcal' . PHP_EOL;

$link = dbConnect();

while(true) {
    echo '1. 雪掻き記録を登録する' . PHP_EOL;
    echo '2. これまでの雪掻き記録を表示' . PHP_EOL;
    echo '9. アプリケーションを終了する' . PHP_EOL;
    echo '番号を入力してください（1, 2, 9）：';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        $yukikaki_logs[] = createLog($link);

    } elseif ($num === '2') {
        listLogs($link);

    } elseif ($num === '9') {
        break;

    }
}
