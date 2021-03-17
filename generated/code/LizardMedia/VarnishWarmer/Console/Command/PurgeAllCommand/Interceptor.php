<?php
namespace LizardMedia\VarnishWarmer\Console\Command\PurgeAllCommand;

/**
 * Interceptor class for @see \LizardMedia\VarnishWarmer\Console\Command\PurgeAllCommand
 */
class Interceptor extends \LizardMedia\VarnishWarmer\Console\Command\PurgeAllCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\LizardMedia\VarnishWarmer\Api\VarnishActionManagerInterface $varnishActionManager, $name = null)
    {
        $this->___init();
        parent::__construct($varnishActionManager, $name);
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
