<?php

namespace Fortles\LaravelNodeEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NodeLog extends Model
{
    protected $table = 'fortles_node_logs';

    protected $fillable = [
        'fortles_node_structure_id', 'error',
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
