<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BasUser */

$this->title = 'Create Bas User';
$this->params['breadcrumbs'][] = ['label' => 'Bas Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bas-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
