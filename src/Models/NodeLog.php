<?php

namespace Fortles\LaravelNodeEditor\Models;

use Illuminate\Database\Eloquent\Model;

class NodeLog extends Model
{
    protected $table = 'fortles_node_logs';

    protected $fillable = [
        'fortles_node_structure_id', 'error',
    ];

    public function nodeStructure()
    {
        return $this->belongsTo(NodeStructure::class, 'fortles_node_structure_id', 'id');
    }
}