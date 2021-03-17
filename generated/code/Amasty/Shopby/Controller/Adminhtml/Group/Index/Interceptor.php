<?php
namespace Amasty\Shopby\Controller\Adminhtml\Group\Index;

/**
 * Interceptor class for @see \Amasty\Shopby\Controller\Adminhtml\Group\Index
 */
class Interceptor extends \Amasty\Shopby\Controller\Adminhtml\Group\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Amasty\Shopby\Model\GroupAttrFactory $groupAttrFactory, \Amasty\Shopby\Api\Data\GroupAttrRepositoryInterface $groupAttrRepository, \Magento\Backend\Model\SessionFactory $sessionFactory, \Magento\Framework\App\Cache\TypeListInterface $typeList)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $groupAttrFactory, $groupAttrRepository, $sessionFactory, $typeList);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
