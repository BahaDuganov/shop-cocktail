<?php
namespace KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\MassScheduleNow;

/**
 * Interceptor class for @see \KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\MassScheduleNow
 */
class Interceptor extends \KiwiCommerce\CronScheduler\Controller\Adminhtml\Job\MassScheduleNow implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \KiwiCommerce\CronScheduler\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \KiwiCommerce\CronScheduler\Helper\Schedule $scheduleHelper, \KiwiCommerce\CronScheduler\Helper\Cronjob $jobHelper)
    {
        $this->___init();
        parent::__construct($context, $scheduleCollectionFactory, $timezone, $dateTime, $scheduleHelper, $jobHelper);
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
