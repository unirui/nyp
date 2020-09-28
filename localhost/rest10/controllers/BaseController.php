<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\rest\Controller;

use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;

class BaseController extends Controller {
    public function behaviors() {
        return [
'contentNegotiator' => [
'class' => ContentNegotiator::class,
'formats' => [
'application/json' =>
Response::FORMAT_JSON,
],
],
'authenticator' => [
'class' => QueryParamAuth::className(),
'tokenParam' => 'token',
],
];
    }
}
