<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

/**
 * Description of LessonNumController
 *
 * @author sidzi
 */
use yii\data\ActiveDataProvider;
use app\models\LessonNum;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class LessonnumController extends BaseController
{

    public function actionIndex()
    {
        return new ActiveDataProvider(['query' => LessonNum::find()]);
    }

    public function actionCreate()
    {
        $lessonnum = new LessonNum();
        return $this->saveModel($lessonnum);
    }

    public function actionUpdate($id)
    {
        $lessonnum = $this->findModel($id);
        return $this->saveModel($lessonnum);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function saveModel($lessonnum)
    {
        if ($lessonnum->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $lessonnum->getPrimaryKey()], true));
} elseif (!$lessonnum->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($lessonnum->getErrors()));
        }
        return $lessonnum;
    }

    public function findModel($id)
    {
        $lessonnum = LessonNum::findOne($id);
        if ($lessonnum === null) {
            throw new NotFoundHttpException("Special with ID $id not found");
        }
        return $lessonnum;
    }
   
}
