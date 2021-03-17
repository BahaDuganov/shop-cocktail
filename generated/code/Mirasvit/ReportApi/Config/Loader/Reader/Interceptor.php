<?php
namespace Mirasvit\ReportApi\Config\Loader\Reader;

/**
 * Interceptor class for @see \Mirasvit\ReportApi\Config\Loader\Reader
 */
class Interceptor extends \Mirasvit\ReportApi\Config\Loader\Reader implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Config\FileResolverInterface $fileResolver, \Mirasvit\ReportApi\Config\Loader\Converter $converter, \Mirasvit\ReportApi\Config\Loader\SchemaLocator $schemaLocator, \Magento\Framework\Config\ValidationStateInterface $validationState, $fileName = 'mst_report.xml', $idAttributes = [], $domDocumentClass = 'Magento\\Framework\\Config\\Dom', $defaultScope = 'global')
    {
        $this->___init();
        parent::__construct($fileResolver, $converter, $schemaLocator, $validationState, $fileName, $idAttributes, $domDocumentClass, $defaultScope);
    }

    /**
     * {@inheritdoc}
     */
    public function getFiles($scope)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFiles');
        if (!$pluginInfo) {
            return parent::getFiles($scope);
        } else {
            return $this->___callPlugins('getFiles', func_get_args(), $pluginInfo);
        }
    }
}
