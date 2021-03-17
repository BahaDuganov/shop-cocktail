<?php
namespace Mirasvit\SearchSphinx\Console\Command\ManageCommand;

/**
 * Interceptor class for @see \Mirasvit\SearchSphinx\Console\Command\ManageCommand
 */
class Interceptor extends \Mirasvit\SearchSphinx\Console\Command\ManageCommand implements \Magento\Framework\Interception\InterceptorInterface
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
