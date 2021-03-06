<?php
$users = [
    [
        'name' => 'Иван',
        'surname' => 'Иванов',
        'email' => 'ivanov@mail.ru',
        'password' => '12345'
    ],
    [
        'name' => 'Петр',
        'surname' => 'Петров',
        'email' => 'petrov@mail.ru',
        'password' => '54321'
    ],
    [
        'name' => 'Николай',
        'surname' => 'Николаев',
        'email' => 'nick@mail.ru',
        'password' => '12543'
    ]
];

$file = "logs.txt";

$fp = fopen($file, "a");

$log = date('Y-m-d H:i:s');

if ($_POST['email'] !== '' && $_POST['name'] !== '' && $_POST['surname'] !== '' && $_POST['password'] !== '' && $_POST['repeatPass'] !== '') {

    if ($_POST['password'] == $_POST['repeatPass']) {
        if (strlen($_POST['password']) >= 6 && preg_match('/[A-zА-я]+/', $_POST['password']) && preg_match('/[0-9]+/', $_POST['password'])) {
            if (in_array($_POST['email'], array_column($users, 'email'))) {
                echo json_encode(array('result' => 'Пользователь с таким email уже существует'));
                $log = $log . ' ' . $_POST['email'] . ' found' . PHP_EOL;
                fwrite($fp, $log);
            } else {
                echo json_encode(array('result' => 'Регистрация прошла успешно'));
                $log = $log . ' ' . $_POST['email'] . ' not found' . PHP_EOL;
                fwrite($fp, $log);
            }
        } else {
            echo json_encode(array('result' => 'Пароль должен иметь длину более 6 символов, содержать в себе не менее 1 символа и не менее одной буквы'));
        }
    } else {
        echo json_encode(array('result' => 'Пароли не совпадают'));
    }
} else {
    echo json_encode(array('result' => 'Заполните все поля'));
}

fclose($fp);
