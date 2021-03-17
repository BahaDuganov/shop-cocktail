<?php
namespace Amasty\Fpc\Console\Command\ProcessQueue;

/**
 * Interceptor class for @see \Amasty\Fpc\Console\Command\ProcessQueue
 */
class Interceptor extends \Amasty\Fpc\Console\Command\ProcessQueue implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Fpc\Model\Queue $queue, \Magento\Framework\App\State $state, \Amasty\Fpc\Model\Config $config, $name = null)
    {
        $this->___init();
        parent::__construct($queue, $state, $config, $name);
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
