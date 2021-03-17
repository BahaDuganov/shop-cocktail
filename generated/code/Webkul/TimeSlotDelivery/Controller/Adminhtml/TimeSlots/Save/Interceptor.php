<?php
namespace Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Save;

/**
 * Interceptor class for @see \Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Save
 */
class Interceptor extends \Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface $timeSlotRepository, \Webkul\TimeSlotDelivery\Model\TimeSlotsFactory $timeSlotFactory, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $timeSlotRepository, $timeSlotFactory, $date, $dataPersistor);
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
