<?php
namespace Fortles\LaravelNodeEditor\Controllers;

use Fortles\LaravelNodeEditor\Models\NodeStructure;
use Illuminate\Routing\Controller;

class NodeEditorController extends Controller
{
    function getStructure(NodeStructure $node){
        $data = $node->environment->load();
        return response()->json($data);
    }

    function saveNodeStructure(){

    }
    
    function getType(NodeStructure $node, int $id, string $type){
        $data = $node->environment->getType($type);
        return response()->json($data);
    }
}