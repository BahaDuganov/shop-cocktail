<?php
namespace Mirasvit\Report\Console\Command\TestCommand;

/**
 * Interceptor class for @see \Mirasvit\Report\Console\Command\TestCommand
 */
class Interceptor extends \Mirasvit\Report\Console\Command\TestCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Report\Api\Repository\ReportRepositoryInterface $reportRepository, \Mirasvit\ReportApi\Api\RequestBuilderInterface $requestBuilder, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\App\State $appState)
    {
        $this->___init();
        parent::__construct($reportRepository, $requestBuilder, $objectManager, $appState);
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
