<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;



/**
 * Description of UserController
 *
 * @author sidzi
 */
class UserController extends BaseController {
    
use yii\data\ActiveDataProvider;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
    
    public function actionIndex() {
        return new ActiveDataProvider([
'query' => User::find(),
]);
    }
    
    public function actionCreate() {
        $user = new User();
        return $this->saveModel($user);
    }
    public function actionUpdate() {
      $user = $this->findModel($id);
return $this->saveModel($user);  
    }
    
    public function actionView($id) {
        return $this->findModel($id);
    }
    
    public function saveModel($user) {
        if ($user->load(Yii::$app->getRequest()->getBodyParams(), '') && $user->save()) {
            $response = Yii::$app->getResponse();
$response->setStatusCode(201);
$response->getHeaders()->set('Location',
Url::toRoute(['view', 'id' => $user->getPrimaryKey()],
true));
} elseif (!$user->hasErrors()) {
throw new
ServerErrorHttpException(serialize($user->getErrors()));
}

return $user;
        }
        
        public function findModel($id){
            $user = User::findOne($id);
if ($user === null) {
throw new NotFoundHttpException("User with ID $id not found");
}
return $user;
        }
    }
   
