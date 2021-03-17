<?php
namespace KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\Delete;

/**
 * Interceptor class for @see \KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\Delete
 */
class Interceptor extends \KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \KiwiCommerce\CronScheduler\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory, \KiwiCommerce\CronScheduler\Helper\Cronjob $jobHelper, \KiwiCommerce\CronScheduler\Model\Job $jobModel)
    {
        $this->___init();
        parent::__construct($context, $cacheTypeList, $scheduleCollectionFactory, $jobHelper, $jobModel);
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
