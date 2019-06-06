<?php

namespace backend\controllers;

use Yii;
use common\models\Travel;
use common\models\Vehicle;
use common\models\OperatorVehicleType;
use common\models\User;
use common\models\TravelVehicle;
use backend\models\TravelForm;
use backend\models\TravelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TravelController implements the CRUD actions for Travel model.
 */
class TravelController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['index', 'view', 'create', 'update', 'delete', 'get-vehicles', 'get-operators'],
                 'rules' => [
                     [
                         'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-vehicles', 'get-operators'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Travel models.
     * @return mixed
     */
    public function actionIndex($type = null)
    {
        $searchModel = new TravelSearch();
        $dataProvider = $searchModel->search($type, Yii::$app->request->queryParams);

        return $this->render('index', [
            'type' => $type,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Travel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetVehicles($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [];
        foreach(Vehicle::find()->where([
                'vehicle_type_id' => $id, 
            ])->all() as $vehicle) {

            $data[] = ['id' => $vehicle->id, 'label' => $vehicle->getFormatted('label')];
        }

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function actionGetOperators($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $vehicle = Vehicle::findOne($id);
        
        $users_id = array_values(ArrayHelper::map(OperatorVehicleType::find()->where(['vehicle_type_id' => $vehicle->vehicle_type_id])->all(), 'user_id', 'user_id'));
        
        $data = [];
        $query = User::find();
        $query->joinWith(['profile']);

        if(!empty($query)) {
            $query->where(['optic_user.id' => $users_id]);
        } else {
            $query->where(['1 != 0']);
        }

        if($vehicle->default_operator_id) {
            $query->orderBy("`optic_user`.`id` = {$vehicle->default_operator_id} DESC, `optic_user_profile`.`name` ASC");
        }

        $users = $query->all();
        foreach($users as $user) {
            $data[] = ['id' => $user->id, 'label' => $user->getFormatted('name')];
        }

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    /**
     * Creates a new Travel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($step = 1)
    {
        $model = new TravelForm();
        $tvModel = new TravelVehicle();

        // var_dump($_POST);
        // die();

        if ($model->load(Yii::$app->request->post()) && ( $travel = $model->register() )) {

            if( isset($_POST['TravelVehicleForm']) && is_array($_POST['TravelVehicleForm']) ) {
                
                foreach($_POST['TravelVehicleForm'] as $tvf) {
                    // var_dump($tvf);
                    $travel->addVehicle($tvf);
                }

                // die();
            }
            
            // die();
            return $this->redirect(['index']);
        }

        // die();

        return $this->render('create', [
            'model' => $model,
            'step' => $step,
            'tvModel' => $tvModel,
        ]);
    }

    /**
     * Updates an existing Travel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Travel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Travel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Travel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Travel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
