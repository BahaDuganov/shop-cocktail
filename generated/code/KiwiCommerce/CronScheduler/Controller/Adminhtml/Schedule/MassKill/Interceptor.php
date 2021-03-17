<?php
namespace KiwiCommerce\CronScheduler\Controller\Adminhtml\Schedule\MassKill;

/**
 * Interceptor class for @see \KiwiCommerce\CronScheduler\Controller\Adminhtml\Schedule\MassKill
 */
class Interceptor extends \KiwiCommerce\CronScheduler\Controller\Adminhtml\Schedule\MassKill implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \KiwiCommerce\CronScheduler\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Ui\Component\MassAction\Filter $filter)
    {
        $this->___init();
        parent::__construct($context, $scheduleCollectionFactory, $dateTime, $filter);
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
