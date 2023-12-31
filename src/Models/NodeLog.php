<?php

namespace Fortles\LaravelNodeEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Log of a run
 * @param int $created How many records are created
 * @param int $updated How many records are updated
 * @param int $deleted How many records are deleted
 * @param int $skipped How many records are skipped
 * @param int $fortles_node_structure_id
 * @param string $error
 * 
 * @param NodeStructure $node_structure
 * @param NodeLogStatus $status
 */

class NodeLog extends Model
{
    protected $table = 'fortles_node_logs';

    protected $fillable = [
        'fortles_node_structure_id', 
		'created',
		'updated',
		'deleted',
		'skipped',
		'error',
    ];

    public $timestamps = false;

    public function nodeStructure()
    {
        return $this->belongsTo(NodeStructure::class, 'fortles_node_structure_id', 'id');
    }

    public function getStatusAttribute(): NodeLogStatus{
		if (!$this->exists()) {
			return NodeLogStatus::Initial;
		}
		if($this->ended_at){
			if($this->error){
				return NodeLogStatus::Failed;
			}else{
				return NodeLogStatus::Success;
			}
		}else{
			if(Carbon::now()->diffInSeconds($this->started_at) > config('fortles-node-editor.timeout', 60)){
				return NodeLogStatus::Timeout;
			}else{
				return NodeLogStatus::Running;
			}
		}
	}
}


enum NodeLogStatus: string {
	case Running = 'Running';
	case Failed = 'Failed';
	case Success = 'Success';
	case Timeout = 'Timeout';
	case Initial = 'Initial';
}
