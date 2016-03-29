<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'defaultController' => 'task',
        //'theme'=>'blackboot2',
        'components'=>array(
            'user'=>array(
                // this is actually the default value
                'loginUrl'=>array('site/login'),
            ),
            'phpThumb'=>array(
                'class'=>'ext.EPhpThumb.EPhpThumb',
            ),
        ),
));