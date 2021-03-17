<?php
namespace Iazel\RegenProductUrl\Console\Command\RegenerateCategoryPathCommand;

/**
 * Interceptor class for @see \Iazel\RegenProductUrl\Console\Command\RegenerateCategoryPathCommand
 */
class Interceptor extends \Iazel\RegenProductUrl\Console\Command\RegenerateCategoryPathCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $state, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory, \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $categoryUrlPathGenerator, \Magento\UrlRewrite\Model\UrlPersistInterface $urlPersist, \Magento\Framework\EntityManager\EventManager $eventManager, \Magento\Catalog\Model\ResourceModel\Category $categoryResource, \Magento\Store\Model\App\Emulation $emulation)
    {
        $this->___init();
        parent::__construct($state, $categoryCollectionFactory, $categoryUrlPathGenerator, $urlPersist, $eventManager, $categoryResource, $emulation);
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
