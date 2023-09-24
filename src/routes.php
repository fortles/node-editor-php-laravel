<?php
use Fortles\LaravelNodeEditor\Controllers\NodeEditorController;
Route::prefix(config('fortles-node-editor.route_prefix'))->group(function () {
    Route::get('/structures/{id}', [NodeEditorController::class, 'getStructure'])->name("fortles.node-editor.structure.show");
    Route::get('/structures/{id}/type/{type}', [NodeEditorController::class, 'getType']);
    // ... other routes ...
});