<?php
namespace Mirasvit\Search\Console\Command\ReindexCommand;

/**
 * Interceptor class for @see \Mirasvit\Search\Console\Command\ReindexCommand
 */
class Interceptor extends \Mirasvit\Search\Console\Command\ReindexCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Search\Repository\IndexRepository $indexRepository, \Magento\Framework\App\State $appState, \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->___init();
        parent::__construct($indexRepository, $appState, $objectManager);
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
