<?php
namespace Mirasvit\Search\Console\Command\SynonymCommand;

/**
 * Interceptor class for @see \Mirasvit\Search\Console\Command\SynonymCommand
 */
class Interceptor extends \Mirasvit\Search\Console\Command\SynonymCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mirasvit\Search\Repository\SynonymRepository $repository, \Mirasvit\Search\Service\SynonymService $service)
    {
        $this->___init();
        parent::__construct($repository, $service);
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
