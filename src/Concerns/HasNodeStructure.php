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
        static::creating(function ($model) {
            if (!$model->nodeStructure) {
                $nodeStructure = $model->nodeStructure()->create([]);
                $model->fortles_node_structure_id = $nodeStructure->id;
            }
        });
    }

    /**
     * Get the node structure associated with the model.
     */
    public function nodeStructure()
    {
        return $this->belongsTo(NodeStructure::class);
    }

    /**
     * Get the node environment (implementation can vary based on your needs).
     *
     * @return NodeEnvironment
     */
    public function getNodeEnvironmentAttribute(): NodeEnvironment
    {
        // Return the node environment, perhaps from the associated NodeStructure
        return $this->nodeStructure->environment ?? null;
    }

    /**
     * Run a specific node or a default one if the name is not provided.
     *
     * @param string|null $name
     * @return mixed
     */
    public function runNode(string $name = null)
    {
        return $this->nodeStructure->run();
    }
}