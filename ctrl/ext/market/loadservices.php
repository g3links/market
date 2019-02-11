<?php

// read modules for market
$modelmarket = new \model\ext\market\market(\model\env::src($project->idproject));

//modules:
// - moduleid: used at start page (combine with iproject for unique id) 
// - groupname: used at actions to display by groups

if ($modelmarket->hasProductService()) {
    //*********************
    // ORDERS
    //*********************
    $module = new \stdClass();
    $module->approute = \model\route::window('orderadmon', ['ext/market/order/index.php?idproject={0}', $project->idproject], $project->idproject, \model\lexi::get('ext/market', 'sys036'), $project->title);
    $module->value = $modelmarket->getTotalActiveOrders();
    $module->image = 'imgProduct';
    $module->moduleid = 'ord';
    $module->groupname = 'bp';
    $project->modules[] = $module;

    //*********************
    // CART
    //*********************
    $module = new \stdClass();
    $module->approute = \model\route::window('marketadmon', ['ext/market/cart/index.php?idproject={0}', $project->idproject], $project->idproject, \model\lexi::get('ext/market', 'sys037'), $project->title);
    $module->value = $modelmarket->getTotalActiveCarts();
    $module->image = 'imgCart';
    $module->moduleid = 'car';
    $module->groupname = 'bp';
    $project->modules[] = $module;
}
