<?php
namespace Mirasvit\Report\Console\Command\InfoCommand;

/**
 * Interceptor class for @see \Mirasvit\Report\Console\Command\InfoCommand
 */
class Interceptor extends \Mirasvit\Report\Console\Command\InfoCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $state, \Mirasvit\ReportApi\Api\SchemaInterface $provider, \Mirasvit\ReportApi\Service\SelectServiceFactory $selectServiceFactory)
    {
        $this->___init();
        parent::__construct($state, $provider, $selectServiceFactory);
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
