<?php

return [
    'auth'     => [
        'unauthorized' => 'Usuário não possui permissão para realizar essa operação.',
        'no_session'   => 'Usuário não está autenticado.'
    ],
    'user'     => [
        'not_found' => 'Usuário não encontrado.',
    ],
    'wallet'   => [
        'not_found' => 'Carteira não encontrada.',
    ],
    'transfer' => [
        'insufficient_funds' => 'Conta não possui saldo suficiente.',
        'unauthorized'       => 'Transferência não autorizada.',
    ],
    'http' => [
        'request_error' => 'Não foi possível se comunicar com o serviço.'
    ],
];
