<?php

$vendorDir = dirname(__DIR__);

return array (
  'yiisoft/yii2-swiftmailer' => 
  array (
    'name' => 'yiisoft/yii2-swiftmailer',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/swiftmailer' => $vendorDir . '/yiisoft/yii2-swiftmailer',
    ),
  ),
  'yiisoft/yii2-codeception' => 
  array (
    'name' => 'yiisoft/yii2-codeception',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/codeception' => $vendorDir . '/yiisoft/yii2-codeception',
    ),
  ),
  'yiisoft/yii2-bootstrap' => 
  array (
    'name' => 'yiisoft/yii2-bootstrap',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/bootstrap' => $vendorDir . '/yiisoft/yii2-bootstrap',
    ),
  ),
  'yiisoft/yii2-debug' => 
  array (
    'name' => 'yiisoft/yii2-debug',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/debug' => $vendorDir . '/yiisoft/yii2-debug',
    ),
  ),
  'yiisoft/yii2-gii' => 
  array (
    'name' => 'yiisoft/yii2-gii',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/gii' => $vendorDir . '/yiisoft/yii2-gii',
    ),
  ),
  'yiisoft/yii2-faker' => 
  array (
    'name' => 'yiisoft/yii2-faker',
    'version' => '2.0.1.0',
    'alias' => 
    array (
      '@yii/faker' => $vendorDir . '/yiisoft/yii2-faker',
    ),
  ),
  'sammaye/yii2-solr' =>
      array (
          'name' => 'sammaye/yii2-solr',
          'version' => '9999999-dev',
          'alias' =>
              array (
                  '@sammaye/solr' => $vendorDir . '/sammaye/yii2-solr',
              ),
      ),
  'solarium/solarium' =>
      array (
          'name' => 'solarium/solarium',
          'version' => '2.0.1',
          'alias' =>
              array (
                  '@Solarium' => $vendorDir . '/solarium/solarium/library/Solarium',
              ),
      ),
    'symfony/event-dispatcher' =>
        array (
            'name' => 'symfony/event-dispatcher',
            'version' => '2.5.0',
            'alias' =>
                array (
                    '@Symfony/Component/EventDispatcher' => $vendorDir . '/symfony/event-dispatcher/Symfony/Component/EventDispatcher',
                ),
        ),
);
