<?php

namespace Fortles\LaravelNodeEditor\Models;

use Fortles\NodeEditor\Node\InputNode;
use Fortles\NodeEditor\NodeEnvironment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Stores a node structure in the database.
 * 
 * @property int $id
 * @property string $data Data of the node
 * @property NodeEnvironment $environment
 */
class NodeStructure extends Model
{
    protected $nodeEnvironment;
    protected $table = 'fortles_node_structures';

    protected $fillable = [
        'data',
    ];

    public function logs()
    {
        return $this->hasMany(NodeLog::class, 'fortles_node_structure_id');
    }

    public function host(){
        return $this->morphTo();
    }

    public function run($enableLog = true){
        if($enableLog){
            $this->log(fn($environment) => $environment->run());
        }else{
            $this->environment->run();
        }
    }

    /**
     * Log all errors from the closure
     */
    public function log(\Closure $callback){
        $log = NodeLog::create([
            'fortles_node_structure_id' => $this->id,
            'started_at' => Carbon::now()
        ]);
        try{
            $callback($this->environment);
        } catch (\Exception $exception){
            $log->error = $exception->getMessage();
        }finally{
            $log->ended_at = Carbon::now();
            $log->save();
        }
    }

    public function test(){
        $this->environment->test();
    }

    protected function prepareTypeConfig(array $types){
        $result = [];
        foreach($types as $key => $value){
            if(is_int($key)){
                $result[substr($value, strrpos($value, '\\') + 1, -strlen('Node'))] = $value;
            }else{
                $result[$key] = $value;
            }
        }
        return $result;
    }

    protected function createEnvironment(): NodeEnvironment{
        $types = $this->prepareTypeConfig(config('fortles-node-editor.types', []));
        $customizationConfigKey = 'fortles-node-editor.customizations.' . $this->host_type;
        $extraTypes = $this->prepareTypeConfig(config($customizationConfigKey . '.types', []));
        $types = array_filter(array_replace($types, $extraTypes));

        $input = config($customizationConfigKey . '.input', []);

        if($input){
            $types[$input['name'] ?? 'Input'] = InputNode::class;
        }

        if(empty($types)){
            throw new \Exception('fortles-node-editor.types Config should not be empty!');
        }
        $environment = new NodeEnvironment(
            function(){
                return $this->data;
            },
            function($data){
                $this->data = $data;
                $this->save();
            },
            $types,
            [
                'host' => $this->host
            ],
            $input['fields'] ?? []
        );
        return $environment;
    }

    public function getEnvironmentAttribute(): NodeEnvironment{
        if(!$this->nodeEnvironment){
            $this->nodeEnvironment = $this->createEnvironment();
        }
        return $this->nodeEnvironment;
    }
}
