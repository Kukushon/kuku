<?php

// Отправляем правильную кодировку.
header('HTTP/1.1 404 Not Found');
header('Content-Type: text/html; charset=UTF-8');

// Выводим все полученные через POST параметры.
print_r($_POST);

// Hello
print('Привет!');

// Чтобы получить в переменную данные из сущности запроса.
$xml = file_get_contents('php://input');

// Память очищается в конце работы скрипта.
if (isset($v1)) {
  $v1++;
}
else {
  $v1 = 1;
}
print($v1);
