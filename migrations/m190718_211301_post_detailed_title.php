<?php

use yii\db\Migration;

class m190718_211301_post_detailed_title extends Migration
{
    const POST_LANG_TABLE = '{{%post_lang}}';

    public function safeUp()
    {
        $this->addColumn(self::POST_LANG_TABLE, 'detailed_title', $this->string(255)->null());
    }

    public function safeDown()
    {
        $this->dropColumn(self::POST_LANG_TABLE, 'detailed_title');
    }
}