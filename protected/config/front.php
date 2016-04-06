<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'defaultController' => 'front',
        'components'=>array(
			'clientScript' => array(
				'scriptMap' => array(
					'jquery.js' => 'http://code.jquery.com/jquery-1.8.3.js',
					'jquery.min.js' => 'http://code.jquery.com/jquery-1.8.3.min.js',
				),
			),	
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'urlSuffix'=>'',
                'rules'=>array(
                    'howitworks'=>'front/howitworks',
                    'about'=>'front/about',
                    'forwriters'=>'front/forwriters',
                    'contact'=>'front/contact',
                    'privacy'=>'front/privacy',
                    'terms'=>'front/terms',
                    'blog/rss.xml'=>'blog/rss',
                    'blog/index/<cid:\d+>/<name:[A-Za-z- ]+>'=>'blog/index',
                    //'blog/post/<href:[0-9A-Za-z-]+>'=>'blog/post',
                    'faq/<cid:\d+>'=>'faq/index',
                    array(
                        'class' => 'application.components.BlogUrlRule',
                    ),
                    //'<href:[0-9A-Za-z-]+>'=>'blog/post',
                ),
            ),            
            'user'=>array(
                'class'=>'CustomerWebUser',
                'allowAutoLogin'=>true,
            ),
            'fbinterface'=>array(
                'class'=>'FBInterface',
                //'appID'=>'1484361288499702',
                //'appSecret'=>'cf46e4b11c901185740c59180e065a37',
                'appID'=>'1562953530658610',
                'appSecret'=>'4d199a863756d4ffa854ed147d4022dc',
                
            ),            
       ),
        'params' => array(
            'payments' => array(
                'PayPal' => array(
                   /*
                    'mode' => 'sandbox',
                    'clientId' => 'AbjdQBCDnJxsE94Qko2ciML3Fo9bqnW6giJAOVkmSYiDiwJ5ZnMlcPFBJmO8',
                    'clientSecret' => 'EADJ3BD9_D9720xCSSA-Yu-7Y-t146G94KO8J23rt03sXSpldw0vOZrF7dMk',
                    */
                      
                    'mode' => 'live',
                    'clientId' => 'AUqCakBl9qylOeMpDuiOQXG4-wTvgAcY0LJY_HdLt0-8zG5BQmFiY-Me_9zqmof7zgb1vIUwyQlg2Gnz',
                    'clientSecret' => 'EPAdQok4KSzEQuQZnwqjNFs-VzchgO5exs3jaQNPO4U4TAkQkyAVwCeH3Eav5t8UeMw2QzyGCbecZJtt',                    
                    'currency' => 'USD',
                    'description'=>'NetGeron Payment',
                    //'test_buyer' => 'mailmuchenik-buyer@gmail.com' pwd: mailmuchenik-buyer
                ),
                'Webmoney' => array(
                    //https://merchant.webmoney.ru/conf/guide.asp#properties
                    /*
                    'secretKey' => 'SK409fj29fdj2d09dlkj030213jfdvkljfs094839',
                    'mode' => '1', // 1 - test mode
                    'wmz' => 'Z110034523225',
                     * 
                     */
                    'secretKey' => 'H735h4H8ejDe9%VDRRYHYsERf57gRET',
                    'mode' => '0', // 1 - test mode
                    'wmz' => 'Z346340674657',
                    'description'=>'NetGeron Payment',
                ),
                'TwocheckoutPayment' => array(
                    //https://www.2checkout.com/documentation/checkout/parameters/
                    'SecretWord' => 'tango',
                    'sid' => '901265259', //seller id
                    'sandbox' => true,
                    
                    //4000000000000002 sandbox: netger, pwd: usual + 1
                ),
                'Bitcoin' => array(
                    'xpub' => 'xpub6Caz8swg4xj55VoQ2AFuAWihynG5FgSBiVQxyWE2LVoaKSGUM3JwEZXvpXAhsdSoahkZJQYNJvQVWQdXAX1Hfd2Tom6XUDqGo7c8wDvA4GX',
                    'key'  => 'a3245363-9f00-424f-b1f6-f98116b50280',
                ),
            ),
        ),
    )
);