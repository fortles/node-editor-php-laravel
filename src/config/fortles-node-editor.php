<?php
return [
    'route_prefix' => 'fortles/node-editor',
    'asset_route_prefix' => 'vendor/fortles/node-editor',
    'types' => [
        /** Global node types can be added here
        * FancyNode::class
        * 'CustomName' => FancyNode::class
        */
    ],
    'extra_types' => [
        /** Custom node types for the given model can be added here
        * HostModel::class => [
        *     ExtraNode::class
        * ]
        */
    ]
];