<?php
namespace Mirasvit\Report\Repository\ReportRepository;

/**
 * Interceptor class for @see \Mirasvit\Report\Repository\ReportRepository
 */
class Interceptor extends \Mirasvit\Report\Repository\ReportRepository implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, array $reports = [])
    {
        $this->___init();
        parent::__construct($objectManager, $reports);
    }

    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getList');
        if (!$pluginInfo) {
            return parent::getList();
        } else {
            return $this->___callPlugins('getList', func_get_args(), $pluginInfo);
        }
    }
}
