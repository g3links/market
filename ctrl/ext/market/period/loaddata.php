<?php

require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/g3authsession.php';

$periods = (new \model\ext\market\bp(\model\env::session_src()))->getPeriods(true);

$lexi = \model\lexi::getall('ext/market');
$data = [
    'periods' => $periods,
    'th_col1' => $lexi['sys011'],
    'th_col2' => $lexi['sys065'],
    'th_col3' => $lexi['sys068'],
    'th_col4' => $lexi['sys069'],
    'lbl_notfound' => $lexi['sys004'],
];
\model\route::render('ext/market/period/loaddata.twig', $data);
