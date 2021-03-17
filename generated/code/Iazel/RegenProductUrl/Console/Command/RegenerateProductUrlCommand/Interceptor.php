<?php
namespace Iazel\RegenProductUrl\Console\Command\RegenerateProductUrlCommand;

/**
 * Interceptor class for @see \Iazel\RegenProductUrl\Console\Command\RegenerateProductUrlCommand
 */
class Interceptor extends \Iazel\RegenProductUrl\Console\Command\RegenerateProductUrlCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $state, \Magento\Catalog\Model\ResourceModel\Product\Collection $collection, \Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator $productUrlRewriteGenerator, \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($state, $collection, $productUrlRewriteGenerator, $urlPersist, $storeManager);
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
