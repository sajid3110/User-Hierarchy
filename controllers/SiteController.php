<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\BasUserSearch;
use app\models\BasUser;
use app\models\Roles;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BasUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     /**
     * Displays a single BasUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $managers = $this->fetchEmployees($id,'child_id');
        $employees = $this->fetchEmployees($id,'parent_id');
        $arr = [];
        $model = BasUser::find()->select("user_name")->all();
        
        for ($i=0; $i <sizeof($model) ; $i++) { 
            $arr[$i] = $model[$i]['user_name'];
        } 

        return $this->render('view', [
            'model' => $this->findModel($id),
            'managers' => $managers,
            'employees' => $employees,
            'data' => $arr
        ]);
    }

    /*
    Function to fetch employees at all level
    if $role is child_id, all managers at all levels above are fetched
    if $role is child_id, all employees at all levels below are fetched
    */
    protected function fetchEmployees($id,$role)
    {
        $a = [$id];
        if($role == 'child_id') $role2 = 'parent_id';
        else $role2 = 'child_id';
        for ($i=0; $i < sizeof($a); $i++) {
            $m = (new \yii\db\Query())->select($role2)->from('roles')->where([$role=>$a[$i]]);
            $ids = $m->createCommand()->queryAll();
            foreach ($ids as $id) {
                if (!in_array($id[$role2], $a)) {
                    array_push($a,$id[$role2]);
                }
            }
        }
       $b = array_slice($a,1,sizeof($a));
       $managers = (new \yii\db\Query())->select('*')->from('bas_user')->where(['user_id'=>$b]);
       $man = $managers->createCommand()->queryAll();
       return $man;
    }

    public function actionReportingRights()
    {
        $this->enableCsrfValidation = false;
        $data = Yii::$app->request->post('data');
        $mydata = json_decode($data , true);
        $roles = new Roles();
        $model = BasUser::findOne(['user_name'=>$mydata['name']]);
        $connection = Yii::$app->db;

        if(($mydata['operation'] == 'manager-add') || ($mydata['operation'] == 'manager-edit') || ($mydata['operation'] == 'manager-delete'))
        {
            $parent_id = $model->user_id;
            $child_id = $mydata['user'];
            if($mydata['operation'] == 'manager-add'){
                $roles->parent_id = $parent_id;
                $roles->child_id = $child_id;
                if($roles->save())
                echo "Added Manager";
            }
            else if($mydata['operation'] == 'manager-delete'){
                if(Yii::$app->db->createCommand('DELETE FROM roles WHERE parent_id = ' . $parent_id . ' and child_id = ' . $child_id)->execute())
                echo "Deleted Manager";
            }
            else if($mydata['operation'] == 'manager-edit'){
                $this->redirect('index.php?r=site/update&id=' . $parent_id);
                // echo "edit not implemented yet";
            }
              
        }
        else
        {
            $parent_id = $mydata['user'];
            $child_id = $model->user_id;
            if($mydata['operation'] == 'employee-add'){
                $roles->parent_id = $parent_id;
                $roles->child_id = $child_id;
                if($roles->save())
                echo "Added Employee";
            }
            else if($mydata['operation'] == 'employee-delete'){
                if(Yii::$app->db->createCommand('DELETE FROM roles WHERE parent_id = ' . $parent_id . ' and child_id = ' . $child_id)->execute())
                echo "Deleted Employee";
            }
            else if($mydata['operation'] == 'employee-edit'){
                $this->redirect('index.php?r=site/update&id=' . $child_id);
            }
        }
    }

    /**
     * Creates a new BasUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BasUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BasUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BasUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BasUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BasUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BasUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
