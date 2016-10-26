<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Create new file');
$this->params['breadcrumbs'][] = $this->title;?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>
    Наиболее оптимальный алгоритм создания нового файла, в котором записи из первого файла будут отсортированы по порядку возрастания ID, а для одинаковых ID по хронологии (от более старых к более новым). 
    1. Разбить исходный файл на несколько частей по N-строк с помощью file($path_to_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    2. Отсортировать ID пользователей по возрастанию в каждой части (быстрая сортировка), при совпадении ID отсортировать даты по возрастанию
    3. Выполнить сортировку слиянием всех частей - результат сохранить в новом файле
</div>