import React, { useState } from 'react';


function Checbox() {
  const [masterCheckboxChecked, setMasterCheckboxChecked] = useState(false);
  const [secondaryCheckboxesChecked, setSecondaryCheckboxesChecked] = useState({
    checkbox1: false,
    checkbox2: false,
    checkbox3: false,
  });

  const handleMasterCheckboxChange = () => {
    const newState = !masterCheckboxChecked;
    setMasterCheckboxChecked(newState);
    const checkboxes = { ...secondaryCheckboxesChecked };
    Object.keys(checkboxes).forEach(checkbox => {
      checkboxes[checkbox] = newState;
    });
    setSecondaryCheckboxesChecked(checkboxes);
  };

  const handleSecondaryCheckboxChange = (id) => {
    const checkboxes = { ...secondaryCheckboxesChecked };
    checkboxes[id] = !checkboxes[id];
    setSecondaryCheckboxesChecked(checkboxes);
    const allChecked = Object.values(checkboxes).every(checkbox => checkbox === true);
    setMasterCheckboxChecked(allChecked);
  };

  return (
    <div>
      <input type="checkbox" checked={masterCheckboxChecked} onChange={handleMasterCheckboxChange} />
      <label htmlFor="masterCheckbox">Seleccionar todos los checkboxes</label>

      {Object.keys(secondaryCheckboxesChecked).map(id => (
        <div key={id}>
          <input type="checkbox" id={id} checked={secondaryCheckboxesChecked[id]} onChange={() => handleSecondaryCheckboxChange(id)} />
          <label htmlFor={id}>{id}</label>
        </div>
      ))}
    </div>
  );
}
export default Checbox
<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
