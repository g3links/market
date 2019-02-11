<?php

require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/g3authsession.php';

$result = (new \model\ext\market\bp(\model\env::session_src()))->getFinancialSession();

$lexi = \model\lexi::getall('ext/market');

require_once \model\route::script('style.php');
$data = [
    'financial' => $result->financial,
    'lbl_title' => $lexi['sys114'],
    'lbl_yes' => $lexi['sys115'],
    'lbl_no' => $lexi['sys116'],
    'lbl_taxpercentage' => $lexi['sys106'],
    'lbl_submit' => $lexi['sys016'],
];
if($result->isrole) {
    $data += [
        'updatefinancialroute' => \model\route::form('ext/market/financial/p_updatefinancial.php?idproject={0}', \model\env::session_idproject()),
    ];
}
\model\route::render('ext/market/financial/index.twig', $data);
