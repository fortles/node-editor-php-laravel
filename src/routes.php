<?php
use Fortles\LaravelNodeEditor\Controllers\NodeEditorController;
Route::prefix(config('fortles-node-editor.route_prefix'))->group(function () {
    Route::get('/structures/{nodeStructure}', [NodeEditorController::class, 'getStructure'])->name("fortles.node-editor.structure.show");
    Route::post('/structures/{nodeStructure}', [NodeEditorController::class, 'saveStructure'])->name("fortles.node-editor.structure.save");
    Route::get('/structures/{nodeStructure}/run', [NodeEditorController::class, 'run'])->name("fortles.node-editor.structure.run");
    Route::get('/structures/{nodeStructure}/test', [NodeEditorController::class, 'test'])->name("fortles.node-editor.structure.test");
    Route::get('/structures/{nodeStructure}/type/{type}', [NodeEditorController::class, 'getType'])->name("fortles.node-editor.structure.type");
    // ... other routes ...
});