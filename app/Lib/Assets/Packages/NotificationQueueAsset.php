<?php

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class NotificationQueueAsset
 * @package App\Assets\Packages
 */
class NotificationQueueAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@packages';

    /** @var array */
    public $js         = [
        'notification-queue/notification_queue.js',
    ];

    /** @var array */
    public $depends    = [
        GritterAsset::class,
        VisibilityAsset::class,
    ];
}
