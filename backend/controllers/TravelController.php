<?php

namespace backend\controllers;

use Yii;
use common\models\Travel;
use common\models\Vehicle;
use common\models\OperatorVehicleType;
use common\models\User;
use common\models\TravelVehicle;
use common\models\VehicleType;
use common\models\Service;
use backend\models\TravelForm;
use backend\models\TravelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use Moment\Moment;

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
                 'only' => ['index', 'view', 'create', 'update', 'delete', 'get-vehicle-type', 'quote'],
                 'rules' => [
                     [
                         'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-vehicle-type', 'quote'],
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

    public function actionQuote()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new TravelForm();
        if($model->load(Yii::$app->request->post()) 
            && $model->validate()) {

            $quote = ['subtotal' => 0, 'service' => 0, 'additional' => 0, 'total' => 0];

            if( isset($_POST['TravelVehicleForm']) && is_array($_POST['TravelVehicleForm']) ) {
                foreach($_POST['TravelVehicleForm'] as $tvf) {
                    $tvf['from_zone_id'] = $model->from_zone_id;
                    $tvf['to_zone_id'] = $model->to_zone_id;
                    $tvf['date'] = $model->date;
                    $tvf['pickup'] = $model->pickup;
                    $tvf['dropoff'] = $model->dropoff;
                    $quote['subtotal'] += Travel::quoteVehicle($model->client_id, $model->type, $tvf);
                }
            }

            if( isset($_POST['TravelVehicle']) && is_array($_POST['TravelVehicle']) ) {
                foreach($_POST['TravelVehicle'] as $tvf) {
                    $tvf['from_zone_id'] = $model->from_zone_id;
                    $tvf['to_zone_id'] = $model->to_zone_id;
                    $tvf['date'] = $model->date;
                    $tvf['pickup'] = $model->pickup;
                    $tvf['dropoff'] = $model->dropoff;
                    $quote['subtotal'] += Travel::quoteVehicle($model->client_id, $model->type, $tvf);
                }
            }

            $quote['total'] = $quote['service'] + $quote['subtotal'] + $quote['additional'];

            $service = Service::find()->where(['id' => $model->service_id])->one();
            if($service != null) {
                $quote['service'] = $service->price;
            }

            return [
                'success' => true,
                'data' => [
                    'subtotal' => sprintf('$ %s', number_format($quote['subtotal'], 2)),
                    'service' => sprintf('$ %s', number_format($quote['service'], 2)),
                    'additional' => sprintf('$ %s', number_format($quote['additional'], 2)),
                    'total' => sprintf('$ %s', number_format($quote['total'], 2)),
                ],
            ];
        }

        return [ 'success' => false, 'dataw' => $model->attributes, 'data' => $model->getErrors() ];
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

    public function actionGetVehicleType($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = VehicleType::findOne($id);

        if($model != null) {

            $vehicles = [];
            foreach(Vehicle::find()->where([
                    'vehicle_type_id' => $model->id, 
                ])->all() as $vehicle) {

                $vehicles[] = ['id' => $vehicle->id, 'label' => $vehicle->getFormatted('label')];
            }
      
            // - - - - -
            
            $users_id = array_values(ArrayHelper::map(OperatorVehicleType::find()->where(['vehicle_type_id' => $model->id])->all(), 'user_id', 'user_id'));
            
            $operators = [];
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
                $operators[] = ['id' => $user->id, 'label' => $user->getFormatted('name')];
            }

            // - - - - -

            $data = $model->attributes;
            $data['vehicles'] = $vehicles;
            $data['operators'] = $operators;

            return [
                'success' => true,
                'data' => $data,
            ];
        }

        return [
            'success' => false,
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

        if ($model->load(Yii::$app->request->post()) && ( $travel = $model->register() )) {
            if( isset($_POST['TravelVehicleForm']) && is_array($_POST['TravelVehicleForm']) ) {
                foreach($_POST['TravelVehicleForm'] as $tvf) {
                    $travel->addVehicle($tvf);
                }
            }

            return $this->redirect(['index']);
        }

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
        $travel = $this->findModel($id);

        $model = new TravelForm();
        $model->attributes = $travel->attributes;

        $pickup = new Moment($model->pickup);
        $dropoff = new Moment($model->dropoff);

        $model->date = $pickup->format('d/m/Y');
        $model->pickup = $pickup->format('H:i');
        $model->dropoff = $dropoff->format('H:i');

        $tvModel = new TravelVehicle();

        if ($model->load(Yii::$app->request->post()) && $model->updateData($travel)) {
            if( isset($_POST['TravelVehicleForm']) && is_array($_POST['TravelVehicleForm']) ) {
                foreach($_POST['TravelVehicleForm'] as $tvf) {
                    $travel->addVehicle($tvf);
                }
            }

            if( isset($_POST['TravelVehicle']) && is_array($_POST['TravelVehicle']) ) {
                foreach($_POST['TravelVehicle'] as $id => $tv) {
                    // var_dump($id);
                    // var_dump($tv);
                    // die();
                    $travel->updateVehicle($id, $tv);
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'travel' => $travel,
            'model' => $model,
            'tvModel' => $tvModel,
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
