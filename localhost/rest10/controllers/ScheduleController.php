<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\Schedule;
use app\models\LessonPlan;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;
/**
 * Description of ScheduleController
 *
 * @author sidzi
 */
class ScheduleController extends BaseController{
    public function actionIndex()
    {
        $condition1 = $_GET['gruppa'];
        $condition2 = $_GET['user'];
        if ($condition1!=""&&$condition1!=null&&$condition2!=""&&$condition2!=null){
            $query =(new \yii\db\Query())->select(['lesson_plan.lesson_plan_id'])-> from(['schedule'])->innerJoin('lesson_plan')->where(['lesson_plan.gruppa_id'=>$condition1,'lesson_plan.user_id'=>$condition2]);
            return new ActiveDataProvider(['query' => Schedule::find()->where(['schedule.lesson_plan_id' => $query])]);
        }
        else{
            return new ActiveDataProvider(['query' => Schedule::find()]);
        }
    }

    public function actionCreate()
    {
        $schedule = new Schedule();
        return $this->saveModel($schedule);
    }

    public function actionUpdate($id)
    {
        $schedule = $this->findModel($id);
        return $this->saveModel($schedule);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }
    

    public function saveModel($schedule)
    {
        if ($schedule->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $schedule->getPrimaryKey()], true));
        } 
        elseif (!$schedule->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($schedule->getErrors()));
        }  
        return $schedule;
    }
    public function findModel($id)
    {
        $schedule = Schedule::findOne($id);
        if ($schedule === null) {
            throw new NotFoundHttpException("Schedule with ID $id not found");
        }
        return $schedule;
    }
    
}
