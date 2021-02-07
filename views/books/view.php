<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Books */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
// echo $model->authors[0].PHP_EOL;
// var_dump($model->authors[0]);
// var_dump($model->categories);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
				'attribute'=>'thumbnail',
				'value'=>'@web/thumbnails/'.$model->isbn .'/'.$model->thumbnail,
				'format' => ['image',['width'=>'100']],
			],
            'isbn',
            'page_count',
            'published_date',
            'short_description:ntext',
            'long_description:ntext',
            'status',
			'authorsList',
			'categoriesList'
        ],
    ]) ?>

</div>
<?php
/*
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<div 
		class="table"
	>
		<div
			class="table__row"
		>
			<div
				class="table__cell"
			>
				
			</div>
			<div
				class="table__cell"
			>
				
			</div>
		</div>
		
			<div
				class="table__row"
			>
				<div
					class="table__cell"
				>
				
				</div>
			
			</div>
	</div>

</div>

