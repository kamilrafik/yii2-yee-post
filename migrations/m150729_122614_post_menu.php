<?php

use yii\db\Migration;

class m150729_122614_post_menu extends Migration
{

    public function up()
    {
        $this->insert('{{%menu_link}}', ['id' => 'admin-menu-post', 'menu_id' => 'admin-menu', 'image' => 'pencil', 'created_by' => 1, 'order' => 3]);
        $this->insert('{{%menu_link}}', ['id' => 'admin-menu-post-index', 'menu_id' => 'admin-menu', 'link' => '/post/default/index', 'parent_id' => 'admin-menu-post', 'created_by' => 1, 'order' => 1]);
        $this->insert('{{%menu_link}}', ['id' => 'admin-menu-post-tag', 'menu_id' => 'admin-menu', 'link' => '/post/tag/index', 'parent_id' => 'admin-menu-post', 'created_by' => 1, 'order' => 2]);
        $this->insert('{{%menu_link}}', ['id' => 'admin-menu-post-category', 'menu_id' => 'admin-menu', 'link' => '/post/category/index', 'parent_id' => 'admin-menu-post', 'created_by' => 1, 'order' => 3]);

        $this->insert('{{%menu_link_lang}}', ['link_id' => 'admin-menu-post', 'label' => 'Posts', 'language' => 'en-US']);
        $this->insert('{{%menu_link_lang}}', ['link_id' => 'admin-menu-post-index', 'label' => 'Posts', 'language' => 'en-US']);
        $this->insert('{{%menu_link_lang}}', ['link_id' => 'admin-menu-post-tag', 'label' => 'Tags', 'language' => 'en-US']);
        $this->insert('{{%menu_link_lang}}', ['link_id' => 'admin-menu-post-category', 'label' => 'Categories', 'language' => 'en-US']);
    }

    public function down()
    {

        $this->delete('{{%menu_link}}', ['like', 'id', 'admin-menu-post-category']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'admin-menu-post-tag']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'admin-menu-post-index']);
        $this->delete('{{%menu_link}}', ['like', 'id', 'admin-menu-post']);
    }

}
