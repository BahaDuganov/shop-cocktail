<?php
namespace Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Validate;

/**
 * Interceptor class for @see \Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Validate
 */
class Interceptor extends \Webkul\TimeSlotDelivery\Controller\Adminhtml\TimeSlots\Validate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Webkul\TimeSlotDelivery\Api\TimeSlotsRepositoryInterface $timeSlotRepository, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $date, $searchCriteriaBuilder, $filterBuilder, $timeSlotRepository, $resultJsonFactory);
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
