<?php

use App\Helpers\Url;

?>
<h2 class="headline text-yellow"> 404</h2>

<div class="error-content">
    <h3><i class="fa fa-warning text-yellow"></i> Упс! Страница не найдена.</h3>

    <p>
        Мы не нашли страницу, которую вы запрашивали.
        Вы можете <a href="<?= Url::toRoute(['/admin']) ?>">вернуться на главную</a>
    </p>
</div>