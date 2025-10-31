<?php
namespace app\controllers\api;

use yii\web\Controller;
use yii\web\Response;

class SmsController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionSend()
    {
        $phone = \Yii::$app->request->post('phone');
        
        if (empty($phone)) {
            return ['success' => false, 'error' => 'Номер телефона обязателен'];
        }

        if (!$this->validatePhone($phone)) {
            return ['success' => false, 'error' => 'Неверный формат номера. Используйте: +79991234567'];
        }

        $code = rand(1000, 9999);
        
        return [
            'success' => true, 
            'data' => [
                'message' => 'Код отправлен успешно',
                'code' => $code
            ]
        ];
    }

    public function actionVerify()
    {
        $phone = \Yii::$app->request->post('phone');
        $code = \Yii::$app->request->post('code');

        if (empty($phone) || empty($code)) {
            return ['success' => false, 'error' => 'Номер телефона и код обязательны'];
        }

        if (!$this->validatePhone($phone) || !$this->validateCode($code)) {
            return ['success' => false, 'error' => 'Неверный формат данных'];
        }

        return [
            'success' => true, 
            'data' => ['message' => 'Номер успешно подтвержден!']
        ];
    }

    private function validatePhone($phone): bool
    {
        return preg_match('/^\+7\d{10}$/', $phone);
    }

    private function validateCode($code): bool
    {
        return preg_match('/^\d{4}$/', $code);
    }
}