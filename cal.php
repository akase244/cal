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
    '日',
    '月',
    '火',
    '水',
    '木',
    '金',
    '土',
];

// 曜日を出力
echo implode(' ', $weeks) . PHP_EOL;

// 初日の曜日が始まるまでスペースで埋める
$spaces = [];
for ($i = 0; $i < $firstDayOfWeek; $i++) {
    // 1日分をスペース3桁とする
    $spaces[] = '   ';
}
echo implode($spaces);

$weekPosition = $firstDayOfWeek;
for ($day = $firstDay; $day <= $lastDay; $day++) {
    $format = '%s ';
    // 日付が1桁の場合は10の位をスペースで埋める
    if (strlen((string) $day) === 1) {
        $format = ' ' . $format;
    }
    // [日付+スペース1桁]の形式で出力
    echo sprintf($format, (string) $day);
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
    $spaces = [];
    for ($i = $lastDayOfWeek + 1; $i <= 6; $i++) {
        // 1日分をスペース3桁とする
        $spaces[] = '   ';
    }
    echo implode($spaces) . PHP_EOL;
}
