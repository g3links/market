<?php

require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/g3authsession.php';

$idfiscalperiod = 0;
if (filter_input(INPUT_GET, 'idfiscal') !== null) 
    $idfiscalperiod = (int)filter_input(INPUT_GET, 'idfiscal');

$idbb = 0;
if (filter_input(INPUT_GET, 'id') !== null) 
    $idbb = (int) filter_input(INPUT_GET, 'id');

$idbg = 0;
if (filter_input(INPUT_GET, 'idbg') !== null) 
    $idbg = (int) filter_input(INPUT_GET, 'idbg');

$idproduct = 0;
if (filter_input(INPUT_GET, 'idproduct') !== null) 
    $idproduct = (int) filter_input(INPUT_GET, 'idproduct');

$modelbp = new \model\ext\market\bp(\model\env::session_src());

$budgetbook = $modelbp->getBudgetBook($idbb);
if (!isset($budgetbook->idbg)) {
    $mssg = \model\lexi::get('ext/market','sys059') . ': ' . $idbb ;
    \model\message::severe('sys009', $mssg);
}

$result = $modelbp->getBudgetJournalBook($idfiscalperiod, $idbb, $idproduct);

$lexi = \model\lexi::getall('ext/market');
$data = [
    'idproduct' => $idproduct,
    'idbg' => $idbg,
    'budgetbook' => $budgetbook,
    'periods' => $result->periods,
    'lbl_title' => $lexi['sys105'],
    'lbl_group' => $lexi['sys092'],
    'lbl_dollar' => $lexi['sys064'],
    'lbl_submit' => $lexi['sys016'],
];
if($result->isrole) {
    $data += [
        'updatejournalroute' => \model\route::form('ext/market/budget/p_updatejournal.php?idproject={0}&idfiscal={1}&id={2}', \model\env::session_idproject(), $idfiscalperiod, $idbb),
    ];
}
\model\route::render('ext/market/budget/m_editjournal.twig', $data);
