<?php
namespace Iazel\RegenProductUrl\Console\Command\RegenerateCategoryUrlCommand;

/**
 * Interceptor class for @see \Iazel\RegenProductUrl\Console\Command\RegenerateCategoryUrlCommand
 */
class Interceptor extends \Iazel\RegenProductUrl\Console\Command\RegenerateCategoryUrlCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $state, \Magento\Catalog\Model\ResourceModel\Category\Collection $collection, \Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator $categoryUrlRewriteGenerator, \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory, \Magento\Store\Model\App\Emulation $emulation)
    {
        $this->___init();
        parent::__construct($state, $collection, $categoryUrlRewriteGenerator, $urlPersist, $categoryCollectionFactory, $emulation);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}
