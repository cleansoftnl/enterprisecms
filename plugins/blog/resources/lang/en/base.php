<?php

return [
    'page_title' => 'Blog',

    'admin_menu' => [
        'relations' => 'Posts',
        'categories' => 'Categories',
        'tags' => 'Tags',
    ],

    'relations' => [
        'page_title' => 'Posts',
        'edit_item' => 'Edit post',

        'all' => 'All relations',

        'form' => [
            'create_post' => 'Create new post',
            'edit_item' => 'Edit post',
            'categories' => 'Categories',
            'primary_category' => 'Primary category',
            'tags' => 'Tags',

            'featured_no' => 'No',
            'featured_yes' => 'Yes',
        ],
    ],

    'categories' => [
        'page_title' => 'Categories',
        'edit_item' => 'Edit category',

        'all' => 'All categories',

        'form' => [
            'create_category' => 'Create category',
            'parent_category' => 'Parent category',
        ],
    ],

    'tags' => [
        'page_title' => 'Tags',
        'edit_item' => 'Edit tag',

        'all' => 'All tags',

        'form' => [
            'create_tag' => 'Create tag',
        ],
    ],
];
