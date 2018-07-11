<?php
/**
 * @author Alan Barber <alan@cadence-labs.com>
 */
namespace Cadence\AdminPerformance\Helper;

use Magento\Framework\App\ObjectManager;

class Admin extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @var \Magento\Backend\Model\Session\Quote
     */
    protected $sessionQuote;

    protected $request;

    public function __construct(
        \Magento\Framework\App\State $appState,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Helper\Context $context
    )
    {
        $this->appState = $appState;
        $this->request = $request;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->appState->getAreaCode() == \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE;
    }

    /**
     * @return bool
     */
    public function isAdminSalesOrderCreate()
    {
        return $this->isAdmin() && $this->request->getControllerName() == 'order_create';
    }

    /**
     * @return bool
     */
    public function isAdminCustomerIndex()
    {
        return $this->isAdmin()
            && $this->request->getModuleName() == 'customer'
            && $this->request->getControllerName() == 'index';
    }

    /**
     * Retrieve quote session object.
     * Make sure this is only loaded if the area is the admin
     *
     * @return \Magento\Backend\Model\Session\Quote
     */
    public function getSessionQuote()
    {
        if (is_null($this->sessionQuote) && $this->isAdmin()) {
            $this->sessionQuote = ObjectManager::getInstance()->get('\Magento\Backend\Model\Session\Quote');
        }
        return $this->sessionQuote;
    }
}