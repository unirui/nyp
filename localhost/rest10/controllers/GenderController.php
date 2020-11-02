<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of GenderController
 *
 * @author sidzi
 */
use yii\data\ActiveDataProvider;
use app\models\Gender;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class GenderController extends BaseController
{

    public function actionIndex()
    {
        return new ActiveDataProvider(['query' => Gender::find()]);
    }

    public function actionCreate()
    {
        $gender = new Gender();
        return $this->saveModel($gender);
    }

    public function actionUpdate($id)
    {
        $gender = $this->findModel($id);
        return $this->saveModel($gender);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function saveModel($gender)
    {
        if ($gender->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $gender->getPrimaryKey()], true));
        } 
        elseif (!$gender->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($gender->getErrors()));
        }  
        return $gender;
    }
    public function findModel($id)
    {
        $gender = Gender::findOne($id);
        if ($gender === null) {
            throw new NotFoundHttpException("Gender with ID $id not found");
        }
        return $gender;
    }
   
}