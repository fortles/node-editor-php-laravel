<?php

namespace Fortles\LaravelNodeEditor\Concerns;
use Fortles\LaravelNodeEditor\Models\NodeStructure;
use Fortles\NodeEditor\NodeEnvironment;

/**
 * @property NodeEnvironment $node_environment
 */

trait HasNodeStructure
{
    protected static function bootHasNodeStructure()
    {
        static::created(function ($model) {
            if (!$model->node_structure) {
                $model->node_structure()->create();
            }
        });

        static::deleted(function ($model) {
            if ($model->node_structure) {
                $model->node_structure()->delete();
            }
        });
    }

    /**
     * Get the node structure associated with the model.
     */
    public function node_structure()
    {
        return $this->morphOne(NodeStructure::class, 'host');
    }

    /**
     * Get the node environment (implementation can vary based on your needs).
     *
     * @return NodeEnvironment
     */
    public function getNodeEnvironmentAttribute(): NodeEnvironment
    {
        // Return the node environment, perhaps from the associated NodeStructure
        return $this->node_structure->environment ?? null;
    }

    /**
     * Run a specific node or a default one if the name is not provided.
     *
     * @param string|null $name
     * @return mixed
     */
    public function runNode(bool $shouldLog = true)
    {
        return $this->node_structure->run($shouldLog);
    }

    /**
     * Gets the node structure id
     */
    public function getNodeStructureIdAttribute(): int{
        return $this->node_structure->id;
    }

    /**
     * Log all errors from the closure
     */
    public function logNodeExecution(\Closure $callback){
        $this->node_structure->log($callback);
    }
}