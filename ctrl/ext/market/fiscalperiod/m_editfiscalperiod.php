<?php

require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/g3authsession.php';

$idfiscalperiod = 0;
if (filter_input(INPUT_GET, 'idfiscalperiod') !== null) 
    $idfiscalperiod = (int) filter_input(INPUT_GET, 'idfiscalperiod');

$isrole = \model\env::isUserAllow(\model\env::session_idproject(), \model\action::ROLE_FINANCIALS);

if ($idfiscalperiod !== 0) {
    $fiscalperiod = (new \model\ext\market\bp(\model\env::session_src()))->getFiscalPeriod($idfiscalperiod);
} else {
    $fiscalperiod = new \stdClass();
    $fiscalperiod->fiscalname = '';
    $fiscalperiod->idfiscalperiod = 0;
    $fiscalperiod->seq = 0;
}

$lexi = \model\lexi::getall('ext/market');
$data = [
    'fiscalperiod' => $fiscalperiod,
    'lbl_title' => $lexi['sys067'],
    'lbl_fiscalname' => $lexi['sys011'],
    'lbl_seq' => $lexi['sys065'],
    'lbl_closed' => $lexi['sys066'],
    'lbl_submit' => $lexi['sys016'],
    'lbl_submitdelete' => $lexi['sys017'],
];
if($isrole) {
    $data += [
        'updatefiscalperiodroute' => \model\route::form('ext/market/fiscalperiod/p_updateperiod.php?idproject={0}', \model\env::session_idproject()),
    ];
}
\model\route::render('ext/market/fiscalperiod/m_editfiscalperiod.twig', $data);
