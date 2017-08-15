<?php

namespace app\modules\group;

/**
 * group module definition class
 */
class GroupMoudule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\group\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = "main.php";
        // custom initialization code goes here
    }
}
