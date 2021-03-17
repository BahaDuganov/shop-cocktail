<?php
namespace KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\LongJobChecker;

/**
 * Interceptor class for @see \KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\LongJobChecker
 */
class Interceptor extends \KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\LongJobChecker implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \KiwiCommerce\CronScheduler\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $dateTime, $scheduleCollectionFactory);
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
