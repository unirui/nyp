<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
/**
 * Description of RbacController
 *
 * @author sidzi
 */
class RbacController extends Controller{
    public function actionInit() {
     $auth = Yii::$app->authManager;
$admin = $auth->createRole('admin');
$admin->description = '�������������';
$manager = $auth->createRole('manager');
$manager->description = '��������';
$teacher = $auth->createRole('teacher');
$teacher->description = '�������������';
$student = $auth->createRole('student');
$student->description = '�������';
$auth->add($admin);
$auth->add($manager);
$auth->add($teacher);
$auth->add($student);
$adminManager = $auth->createPermission('adminManager');
$adminManager->description = '����������������� ��������';
$auth->add($adminManager);
$auth->addChild($admin, $adminManager);
$auth->addChild($manager, $adminManager);
$auth->assign($admin, 1);
echo "All right\n";
return ExitCode::OK;   
    }
}
