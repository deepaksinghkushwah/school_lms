<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=school',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    // enable cache for db
    'enableSchemaCache' => (YII_ENV == 'dev' ? false : true),
    // Duration of schema cache.
    'schemaCacheDuration' => 3600,
    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
];
