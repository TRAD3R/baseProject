<?php

namespace App;

use yii\db\Connection;
use yii\db\Query;

abstract class AbstractSearchList
{

    /**
     * Параметры поиска
     * @var array
     */
    protected $params;

    /**
     * Результаты поиска
     * @var array
     */
    protected $results;

    /**
     * Общее количество результатов поиска не учитывая лимиты
     * @var int
     */
    protected $total_count;

    /**
     * Итоги результатов поиска
     * @var array
     */
    protected $totals;

    /**
     * @var Connection
     */
    protected $db_connection;

    /**
     * Конструктор
     * @param array|null $params
     */
    public function __construct($params = null)
    {
        if ($params !== null) {
            $this->setParams($params);
        }
        $this->init();
    }

    /**
     * Инициализация
     */
    protected function init()
    {

    }

    /**
     * @return Connection
     */
    protected function getDbConnection()
    {
        if ($this->db_connection === null) {
            $this->db_connection = App::i()->getDb();
        }

        return $this->db_connection;
    }

    /**
     * Сеттер соединения с базов (мастер или слейв)
     * @param Connection $db_connection
     * @return $this
     */
    public function setDbConnection(Connection $db_connection)
    {
        $this->db_connection = $db_connection;

        return $this;
    }

    /**
     * Установка параметров поиска
     * @param array $params
     * @param bool  $overwrite
     * @return $this
     */
    public function setParams(array $params, $overwrite = true)
    {
        if ($overwrite) {
            $this->params = $params;
        } else {
            foreach ($params as $key => $value) {
                $this->params[$key] = $value;
            }
        }

        $this->results     = null;
        $this->total_count = null;
        $this->totals      = null;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Процесс поиска и заполнение его результатами аттрибута results
     */
    abstract protected function loadResults();

    /**
     * Процесс выяснения общего количества результатов поиска без учета лимитов и запись числа в аттрибут total_count
     */
    abstract protected function loadTotalCount();

    /**
     * Процесс выяснения тоталов результатов поиска по колонкам
     * Здесь лежит массив, где колонки ключи, а значение - это итог по этой колонке
     */
    abstract protected function loadTotals();

    /**
     * Действия перед выполнением заполнения
     */
    protected function preLoadResults()
    {
    }

    /**
     * Действия после выполнением заполнения
     */
    protected function afterLoadResults()
    {
    }

    /**
     * Вообще здесь можно переопределить $this->result = []
     * таким образом код дальше не будет выполняться
     */
    protected function prepareData()
    {
    }

    /**
     * @return array
     */
    public function getResults()
    {
        $this->prepareData();
        if ($this->results === null) {
            $this->preLoadResults();
            $this->loadResults();
            $this->afterLoadResults();
        }

        return $this->results;
    }

    /**
     * Получение общего количества результатов поиска без учета лимитов
     * @return int
     */
    public function getTotalCount()
    {
        if ($this->total_count === null) {
            $this->loadTotalCount();
        }

        return $this->total_count;
    }

    public function getTotals()
    {
        if ($this->totals === null) {
            $this->loadTotals();
        }

        return $this->totals;
    }

    /**
     * Все по запросу
     * @param string|Query $sql_or_query
     * @return array
     * @throws \yii\db\Exception
     */
    protected function fetchAll($sql_or_query)
    {
        if ($sql_or_query instanceof Query) {
            return $sql_or_query->all($this->db_connection);
        }

        return $this->getDbConnection()->createCommand($sql_or_query)->queryAll();
    }

    /**
     * Получение первого значения из первого строки
     * @param string|Query $sql_or_query
     * @return mixed
     * @throws \yii\db\Exception
     */
    protected function fetchFirstFromFirstRow($sql_or_query)
    {
        if ($sql_or_query instanceof Query) {
            return $sql_or_query->all($this->db_connection);
        }

        return $this->getDbConnection()->createCommand($sql_or_query)->queryScalar();
    }

    /**
     * Все по запросу, чтобы ключом было значение из первого столбца
     * @param string|Query $sql_or_query
     * @return array
     * @throws \yii\db\Exception
     */
    protected function fetchAllFirstColumnAsKey($sql_or_query)
    {
        $result = $this->fetchAll($sql_or_query);
        if (empty($result)) {
            return $result;
        }
        $result_array = [];
        foreach ($result as $row) {
            $values                   = array_values($row);
            $result_array[$values[0]] = $row;
            reset($row);
        }

        return $result_array;
    }

}