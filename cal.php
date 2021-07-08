<?php
declare(strict_types=1);

// 引数がない場合
$dt = new DateTimeImmutable();

// 引数がある場合
if (isset($argv[1]) && strlen($argv[1]) === 6) {
    $argYear = substr($argv[1], 0, 4);
    $argMonth =  substr($argv[1], 4, 2);
    if (checkdate((int) $argMonth, 1, (int) $argYear)) {
        $dt = new DateTimeImmutable($argYear . '-' . $argMonth . '-01');
    }
}

// タイトルを出力
$month = (int) $dt->format('m');
$year = (int) $dt->format('Y');
$title = "      %s月 %s\n";
echo sprintf($title, (string) $month, (string) $year);

// 初日
$firstDt = $dt->modify('first day of');
// 末日
$lastDt = $dt->modify('last day of');

// 日付
$firstDay = (int) $firstDt->format('d');
$lastDay = (int) $lastDt->format('d');

// 曜日
$firstDayOfWeek = (int) $firstDt->format('w');
$lastDayOfWeek = (int) $lastDt->format('w');

// 曜日のラベル
$weeks = [
    0 => '日',
    1 => '月',
    2 => '火',
    3 => '水',
    4 => '木',
    5 => '金',
    6 => '土',
];

// 曜日を出力
echo implode(' ', $weeks) . PHP_EOL;

// 初日の曜日が始まるまでスペースで埋める
for ($i = 0; $i < $firstDayOfWeek; $i++) {
    // 1日分をスペース3桁とする
    echo '   ';
}

$weekPosition = $firstDayOfWeek;
for ($day = $firstDay; $day <= $lastDay; $day++) {
    // 日付が1桁の場合は10の位をスペースで埋める
    if (strlen((string) $day) === 1) {
        echo ' ';
    }
    // 日付の後ろをスペース1桁で埋める
    echo $day . ' ';
    // 土曜日の場合は改行する
    if ($weekPosition === 6) {
        $weekPosition = 0;
        echo PHP_EOL;
    } else {
        $weekPosition++;
    }
}

// 末日が土曜日終わり以外の場合
if ($lastDayOfWeek !== 6) {
    // 末日の曜日以降から土曜日までをスペースで埋める
    for ($i = $lastDayOfWeek + 1; $i <= 6; $i++) {
        // 1日分をスペース3桁とする
        echo '   ';
    }
    echo PHP_EOL;
}
