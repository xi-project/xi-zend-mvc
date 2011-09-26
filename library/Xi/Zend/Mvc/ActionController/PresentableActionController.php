<?php
namespace Xi\Zend\Mvc\ActionController;

/**
 * Marker interface for Presentable ActionController classes
 */
interface PresentableActionController
{
    /**
     * @return \Xi\Zend\Mvc\Presenter
     */
    public function getPresenter();
    
    /**
     * @return string
     */
    public function getPresenterClassName();
}