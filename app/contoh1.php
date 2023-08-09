<?php

require __DIR__ . '/vendor/autoload.php';

use Ripcord\Ripcord;

include 'konfigurasi.php';

$common = ripcord::client("$url/xmlrpc/2/common");
$uid = $common->authenticate($db, $email, $password, []);


if (empty($uid)) {
    echo "Gagal login";
    return false;
}

$models = ripcord::client("$url/xmlrpc/2/object");

$values = [
    //'name' => "Sample jurnal entri",
    'name' => '',
    'date' => '2023-08-08',
    'journal_id' => '3',
    'currency_id' => '12'
];

$je_id = $models->execute_kw($db, $uid, $password, 'account.move', 'create',
    [$values]);

$values_l1 = ['move_id' => $je_id,
    'account_id' => 9,
    'name' => 'contoh label',
    'debit' => 120.00];

$l1 = $models->execute_kw($db, $uid, $password, 'account.move.line', 'create',
    [$values_l1], array(
        'context' => array(
            'check_move_validity' => false
        )
    ));
print_r($l1);

$values_l2 = ['move_id' => $je_id,
    'account_id' => 64,
    'credit' => 140.00];

$l2 = $models->execute_kw($db, $uid, $password, 'account.move.line', 'create',
    [$values_l2], array(
        'context' => array(
            'check_move_validity' => false
        )
    ));
print_r($l2);