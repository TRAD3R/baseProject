<?php
/**
 * @var \yii\data\Pagination $pagination
 * @var array $options
 */

use yii\widgets\LinkPager;

$options = array_merge_recursive($options, ['class'=> 'pagination no-margin']);

if($pagination->totalCount > $pagination->defaultPageSize) {
    echo LinkPager::widget([
        'pagination' => $pagination,
        'lastPageLabel' => true,
        'firstPageLabel' => true,
        'options' => $options,
    ]);
}
