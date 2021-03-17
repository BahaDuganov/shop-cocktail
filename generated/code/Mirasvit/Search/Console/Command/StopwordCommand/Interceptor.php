<?php
namespace Mirasvit\Search\Console\Command\StopwordCommand;

/**
 * Interceptor class for @see \Mirasvit\Search\Console\Command\StopwordCommand
 */
class Interceptor extends \Mirasvit\Search\Console\Command\StopwordCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Search\Repository\StopwordRepository $stopwordRepository, \Mirasvit\Search\Service\StopwordService $stopwordService)
    {
        $this->___init();
        parent::__construct($stopwordRepository, $stopwordService);
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
