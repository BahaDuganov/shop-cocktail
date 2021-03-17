<?php
namespace Mirasvit\Core\Console\Command\I18nFrontCollectPhrasesCommand;

/**
 * Interceptor class for @see \Mirasvit\Core\Console\Command\I18nFrontCollectPhrasesCommand
 */
class Interceptor extends \Mirasvit\Core\Console\Command\I18nFrontCollectPhrasesCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem\DirectoryList $directoryList, \Magento\Setup\Module\I18n\Factory $factory, \Magento\Setup\Module\I18n\Dictionary\Options\ResolverFactory $optionResolverFactory)
    {
        $this->___init();
        parent::__construct($directoryList, $factory, $optionResolverFactory);
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
