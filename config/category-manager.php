<?php

return [
    'default_category_type' => 'default',

    'types' => [
        'blog' => [
            'name' => 'Blog',
            'has_description' => true,
            'has_image' => true,
        ],
        'course' => [
            'name' => 'Course',
            'has_description' => true,
            'has_image' => true,
        ],
        'product' => [
            'name' => 'Product',
            'has_description' => true,
            'has_image' => true,
        ],
    ],

    'max_depth' => 5,
];
