<?php
/**
 * Created by PhpStorm.
 * User: murder
 * Date: 12/25/14
 * Time: 1:06 AM
 */

use yii\web\UrlRule;
return array(
// REST routes for CRUD operations
    'POST <controller:\w+>s' => '<controller>/create', // 'mode' => UrlRule::PARSING_ONLY will be implicit here
    'api/<controller:\w+>s' => '<controller>/index',
    'PUT api/<controller:\w+>/<id:\d+>' => '<controller>/update',// 'mode' => UrlRule::PARSING_ONLY will be implicit here
    'DELETE api/<controller:\w+>/<id:\d+>' => '<controller>/delete', // 'mode' => UrlRule::PARSING_ONLY will be implicit here
    'api/<controller:\w+>/<id:\d+>' => '<controller>/view',
// normal routes for CRUD operations
    '<controller:\w+>s/create' => '<controller>/create',
    '<controller:\w+>/<id:\d+>/<action:update|delete>' => '<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
    '<module:\w+><controller:\w+>/<action:update|delete>/<id:\d+>' => '<module>/<controller>/<action>',

);