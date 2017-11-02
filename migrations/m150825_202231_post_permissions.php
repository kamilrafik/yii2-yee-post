<?php

use yeesoft\db\PermissionsMigration;

class m150825_202231_post_permissions extends PermissionsMigration
{

    public function safeUp()
    {
        $this->addPermissionsGroup('post-management', 'Post Management');

        $this->addModel('post', 'Post', yeesoft\post\models\Post::class);
        $this->addModel('post-tag', 'Post Tag', yeesoft\post\models\Tag::class);
        $this->addModel('post-category', 'Post Category', yeesoft\post\models\Category::class);

        $this->addModelToFilter('author-filter', 'post');

        parent::safeUp();
    }

    public function safeDown()
    {
        parent::safeDown();

        $this->removeModel('post-category');
        $this->removeModel('post-tag');
        $this->removeModel('post');
        
        $this->deletePermissionsGroup('post-management');
    }

    public function getPermissions()
    {

        return [
            'post-management' => [
                'view-posts' => [
                    'title' => 'View Posts',
                    'roles' => [self::ROLE_AUTHOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'view'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'grid-sort'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'grid-page-size'],
                    ],
                ],
                'update-posts' => [
                    'title' => 'Update Posts',
                    'child' => ['view-posts'],
                    'roles' => [self::ROLE_AUTHOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'bulk-activate'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'bulk-deactivate'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'toggle-attribute'],
                    ],
                ],
                'create-posts' => [
                    'title' => 'Create Posts',
                    'child' => ['view-posts'],
                    'roles' => [self::ROLE_AUTHOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'create'],
                    ],
                ],
                'delete-posts' => [
                    'title' => 'Delete Posts',
                    'child' => ['view-posts'],
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/default', 'action' => 'bulk-delete'],
                    ],
                ],
                'view-post-categories' => [
                    'title' => 'View Post Categories',
                    'roles' => [self::ROLE_AUTHOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'grid-sort'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'grid-page-size'],
                    ],
                ],
                'update-post-categories' => [
                    'title' => 'Update Post Categories',
                    'child' => ['view-post-categories'],
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'toggle-attribute'],
                    ],
                ],
                'create-post-categories' => [
                    'title' => 'Create Post Categories',
                    'child' => ['view-post-categories'],
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'create'],
                    ],
                ],
                'delete-post-categories' => [
                    'title' => 'Delete Post Categories',
                    'child' => ['view-post-categories'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/category', 'action' => 'bulk-delete'],
                    ],
                ],
                'view-post-tags' => [
                    'title' => 'View Post Tags',
                    'roles' => [self::ROLE_AUTHOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'grid-sort'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'grid-page-size'],
                    ],
                ],
                'update-post-tags' => [
                    'title' => 'Update Post Tags',
                    'child' => ['view-post-tags'],
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'toggle-attribute'],
                    ],
                ],
                'create-post-tags' => [
                    'title' => 'Create Post Tags',
                    'child' => ['view-post-tags'],
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'create'],
                    ],
                ],
                'delete-post-tags' => [
                    'title' => 'Delete Post Tags',
                    'child' => ['view-post-tags'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'post/tag', 'action' => 'bulk-delete'],
                    ],
                ],
            ],
        ];
    }

}
