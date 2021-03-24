<?php
/**
 * User: vishnyakov
 * Date: 31.10.17
 * Time: 17:05
 */

namespace App\User\SearchList;

use App\AbstractSearchList;
use App\Models\User;
use App\Params;
use yii\db\Query;

class UserSearchList extends AbstractSearchList
{

    /**
     * Процесс поиска и заполнение его результатами аттрибута results
     */
    protected function loadResults()
    {
        $this->results = $this->buildQuery()->indexBy('id')->all();
    }

    /**
     * Процесс выяснения общего количества результатов поиска без учета лимитов и запись числа в аттрибут total_count
     */
    protected function loadTotalCount()
    {
        $query = $this->buildQuery();
        $query->select('COUNT(DISTINCT u.id)')
            ->groupBy(null)
            ->orderBy(null)
            ->limit(-1)
            ->offset(null);

        $this->total_count = $query->scalar();
    }

    /**
     * @return Query
     */
    protected function buildQuery()
    {
        $query = new Query();

        $query->from(['u' => User::tableName()])
            ->select('u.*')
            ->where('1=1')
            ->groupBy('u.id');


        $query->orderBy('u.id DESC');

        if (!empty($this->params[Params::SEARCH])) {
            if (is_numeric($this->params[Params::SEARCH])) {
                $query->andWhere(['u.id' => intval($this->params[Params::SEARCH])]);
            } else {
                $query->andWhere([
                    'OR',
                    ['LIKE', 'u.username', $this->params[Params::SEARCH]],
                    ['LIKE', 'u.email', $this->params[Params::SEARCH]],
                ]);
            }
        }

        if (!empty($this->params[Params::USER_TYPE])) {
            $query->andWhere(['u.type' => $this->params[Params::USER_TYPE]]);
        }

        if (!empty($this->params[Params::LIMIT])) {
            $query->limit($this->params[Params::LIMIT]);
        }

        if (!empty($this->params[Params::OFFSET])) {
            $query->offset($this->params[Params::OFFSET]);
        }

        return $query;
    }

    protected function loadTotals()
    {
        // TODO: Implement loadTotals() method.
    }
}