<?php
namespace Fortles\LaravelNodeEditor\Controllers;

use Fortles\LaravelNodeEditor\Models\NodeStructure;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class NodeEditorController extends Controller
{
    function getStructure($id){
        $nodeStructure = NodeStructure::where('id', $id)->firstOrFail();
        $data = $nodeStructure->environment->load();
        return response()->json($data);
    }

    function saveStructure(Request $request, $id){
        $nodeStructure = NodeStructure::where('id', $id)->firstOrFail();
        $nodeStructure->data = $request->getContent();
        $nodeStructure->save();
    }
    
    function getType($id, string $type){
        $nodeStructure = NodeStructure::where('id', $id)->firstOrFail();
        $data = $nodeStructure->environment->getType($type);
        return response()->json($data);
    }

    function run($id){
        $nodeStructure = NodeStructure::where('id', $id)->firstOrFail();
        $nodeStructure->run(false);
    }

    function test($id){
        $nodeStructure = NodeStructure::where('id', $id)->firstOrFail();
        $nodeStructure->test();
    }
}