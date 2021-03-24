<?php


namespace App\Controller;


use App\App;
use App\Params;
use yii\data\Pagination;
use yii\web\Controller;

class BaseController extends Controller
{
    private $pagination;

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->getRequest()->isAjax()) {
            $this->getResponse()->setJsonFormat();
        }

        return true;
    }

    public function getRequest()
    {
        return App::i()->getRequest();
    }

    public function getResponse()
    {
        return App::i()->getResponse();
    }

    public function getCookie()
    {
        return App::i()->getCookie();
    }

    public function getCurrentUser()
    {
        return App::i()->getCurrentUser();
    }

    public function getApp()
    {
        return App::i()->getApp();
    }

    /**
     * @param string $type
     * @param string $message
     */
    public function setFlash($type = 'success', $message = '')
    {
        App::i()->getSession()->setFlash($type, $message);
    }

    public function addFlash($type = 'success', $message = '')
    {
        App::i()->getSession()->addFlash($type, $message);
    }
    /**
     * @param int $total_count
     * @param int $default_page_size
     *
     * @return Pagination
     */
    protected function getPagination($total_count = 0, $default_page_size = 50)
    {
        if (!$this->pagination) {
            $this->pagination                  = new Pagination();

            $this->pagination->pageSizeLimit   = [1, 500];
            $this->pagination->pageParam       = Params::PAGE;
            $this->pagination->pageSizeParam   = Params::PER_PAGE;

            $this->pagination->defaultPageSize = $default_page_size;
            $this->pagination->totalCount      = intval($total_count);
            $this->pagination->route           = $this->id . '/' . $this->action->id;
        }

        return $this->pagination;
    }
}