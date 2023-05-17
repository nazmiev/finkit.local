<?php

    $db_config = [
        'name' => 'finkit',
        'user' => 'root',
        'pass' => ''
    ];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname='.$db_config['name'].';charset=utf8mb4', $db_config['user'], $db_config['pass'], [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('no db connection'); 
    }

    $user = $pdo->prepare( "SELECT * FROM users WHERE login= :login");
    $user->execute([
            'login' => $_REQUEST['login']
        ]);
    $user = $user->fetch();

    $response = false;

    if(isset($user)) {
        if(isset($_REQUEST['password']) && password_verify($_REQUEST['password'], $user['password'])) {
            unset($user['password']);
            $response = true;
        } else {
            unset($user);
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'code' => $response ? 1 : 0,
        'user' => isset($user) ? $user : null
    ], JSON_UNESCAPED_UNICODE);