<?php
namespace LizardMedia\VarnishWarmer\Console\Command\PurgeUrlCommand;

/**
 * Interceptor class for @see \LizardMedia\VarnishWarmer\Console\Command\PurgeUrlCommand
 */
class Interceptor extends \LizardMedia\VarnishWarmer\Console\Command\PurgeUrlCommand implements \Magento\Framework\Interception\InterceptorInterface
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
