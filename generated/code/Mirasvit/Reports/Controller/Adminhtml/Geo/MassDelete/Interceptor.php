<?php
namespace Mirasvit\Reports\Controller\Adminhtml\Geo\MassDelete;

/**
 * Interceptor class for @see \Mirasvit\Reports\Controller\Adminhtml\Geo\MassDelete
 */
class Interceptor extends \Mirasvit\Reports\Controller\Adminhtml\Geo\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Mirasvit\Reports\Model\ResourceModel\Postcode\CollectionFactory $postcodeCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $postcodeCollectionFactory);
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
