# vsdesk-generator
yii2 framework generator code with layout template adminlte and base on kartik dynagrid

add via composer :

<pre>"vsdesk/vsdesk-generator": "dev-main"</pre>

setting in your config like these following :

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'vsdesk' => [
                'class' => 'vsdesk\gii\generators\crud\Generator',
            ],
            'vsdeskModel' => [
                'class' => 'vsdesk\gii\generators\model\Generator'
            ]
        ]
    ];
