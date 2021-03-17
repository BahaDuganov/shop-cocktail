<?php
namespace Mirasvit\Reports\Console\Command\CronCommand;

/**
 * Interceptor class for @see \Mirasvit\Reports\Console\Command\CronCommand
 */
class Interceptor extends \Mirasvit\Reports\Console\Command\CronCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\App\State $state)
    {
        $this->___init();
        parent::__construct($objectManager, $state);
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
