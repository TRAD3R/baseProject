<?php

use App\Helpers\Url;

?>
<h2 class="headline text-yellow"> 403</h2>

<div class="error-content">
    <h3><i class="fa fa-warning text-yellow"></i> Упс! У вас недостаточно прав.</h3>

    <p>
        У вас недостаточно прав для посещения страницы, которую вы запрашивали.
        Вы можете <a href="<?= Url::toRoute(['/admin']) ?>">вернуться на главную</a>
    </p>
</div>