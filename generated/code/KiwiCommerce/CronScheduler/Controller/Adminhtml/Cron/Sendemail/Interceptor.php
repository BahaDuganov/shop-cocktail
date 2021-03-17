<?php
namespace KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\Sendemail;

/**
 * Interceptor class for @see \KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\Sendemail
 */
class Interceptor extends \KiwiCommerce\CronScheduler\Controller\Adminhtml\Cron\Sendemail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \KiwiCommerce\CronScheduler\Model\ResourceModel\Schedule\CollectionFactory $scheduleCollectionFactory, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver, \Magento\Store\Model\StoreManagerInterface $storeManager, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $scheduleCollectionFactory, $transportBuilder, $inlineTranslation, $scopeConfig, $dateTime, $senderResolver, $storeManager, $logger);
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
