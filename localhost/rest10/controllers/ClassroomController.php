<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of ClassroomController
 *
 * @author sidzi
 */
use yii\data\ActiveDataProvider;
use app\models\Classroom;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class ClassroomController extends BaseController
{

    public function actionIndex()
    {
        return new ActiveDataProvider(['query' => Classroom::find()]);
    }

    public function actionCreate()
    {
        $classroom = new Classroom();
        return $this->saveModel($classroom);
    }

    public function actionUpdate($id)
    {
        $classroom = $this->findModel($id);
        return $this->saveModel($classroom);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function saveModel($classroom)
    {
        if ($classroom->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $classroom->getPrimaryKey()], true));
} elseif (!$classroom->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($classroom->getErrors()));
        }
        return $classroom;
    }

    public function findModel($id)
    {
        $classroom = Classroom::findOne($id);
        if ($classroom === null) {
            throw new NotFoundHttpException("Special with ID $id not found");
        }
        return $classroom;
    }
   
}