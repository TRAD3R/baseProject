<?php

use App\Helpers\Url;

?>
<h2 class="headline text-red"> 500</h2>

<div class="error-content">
    <h3><i class="fa fa-warning text-red"></i> Упс! Что-то пошло не так.</h3>

    <p>
        Произошла не ведомая ошибка.
        Вы можете <a href="<?= Url::toRoute(['/admin']) ?>">вернуться на главную</a>
    </p>
</div>