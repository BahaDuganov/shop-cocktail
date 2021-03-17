<?php

namespace Aislend\Alert\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
	
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$setup->startSetup();
		
        /**
         * Create table 'aislend_alert_stock'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('aislend_alert_stock')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Product alert stock id'
        )->addColumn(
			'email',
			Table::TYPE_TEXT,
			200,
			['nullable' => true],
			'Guest Customer Email'
		)->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Product id'
        )->addColumn(
            'website_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Website id'
        )->addColumn(
            'add_date',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Product alert add date'
        )->addColumn(
            'send_date',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [],
            'Product alert send date'
        )->addColumn(
            'send_count',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Send Count'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Product alert status'
        )->addIndex(
            $setup->getIdxName('aislend_alert_stock', ['product_id']),
            ['product_id']
        )->addIndex(
            $setup->getIdxName('aislend_alert_stock', ['website_id']),
            ['website_id']
        )->addForeignKey(
            $setup->getFkName('aislend_alert_stock', 'website_id', 'store_website', 'website_id'),
            'website_id',
            $setup->getTable('store_website'),
            'website_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName('aislend_alert_stock', 'product_id', 'catalog_product_entity', 'entity_id'),
            'product_id',
            $setup->getTable('catalog_product_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Guest User Alert Stock'
        );
        $setup->getConnection()->createTable($table);

		$setup->endSetup();	
	}	
}