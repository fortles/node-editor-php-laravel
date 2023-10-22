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
            if (!$model->nodeStructure) {
                $model->nodeStructure()->create();
            }
        });
    }

    /**
     * Get the node structure associated with the model.
     */
    public function nodeStructure()
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

    public function getNodeStructureIdAttribute(): ?int
    {
        return $this->nodeStructure->id ?? null;
    }
}