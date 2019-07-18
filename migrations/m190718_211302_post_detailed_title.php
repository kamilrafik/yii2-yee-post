<?php

use yii\db\Migration;

class m190718_211302_post_detailed_title extends Migration
{
    const POST_LANG_TABLE = '{{%post_lang}}';

    public function safeUp()
    {
        $this->alterColumn(self::POST_LANG_TABLE, 'detailed_title', $this->text()->null());
    }
}