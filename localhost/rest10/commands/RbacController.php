<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller {
    public function actionInit() {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $teacher = $auth->createRole('teacher');
        $teacher->description = 'Преподаватель';
        $student = $auth->createRole('student');
        $student->description = 'Студент';
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($teacher);
        $auth->add($student);
        $adminManager = $auth->createPermission('adminManager');
        $adminManager->description = 'Администрирование
        ресурсов';
        $auth->add($adminManager);
        $auth->addChild($admin, $adminManager);
        $auth->addChild($manager, $adminManager);
        $auth->assign($admin, 1);
        echo "All right\n";
        return ExitCode::OK;  
    }
}
?>