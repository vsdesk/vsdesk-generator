<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;
use app\models\User;
/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<div class="card">
<div class="card-body">
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>    

<?= "<?php \n " ?>
    $toolbars = [
        ['content' =>
            Html::a('<i class="fa fa-plus"></i>', ['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/create'], ['type' => 'button', 'title' => 'Add ' . $this->title, 'class' => 'btn btn-outline-primary']) . ' ' .
            //Html::a('<i class="fa fa-file-excel"></i>', ['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/parsing'], ['type' => 'button', 'title' => 'Parsing Excel ' . $this->title, 'class' => 'btn btn-danger']) . ' ' .
            Html::a('<i class="fa fa-redo"></i>', ['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/index'], ['data-pjax' => 0, 'class' => 'btn btn-outline-success', 'title' => 'Reset Grid']). ' '.'{dynagridFilter}{dynagridSort}{dynagrid}{toggleData}{export}',
    ]
    ];
    $panels = [
        'heading' => '<h3 class="panel-title"><i class="fa fa-list"></i>  ' . $this->title . '</h3>',
        //'before' => '<div style="padding-top: 7px;"><em>* The table at the right you can pull reports & personalize</em></div>',
    ];
    $columns = [
        ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],
        <?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        
        if($name == 'image'){
            
            echo "     ['attribute' => 'image', 'format' => 'html', 'value' => function($data) { return $data->thumb;}], \n";
         
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
            ['attribute' => 'image', 'format' => 'html', 'value' => function($data) { return $data->thumb;}],
        <?php } elseif($name=='userCreate'){ ?>
            ['attribute' => 'userCreate','format' => 'html','filter' => User::dropdown(),
            'value' => function($data) {
                return $data->userCreateLabel;
            },
        ],
        <?php } elseif($name=='userUpdate'){ ?>
            [
            'attribute' => 'userUpdate',
            'format' => 'html',
            'filter' => User::dropdown(),
            'value' => function($data) {
                return $data->userUpdateLabel;
            },
            ],
            
        <?php }elseif($name=='createDate'){ ?>
            [
            'attribute' => 'createDate',
            'filterType' => GridView::FILTER_DATE,
            'format' => 'raw',
            'width' => '170px',
            'filterWidgetOptions' => [
                'pluginOptions' => ['format' => 'yyyy-mm-dd']
            ],
            ],
            
        <?php }elseif($name=='updateDate'){ ?>
            [
            'attribute' => 'updateDate',
            'filterType' => GridView::FILTER_DATE,
            'format' => 'raw',
            'width' => '170px',
            'filterWidgetOptions' => [
                'pluginOptions' => ['format' => 'yyyy-mm-dd']
            ],
        ],
                
        <?php } else 
            //echo "            '" . $format . "',\n";
        
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        
    }
}
?>
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'dropdown' => false,
            'vAlign' => 'middle',
            'viewOptions' => ['title' => 'view', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
            'updateOptions' => ['title' => 'update', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
            'deleteOptions' => ['title' => 'delete', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-danger'],
        ],
        [
            'class' => 'kartik\grid\CheckboxColumn',
        ],
    ];
    
    $dynagrid = DynaGrid::begin([
                'columns' => $columns,
                'theme' => 'panel-default',
                'showPersonalize' => true,
                'storage' => 'db',
                'allowThemeSetting' => false,
                'allowSortSetting' => true,
                'gridOptions' => [
                    'id' => '<?= StringHelper::basename($generator->modelClass) ?>'.Yii::$app->user->identity->id],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showPageSummary' => false,
                    'resizableColumns' => true,
                    'persistResize' => true,
                    'floatHeader' => true,
                    'striped' => true,
                    'bordered' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'responsiveWrap'=>true,
                    //'hover' => true,
                    'pjax' => true,
                    'panel' => $panels,
                    'toolbar' => $toolbars,
                ],
                'options' => ['id' => '<?= StringHelper::basename($generator->modelClass) ?>'.Yii::$app->user->identity->id] // a unique identifier is important
    ]);

    DynaGrid::end();
<?= "?> " ?>
</div>
</div> 
</div>
