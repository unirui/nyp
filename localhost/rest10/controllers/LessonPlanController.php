<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use yii\data\ActiveDataProvider;
use app\models\LessonPlan;
use app\models\Schedule;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;

/**
 * Description of LessonPlanController
 *
 * @author sidzi
 */
class LessonPlanController  extends BaseController{
 public function actionIndex()
    {
        $condition1 = $_GET['gruppa'];
        $condition2 = $_GET['user'];
        if ($condition1!=""&&$condition1!=null&&$condition2!=""&&$condition2!=null){
            return new ActiveDataProvider(['query' => LessonPlan::find()->where(['gruppa_id' => $condition1,'user_id' => $condition2])]);
        }
        else{
            return new ActiveDataProvider(['query' => LessonPlan::find()]);
        }
    }

    public function actionCreate()
    {
        $lessonplan = new LessonPlan();
        return $this->saveModel($lessonplan);
    }

    public function actionUpdate($id)
    {
        $lessonplan = $this->findModel($id);
        return $this->saveModel($lessonplan);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }
    
    public function saveModel($lessonplan)
    {
        if ($lessonplan->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',Url::toRoute(['view', 'id' => $lessonplan->getPrimaryKey()], true));
        } 
        elseif (!$lessonplan->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($lessonplan->getErrors()));
        }  
        return $lessonplan;
    }
    public function findModel($id)
    {
        $lessonplan = LessonPlan::findOne($id);
        if ($lessonplan === null) {
            throw new NotFoundHttpException("Lesson Plan with ID$id not found");
        }
        return $lessonplan;
    }
    
}