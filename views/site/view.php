<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;

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
        <?= Html::button($content = 'Reporting Rights', $options = ['class'=>'btn btn-success' , 'data-toggle'=>'modal' , 'data-target'=>'#myModal']) ?>
    </p>
    <hr>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Reporting Rights</h3>
        </div>
        <div class="modal-body">
          <p>
            <h4>Users Reporting To <?= ucfirst($model->user_name); ?></h4> 
            <form>
                <?php 
                    if(sizeof($data)>0){
                        echo Typeahead::widget([
                        'name' => 'employee-name',
                        'options' => ['placeholder' => 'Enter Employee' , 'id'=>'employee-name'],
                        'pluginOptions' => ['highlight'=>true],
                        'dataset' => [
                            [
                                'local' => $data,
                                'limit' => 10
                            ]
                        ]
                    ]);
                    }
                    else{
                        echo "There are no employees";
                    }
                    
                ?>
                <br/>
                <?= Html::button($content = 'Add', $options = ['class'=>'btn btn-success btn-sm' , 'id'=>'employee-add']); ?>
                <?= Html::button($content = 'Edit', $options = ['class'=>'btn btn-info btn-sm' , 'id'=>'employee-edit']); ?>
                <?= Html::button($content = 'Delete', $options = ['class'=>'btn btn-danger btn-sm' , 'id'=>'employee-delete']); ?>
            </form>    
          </p>
          <br/><hr>
          <p>
            <h4>Users To Whom <?= ucfirst($model->user_name); ?> Reports To</h4> 
            <form>
                <?php 
                    if(sizeof($data)>0){
                        echo Typeahead::widget([
                        'name' => 'manager-name',
                        'options' => ['placeholder' => 'Enter Manager' , 'id'=>'manager-name'],
                        'pluginOptions' => ['highlight'=>true],
                        'dataset' => [
                            [
                                'local' => $data,
                                'limit' => 10
                            ]
                        ]
                    ]);
                    }
                    else{
                        echo "There are no managers";
                    }
                    
                ?>
                <br/>
                <?= Html::button($content = 'Add', $options = ['class'=>'btn btn-success btn-sm' , 'id'=>'manager-add']); ?>
                <?= Html::button($content = 'Edit', $options = ['class'=>'btn btn-info btn-sm' , 'id'=>'manager-edit']); ?>
                <?= Html::button($content = 'Delete', $options = ['class'=>'btn btn-danger btn-sm' , 'id'=>'manager-delete']); ?>
            </form>   
          </p>
          <br/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

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
                    <h3 align="center">No Managers</h3>
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
<?php
$script = <<<JS
    $(document).ready(function(){
        var answerJson;
        $('#manager-add').click(function(){
            var answerJson = {
                'name':$('#manager-name').val(),
                'operation' : this.id,
                'user' :  $model->user_id 
            };
            submit(answerJson);
        });
        $('#manager-edit').click(function(){
            var answerJson = {
                'name':$('#manager-name').val(),
                'operation' : this.id,
                'user' :  $model->user_id 
            };
            submit(answerJson);
        });
        $('#manager-delete').click(function(){
            var answerJson = {
                'name':$('#manager-name').val(),
                'operation' : this.id,
                'user' :  $model->user_id 
            };
            submit(answerJson);
        });
        $('#employee-add').click(function(){
            var answerJson = {
                'name':$('#employee-name').val(),
                'operation' : this.id,
                'user' :  $model->user_id 
            };
            submit(answerJson);
        });
        $('#employee-edit').click(function(){
            var answerJson = {
                'name':$('#employee-name').val(),
                'operation' : this.id,
                'user' : $model->user_id
            };
            submit(answerJson);
        });
        $('#employee-delete').click(function(){
            var answerJson = {
                'name':$('#employee-name').val(),
                'operation' : this.id,
                'user' : $model->user_id 
            };
            submit(answerJson);
        });
    });

    function submit(Json)
    {
        $.post("index.php?r=site/reporting-rights" ,
                    {
                        data : JSON.stringify(Json),
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        _csrf: yii.getCsrfToken(),
                    } , function(data){
                           alert(data);
                           location.reload();
                    });
                    
    }
JS;
$this->registerJS($script);
?>