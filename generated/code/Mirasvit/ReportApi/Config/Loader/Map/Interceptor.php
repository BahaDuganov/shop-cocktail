<?php
namespace Mirasvit\ReportApi\Config\Loader\Map;

/**
 * Interceptor class for @see \Mirasvit\ReportApi\Config\Loader\Map
 */
class Interceptor extends \Mirasvit\ReportApi\Config\Loader\Map implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\ReportApi\Config\Schema $schema, \Magento\Framework\ObjectManagerInterface $objectManager, \Mirasvit\ReportApi\Service\TableService $tableService, \Mirasvit\ReportApi\Config\Loader\Data $data)
    {
        $this->___init();
        parent::__construct($schema, $objectManager, $tableService, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        if (!$pluginInfo) {
            return parent::load();
        } else {
            return $this->___callPlugins('load', func_get_args(), $pluginInfo);
        }
    }
}
