<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BasUser */

$this->title = ucfirst($model->user_name);
$this->params['breadcrumbs'][] = ['label' => 'Bas Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bas-user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'user_name',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Reporting Rights', ['#', 'id' => $model->user_id], ['class' => 'btn btn-info']) ?>
    </p>
    <hr>
    

    <div class = 'container'>
        <div class='row'>
            <div class='col-md-5'>
                <div class='row'>
                    <h3 align="center"><strong>All level users whom <?= ucfirst($model->user_name); ?> reports to</strong></h3>
                </div>
                <div class='row'>
                <?php if(sizeof($managers) > 0) { ?>
                    <table class='table table-bordered'>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                    </tr>
                    <?php foreach ($managers as $manager) { ?>
                        <tr>
                            <td><?= Html::a($manager['user_id'], ['view', 'id' => $manager['user_id']]); ?></td>
                            <td><?= Html::a($manager['user_name'], ['view', 'id' => $manager['user_id']]);  ?></td>
                        </tr> 
                    <?php } ?>
                                       
                    </table>
                <?php } 
                    else{ ?>
                    <h3 align="center">No Employees</h3>
                <?php    }
                ?>

                </div>
                
            </div>
            <div class='col-md-2'>  
            </div>
            <div class='col-md-5'>
                <div class='row'>
                    <h3 align="center"><strong>All level users who report to <?= ucfirst($model->user_name); ?></strong></h3>
                </div>
                <div class='row'>
                    <div class='row'>
                    <?php if(sizeof($employees)>0) { ?>
                    <table class='table table-bordered'>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                    </tr>
                    <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td><?= Html::a($employee['user_id'], ['view', 'id' => $employee['user_id']]); ?></td>
                            <td><?= Html::a($employee['user_name'], ['view', 'id' => $employee['user_id']]);  ?></td>
                        </tr> 
                    <?php } ?>
                                       
                    </table>
                    <?php } 
                    else{ ?>
                    <h3 align="center">No Employees</h3>
                <?php    }
                ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
