<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
<div class="card">
    <div class="card-header">
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    </div>
    <div class="card-body">

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php

if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        
        if($name=='image'){
            echo "        [
            'attribute' => 'image',
            'format' => 'image',
            'value' => $model->thumbnailTrue, \n"
                    . "]\n";
           
        } elseif($name=='userCreate'){
            echo "      [
            'attribute' => 'userCreate',
            'format' => 'html',
            'filter' => User::dropdown(),
            'value' => function($data) {
                return $data->userCreateLabel;
            },
        ], \n";
        } elseif($name=='userUpdate'){
            echo "         [
            'attribute' => 'userUpdate',
            'format' => 'html',
            'filter' => User::dropdown(),
            'value' => function($data) {
                return $data->userUpdateLabel;
            },
        ],  \n";
            
        }elseif($name=='createDate'){
            echo "      [
            'attribute' => 'createDate',
            'filterType' => GridView::FILTER_DATE,
            'format' => 'raw',
            'width' => '170px',
            'filterWidgetOptions' => [
                'pluginOptions' => ['format' => 'yyyy-mm-dd']
            ],
        ],    \n";
            
        }elseif($name=='updateDate'){
            echo "   [
            'attribute' => 'updateDate',
            'filterType' => GridView::FILTER_DATE,
            'format' => 'raw',
            'width' => '170px',
            'filterWidgetOptions' => [
                'pluginOptions' => ['format' => 'yyyy-mm-dd']
            ],
        ],";
        }
        
        
        else 
            echo "            '" . $name . "',\n";
        
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $name = $column->name;
        if($name=='image'){ ?>
            ['attribute' => 'image','format' => 'image','value' => $model->thumbnailTrue],
        <?php } elseif($name=='userCreate'){ ?>
             [
                'attribute' => 'userCreate',
                'value' => $model->userCreateLabel,
            ],
        <?php } elseif($name=='userUpdate'){ ?>
            [
                'attribute' => 'userUpdate',
                'value' => $model->userUpdateLabel,
            ],
            
        <?php }elseif($name=='createDate'){ ?>
            [
                'attribute' => 'createDate',
                'value' => $model->createDate,
            ],
            
        <?php }elseif($name=='updateDate'){ ?>
            [
                'attribute' => 'updateDate',
                'value' => $model->updateDate,
            ],
                
        <?php } else 
            //echo "            '" . $format . "',\n";
        
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        
    }
}
?>
        ]]) ;?>
    </div>
    <div class="card-footer">
        <div class="card-footer">
    <p>
        <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
</div>
</div>
