<?php
/*
 * Aten Software Product Data Exporter for Magento
 *
 * Copyright (c) 2020. Aten Software LLC. All Rights Reserved.
 * Author: Shailesh Humbad
 * Website: https://www.atensoftware.com/p187.php
 *
 * This file is part of Aten Software Product Data Exporter for Magento.
 *
 * Aten Software Product Data Exporter for Magento is free software:
 * you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Aten Software Product Data Exporter for Magento
 * is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * See http://www.gnu.org/licenses/ for a copy of the GNU General Public License.
 *
 * */

// Run the script and show exceptions as an error page
try
{
	// Create the object
	$exporter = new AtenExporterForMagento();

	// Find magento installation directory, version, and bootstrap file
	$BootstrapFileName = $exporter->FindMagentoInstallation();

	// Include the Magento bootstrap file in global context
	require $BootstrapFileName;

	// Run the main function
	$exporter->RunMain();
}
catch (\Exception $e)
{
	AtenExporterForMagento::DisplayErrorPage($e->getMessage());
}


// Class to hold all functionality for the exporter
class AtenExporterForMagento
{
	// Version of this script
	const VERSION = '2020-04-20';

	// External configuration file path
	const CONFIG_FILE = 'aten_exporter_for_magento_config.php';

	// Helper variables
	private $_tablePrefix;
	private $_storeId;
	private $_websiteId;
	private $_mediaBaseUrl;
	private $_webBaseUrl;
	private $_dbi;
	private $_objectManager;
	private $_STATUS_DISABLED_CONST;
	private $IncludeDisabled;
	private $ExcludeOutOfStock;
	private $DownloadAsAttachment;
	private $SinceEntityId;
	private $config;
	private $IsStagingModuleEnabled;
	private $StagingCurrentVersion;
	private $IsMagento2;
	private $CategoryIdToFullPath;

	// Find magento installation directory, version, and bootstrap file
	// Returns bootstrap file name
	public function FindMagentoInstallation()
	{
		// Determine magento root folder
		$MagentoRootFolder = realpath(dirname(__FILE__));
		if(file_exists($MagentoRootFolder.'/app') == false
			|| is_dir($MagentoRootFolder.'/app') == false)
		{
			// Check parent folder if 'app' folder is not in the script's directory
			$MagentoRootFolder = realpath(dirname(__FILE__).'/..');
			if(file_exists($MagentoRootFolder.'/app') == false
				|| is_dir($MagentoRootFolder.'/app') == false)
			{
				throw new Exception(
					"ERROR: Neither ./app nor ../app folders were found. ".
					"Be sure to install this script to the root folder of the website, e.g. pub, www, or public_html.");
			}
		}

		// Set working directory to magento root folder
		chdir($MagentoRootFolder);

		// Determine Magento version and bootstrap file name
		if(file_exists($MagentoRootFolder.'/app/Mage.php') == true)
		{
			$BootstrapFileName = $MagentoRootFolder.'/app/Mage.php';
			$this->IsMagento2 = false;
		}
		elseif(file_exists($MagentoRootFolder.'/app/bootstrap.php') == true)
		{
			$BootstrapFileName = $MagentoRootFolder.'/app/bootstrap.php';
			$this->IsMagento2 = true;
		}
		else
		{
			throw new Exception("ERROR: boostrap.php/Mage.php file not found in ./app or ../app folder");
		}

		// Return bootstrap file name
		return $BootstrapFileName;
	}


	// Initialize PHP configuration and the Mage application
	private function _initializeObjects()
	{
		// Set PHP configuration options (see config file for defaults)
		ini_set('max_execution_time', $this->GetConfigValue('max_execution_time'));
		ini_set('display_errors', $this->GetConfigValue('display_errors'));
		ini_set('error_reporting', $this->GetConfigValue('error_reporting'));
		ini_set('memory_limit', $this->GetConfigValue('memory_limit'));

		// By default, make files written by the profile world-writable/readable
		// (required by Magento)
		umask($this->GetConfigValue('umask'));

		// Initialize Mage application and connect to database
		if($this->IsMagento2)
		{
			// Create bootstrap object
			$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);

			$this->_objectManager = $bootstrap->getObjectManager();

			$deploymentConfig = $this->_objectManager->get('Magento\Framework\App\DeploymentConfig');
			$this->_tablePrefix = $deploymentConfig->get('db/table_prefix');

			$this->_dbi = $this->_objectManager->create('\Magento\Framework\App\ResourceConnection')->getConnection();
		}
		else
		{
			// Initialize the admin application
			Mage::app('admin');

			// Get the table prefix
			$tableName = Mage::getSingleton('core/resource')->getTableName('core_website');
			$this->_tablePrefix = substr($tableName, 0, strpos($tableName, 'core_website'));

			// Get database connection to Magento (PDO MySQL object)
			$this->_dbi = Mage::getSingleton('core/resource') ->getConnection('core_read');
		}

		// Set default fetch mode to NUM to save memory
		$this->_dbi->setFetchMode(ZEND_DB::FETCH_NUM);

		// Check if staging module is enabled
		$this->IsStagingModuleEnabled = $this->_tableExists("PFX_catalog_product_entity", array('row_id'));

		// By default, current version is the default version
		$this->StagingCurrentVersion = 1;

		// Get current staging version
		if($this->IsStagingModuleEnabled == true)
		{
			$query = "SELECT flag_data FROM PFX_flag WHERE flag_code='staging'";
			$query = $this->_applyTablePrefix($query);
			$StagingFlagData = $this->_dbi->fetchOne($query);
			if(is_string($StagingFlagData) == true && $StagingFlagData != '')
			{
				$StagingFlagData = json_decode($StagingFlagData);
				if(is_object($StagingFlagData) == true
					&& isset($StagingFlagData->current_version) == true
					&& intval($StagingFlagData->current_version) >= 1)
				{
					$this->StagingCurrentVersion = intval($StagingFlagData->current_version);
				}
			}
		}

		// Increase maximium length for group_concat (for additional image URLs field)
		$query = "SET SESSION group_concat_max_len = 1000000;";
		$this->_dbi->query($query);

		// Build category lookup table
		$this->_initializeCategoryIdToFullPath();

		// For debugging
		//$this->_debugPrintQuery("SELECT * FROM INFORMATION_SCHEMA.TABLES ORDER BY TABLE_NAME");
	}

	// Run the main application and call the appropriate function
	// depending on the command.
	public function RunMain()
	{
		// Initialize configuration information
		$this->_initializeObjects();

		// Get the command line parameters if running in CLI-mode
		if(self::IsCLI() == true)
		{
			if(isset($_SERVER['argc']) && $_SERVER['argc'] == 2)
			{
				// Get parameters from the command line
				//  and add them to the REQUEST array
				parse_str($_SERVER['argv'][1], $_REQUEST);
			}
		}

		// Get parameters from the REQUEST array
		$Command = isset($_REQUEST['Command']) ? $_REQUEST['Command'] : '';
		$this->_storeId = isset($_REQUEST['Store']) ? $_REQUEST['Store'] : '';
		$Password = isset($_REQUEST['Password']) ? $_REQUEST['Password'] : '';
		$this->ExcludeOutOfStock = (isset($_REQUEST['ExcludeOutOfStock'])
			&& $_REQUEST['ExcludeOutOfStock'] == 'on') ? true : false;
		$this->IncludeDisabled = (isset($_REQUEST['IncludeDisabled'])
			&& $_REQUEST['IncludeDisabled'] == 'on') ? true : false;
		$this->DownloadAsAttachment = (isset($_REQUEST['DownloadAsAttachment'])
			&& ($_REQUEST['DownloadAsAttachment'] == 'on' || $_REQUEST['DownloadAsAttachment'] == '1')) ? true : false;
		$this->SinceEntityId = isset($_REQUEST['SinceEntityId']) ? intval($_REQUEST['SinceEntityId']) : 0;

		// If the command is export, then run the product export
		if($Command == 'Export')
		{
			// Check password
			$this->_checkPassword($Password);

			// Validate store and get information
			$this->_getStoreInformation();

			// Run extraction
			$this->_runProductExport();

			// End script
			return;
		}

		// If the command is export, then run the product categories
		if($Command == 'ExportCategories')
		{
			// Check password
			$this->_checkPassword($Password);

			// Validate store and get information
			$this->_getStoreInformation();

			// Run extraction
			$this->_runCategoryExport();

			// End script
			return;
		}

		// If the command is export table, then run the table export
		if($Command == 'ExportTable')
		{
			// Check password
			$this->_checkPassword($Password);

			// Validate store and get information
			$this->_getStoreInformation();

			// Run extraction
			$this->_runTableExport();

			// End script
			return;
		}

		// If the command is export table, then run the table export
		if($Command == 'DisplayForm')
		{
			// Check password
			$this->_checkPassword($Password);

			// Display user interface
			$this->DisplayForm();

			// End script
			return;
		}

		// If the command is not specified display the password prompt
		if($Command == '')
		{
			$this->DisplayPasswordPrompt();

			// End script
			return;
		}

		// Display an invalid command message
		throw new Exception("ERROR: Invalid Command specified.");
	}

	// Export data from a specific table
	private function _runTableExport()
	{
		// Get the table name
		$TableName = (isset($_REQUEST['TableName']) ? $_REQUEST['TableName'] : '');

		// Set allowed table names
		$AllowedTableNames = $this->GetConfigValue('table_export_allowed_table_names');

		// Validate table name
		if(in_array($TableName, $AllowedTableNames) == false)
		{
			throw new Exception('ERROR: Exporting the table \''.htmlentities($TableName).'\' is prohibited.');
		}

		// Check if the table exists
		if($this->_tableExists("PFX_".$TableName) == false)
		{
			throw new Exception('ERROR: Can not export the table \''.htmlentities($TableName).'\' because it does not exist.');
		}

		// Get all the column names to print the header row
		// NOTE: Used constant TABLE_SCHEMA and TABLE_NAME to avoid directory scans
		$query = "
			SELECT COLUMN_NAME
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_SCHEMA=DATABASE()
				AND TABLE_NAME = :table_name
			ORDER BY ORDINAL_POSITION
		";
		$ColumnNames = $this->_dbi->fetchCol($query,
			array('table_name' => $this->_applyTablePrefix("PFX_".$TableName)));
		if(empty($ColumnNames) == true)
		{
			throw new Exception('ERROR: Could not get columns from table \''.htmlentities($TableName).'\'.');
		}

		// Start sending file
		if(self::IsCLI() == false)
		{
			// Set up a file name
			$FileName = sprintf('%s.csv', $TableName);

			$this->_startFileSend($FileName);
		}

		// Write header line
		$this->_writeCSVLine($ColumnNames);

		// Select all the data in the table
		$query = "SELECT * FROM PFX_".$TableName;
		$query = $this->_applyTablePrefix($query);
		$result = $this->_dbi->query($query);
		while(true)
		{
			// Get next row
			$row = $result->fetch(Zend_Db::FETCH_NUM);
			// Break if no more rows
			if(empty($row))
			{
				break;
			}
			// Write the row
			$this->_writeCSVLine($row);
		}
	}

	// Return entity_type_id for the specified entity_type_code
	private function _getEntityTypeId($EntityTypeCode)
	{
		$query = "
			SELECT entity_type_id
			FROM PFX_eav_entity_type
			WHERE entity_type_code = :entity_type_code
		";
		$query = $this->_applyTablePrefix($query);
		return $this->_dbi->fetchOne($query, array('entity_type_code' => $EntityTypeCode));
	}

	// Return array of entity_id.
	// Also populates attributes codes and attribute options arrays.
	private function _getEntityRows($EntityName, &$attributeCodes, &$attributeOptions, &$AllAttributesQuery)
	{
		// Prepare list entity table names
		if($EntityName == 'product')
		{
			$CatalogEntityTableNamesWithPrefix = array(
				'PFX_catalog_product_entity_datetime',
				'PFX_catalog_product_entity_decimal',
				'PFX_catalog_product_entity_int',
				'PFX_catalog_product_entity_text',
				'PFX_catalog_product_entity_varchar',
			);
			$EntityTableName = 'PFX_catalog_product_entity';

		}
		else if($EntityName == 'category')
		{
			$CatalogEntityTableNamesWithPrefix = array(
				'PFX_catalog_category_entity_datetime',
				'PFX_catalog_category_entity_decimal',
				'PFX_catalog_category_entity_int',
				'PFX_catalog_category_entity_text',
				'PFX_catalog_category_entity_varchar',
			);
			$EntityTableName = 'PFX_catalog_category_entity';
		}
		else
		{
			throw new Exception("ERROR: Invalid EntityName");
		}

		// Get the entity type for categories
		$ENTITY_TYPE_ID = $this->_getEntityTypeId('catalog_'.$EntityName);

		// Get attribute codes and types
		$query = "
			SELECT attribute_id, attribute_code, backend_type, backend_table, frontend_input
			FROM PFX_eav_attribute
			WHERE entity_type_id = :entity_type_id
		";
		$query = $this->_applyTablePrefix($query);
		$attributes = $this->_dbi->fetchAssoc($query, array('entity_type_id' => $ENTITY_TYPE_ID));


		$attributeCodes = array();
		foreach($attributes as $row)
		{
			switch($row['backend_type'])
			{
				case 'datetime':
				case 'decimal':
				case 'int':
				case 'text':
				case 'varchar':
					$attributeCodes[$row['attribute_id']] = $row['attribute_code'];
					break;
				case 'static':
					// ignore columns in entity table
					// print("Skipping static attribute: ".$row['attribute_code']."\n");
					break;
				default:
					// print("Unsupported backend_type: ".$row['backend_type']."\n");
					break;
			}

			// Add table name to list of value tables, if the table exists
			if(isset($row['backend_table']) && $row['backend_table'] != '')
			{
				// Check if table exists without prefix
				if($this->_tableExists($row['backend_table']) === true)
				{
					$CatalogEntityTableNamesWithPrefix[] = $row['backend_table'];
				}
				else
				{
					// If not found, check if table exists with prefix
					$BackendTableWithPrefix = $this->_applyTablePrefix("PFX_".$row['backend_table']);
					if($this->_tableExists($BackendTableWithPrefix) === true)
					{
						$CatalogEntityTableNamesWithPrefix[] = $BackendTableWithPrefix;
					}
				}
			}

			// If the type is multiple choice, cache the option values
			//   in a lookup array for performance (avoids several joins/aggregations)
			if($row['frontend_input'] == 'select' || $row['frontend_input'] == 'multiselect')
			{
				// Get the option_id => value from the attribute options
				$query = "
					SELECT
						 CASE WHEN SUM(aov.store_id) = 0 THEN MAX(aov.option_id) ELSE
							MAX(CASE WHEN aov.store_id = :storeid THEN aov.option_id ELSE NULL END)
						 END AS 'option_id'
						,CASE WHEN SUM(aov.store_id) = 0 THEN MAX(aov.value) ELSE
							MAX(CASE WHEN aov.store_id = :storeid THEN aov.value ELSE NULL END)
						 END AS 'value'
					FROM PFX_eav_attribute_option AS ao
					INNER JOIN PFX_eav_attribute_option_value AS aov
						ON ao.option_id = aov.option_id
					WHERE aov.store_id IN (:storeid, 0)
						AND ao.attribute_id = :attribute_id
					GROUP BY aov.option_id
				";
				$query = $this->_applyTablePrefix($query);
				$result = $this->_dbi->fetchPairs($query, array("storeid" => $this->_storeId, "attribute_id" => $row['attribute_id']));

				// If found, then save the lookup table in the attributeOptions array
				if(is_array($result))
				{
					$attributeOptions[$row['attribute_id']] = $result;
				}
				else
				{
					// Otherwise, leave a blank array
					$attributeOptions[$row['attribute_id']] = array();
				}
				$result = null;
			}

		}

		// Build queries for each attribute type: int, varchar, text, etc.
		$queries = array();
		foreach($CatalogEntityTableNamesWithPrefix as $CatalogEntityTableNameWithPrefix)
		{
			// Get store value if there is one, otherwise, global value
			$AttributeTypeQuery = "
				SELECT
					 CASE
						WHEN SUM(ev.store_id) = 0
						THEN MAX(ev.value)
						ELSE MAX(CASE WHEN ev.store_id = ".$this->_storeId." THEN ev.value ELSE NULL END)
					 END AS 'value'
					,ev.attribute_id
				FROM $CatalogEntityTableNameWithPrefix AS ev
				WHERE ev.store_id IN (".$this->_storeId.", 0)";
			// Magento 1.x has an entity_type_id column
			if($this->IsMagento2 == false)
			{
				$AttributeTypeQuery .= " AND ev.entity_type_id = ".$ENTITY_TYPE_ID." ";
			}

			if($this->IsStagingModuleEnabled)
			{
				// If staging enabled, get current version
				$AttributeTypeQuery .= " AND ev.row_id =
					(SELECT MAX(e.row_id) FROM ".$EntityTableName." AS e
						WHERE e.entity_id = :entity_id
							AND e.created_in <= ".$this->StagingCurrentVersion."
							AND e.updated_in > ".$this->StagingCurrentVersion.") ";
				$AttributeTypeQuery .= " GROUP BY ev.attribute_id, ev.row_id ";
			}
			else
			{
				$AttributeTypeQuery .= " AND ev.entity_id = :entity_id ";
				$AttributeTypeQuery .= " GROUP BY ev.attribute_id, ev.entity_id ";
			}
			$queries[] = $AttributeTypeQuery;
		}

		// Combine all queries using UNION ALL
		$AllAttributesQuery = implode(" UNION ALL ", $queries);
		// Apply table prefix to the query
		$AllAttributesQuery = $this->_applyTablePrefix($AllAttributesQuery);
		// Clean up white-space in the query
		$AllAttributesQuery = trim(preg_replace('/\s+/', " ", $AllAttributesQuery));

		// Get all entity_ids into an array
		if($this->IsStagingModuleEnabled == true)
		{
			$query = "
				SELECT e.entity_id, MAX(e.row_id) AS row_id
				FROM ".$EntityTableName." AS e
			";
			if($EntityName == 'product')
			{
				$query .= "
				INNER JOIN PFX_catalog_product_website as cpw
					ON cpw.product_id = e.entity_id
				";
			}
			$query .= "
				WHERE 1 = 1
			";
			if($EntityName == 'product')
			{
				$query .= " AND cpw.website_id = :website_id AND IFNULL(e.sku, '') != '' ";
			}
			$query .= "
					AND e.entity_id > :since_entity_id
					AND e.created_in <= ".$this->StagingCurrentVersion."
					AND e.updated_in > ".$this->StagingCurrentVersion."
				GROUP BY e.entity_id
				ORDER BY e.entity_id
				LIMIT ".$this->GetConfigValue('records_per_request')."
			";
		}
		else
		{
			$query = "
				SELECT e.entity_id, '' AS row_id
				FROM ".$EntityTableName." AS e
			";
			if($EntityName == 'product')
			{
				$query .= "
				INNER JOIN PFX_catalog_product_website as cpw
					ON cpw.product_id = e.entity_id
				";
			}
			$query .= "
				WHERE 1 = 1
			";
			if($EntityName == 'product')
			{
				$query .= " AND cpw.website_id = :website_id AND IFNULL(e.sku, '') != '' ";
			}
			$query .= "
					AND e.entity_id > :since_entity_id
				ORDER BY e.entity_id
				LIMIT ".$this->GetConfigValue('records_per_request')."
			";
		}

		$parameters = array("since_entity_id" => $this->SinceEntityId);
		if($EntityName == 'product')
		{
			$parameters["website_id"] = $this->_websiteId;
		}

		$query = $this->_applyTablePrefix($query);
		$EntityRows = $this->_dbi->fetchAll($query, $parameters);

		return $EntityRows;
	}


	// Extract category data natively directly from the database
	private function _runCategoryExport()
	{
		// Start sending file
		if(self::IsCLI() == false)
		{
			// Set up a file name
			$FileName = sprintf('website_%d_store_%d_categories.csv', $this->_websiteId, $this->_storeId);

			$this->_startFileSend($FileName);
		}

		$attributeCodes = array();
		$attributeOptions = array();
		$AllAttributesQuery = "";
		$EntityRows = $this->_getEntityRows('category', $attributeCodes, $attributeOptions, $AllAttributesQuery);

		// Build blank category record
		$blankCategory = array();
		$blankCategory['entity_id'] = '';
		$blankCategory['parent_id'] = '';
		$blankCategory['path'] = '';
		$blankCategory['position'] = '';
		$blankCategory['level'] = '';
		foreach($attributeCodes as $attribute_id => $attribute_code)
		{
			$blankCategory[$attribute_code] = '';
		}
		$blankCategory['attribute_set_id'] = '';
		$blankCategory['attribute_set_name'] = '';
		$blankCategory['row_id'] = '';
		$blankCategory['created_at'] = '';
		$blankCategory['updated_at'] = '';

		$entity_id = 0;
		$AllAttributesStmt = $this->_dbi->prepare($AllAttributesQuery);
		$AllAttributesStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);

		// Loop through each entity and output the data
		$IsFirstRow = true;
		foreach($EntityRows as $EntityRow)
		{
			// Get the entity_id/row_id from the row
			$entity_id = $EntityRow[0];
			$row_id = $EntityRow[1];

			// Create a new record
			$category = $blankCategory;
			$category['entity_id'] = $entity_id;
			$category['row_id'] = $row_id;

			// Get the basic information
			$query = "
				SELECT cce.parent_id, cce.created_at, cce.updated_at, cce.attribute_set_id,
					cce.path, cce.position, cce.level, eas.attribute_set_name
				FROM PFX_catalog_category_entity AS cce
				LEFT OUTER JOIN PFX_eav_attribute_set AS eas ON cce.attribute_set_id = eas.attribute_set_id
				WHERE cce.entity_id = :entity_id
			";
			if($this->IsStagingModuleEnabled == true)
			{
				$query .= "
					AND cce.created_in <= ".$this->StagingCurrentVersion."
					AND cce.updated_in > ".$this->StagingCurrentVersion."
				";
			}
			$query = $this->_applyTablePrefix($query);
			$entity = $this->_dbi->fetchRow($query, array("entity_id" => $entity_id));
			if(empty($entity) == true)
			{
				continue;
			}

			// Initialize basic product data
			$category['parent_id'] = $entity[0];
			$category['created_at'] = $entity[1];
			$category['updated_at'] = $entity[2];
			$category['attribute_set_id'] = $entity[3];
			$category['path'] = $entity[4];
			$category['position'] = $entity[5];
			$category['level'] = $entity[6];
			$category['attribute_set_name'] = $entity[7];

			// Execute the master query with the entity ID
			$result = $AllAttributesStmt->execute();

			// Loop through each field in the row and get the value
			while(true)
			{
				// Get next column
				// $column[0] = value
				// $column[1] = attribute_id
				$column = $AllAttributesStmt->fetch(Zend_Db::FETCH_NUM);
				// Break if no more rows
				if(empty($column))
				{
					break;
				}
				// Skip attributes that don't exist in eav_attribute
				if(!isset($attributeCodes[$column[1]]))
				{
					continue;
				}

				// Translate the option option_id to a value.
				if(isset($attributeOptions[$column[1]]) == true)
				{
					// Convert all option values
					$optionValues = explode(',', $column[0]);
					$convertedOptionValues = array();
					foreach($optionValues as $optionValue)
					{
						if(isset($attributeOptions[$column[1]][$optionValue]) == true)
						{
							// If a option_id is found, translate it
							$convertedOptionValues[] = $attributeOptions[$column[1]][$optionValue];
						}
					}
					// Erase values that are set to zero
					if($column[0] == '0')
					{
						$column[0] = '';
					}
					elseif(empty($convertedOptionValues) == false)
					{
						// Use convert values if any conversions exist
						$column[0] = implode(',', $convertedOptionValues);
					}
					// Otherwise, leave value as-is
				}

				// Add to array
				$category[$attributeCodes[$column[1]]] = $column[0];
			}
			$result = null;

			// Print header row on first row
			if($IsFirstRow == true)
			{
				$headerRow = array_keys($category);
				$this->_writeCSVLine($headerRow);
				$IsFirstRow = false;
			}

			// Print out the line in CSV format
			$this->_writeCSVLine($category);
		}
	}



	// Extract product data natively directly from the database
	private function _runProductExport()
	{
		// Start sending file
		if(self::IsCLI() == false)
		{
			// Set up a file name
			$FileName = sprintf('website_%d_store_%d_products.csv', $this->_websiteId, $this->_storeId);

			$this->_startFileSend($FileName);
		}

		// Look up media gallery attribute ID
		$query = "SELECT attribute_id FROM PFX_eav_attribute WHERE attribute_code='media_gallery'";
		$query = $this->_applyTablePrefix($query);
		$MEDIA_GALLERY_ATTRIBUTE_ID = $this->_dbi->fetchOne($query);
		if(empty($MEDIA_GALLERY_ATTRIBUTE_ID) == true)
		{
			// Default it to 703 if not found
			$MEDIA_GALLERY_ATTRIBUTE_ID = 703;
		}


		$attributeCodes = array();
		$attributeOptions = array();
		$AllAttributesQuery = "";
		$EntityRows = $this->_getEntityRows('product', $attributeCodes, $attributeOptions, $AllAttributesQuery);

		// Build blank product record
		$blankProduct = array();
		$blankProduct['sku'] = '';
		foreach($attributeCodes as $attribute_id => $attribute_code)
		{
			$blankProduct[$attribute_code] = '';
		}
		$blankProduct['json_categories'] = '';
		$blankProduct['aten_product_url'] = '';
		$blankProduct['aten_image_url'] = '';
		$blankProduct['aten_additional_image_url'] = '';
		$blankProduct['aten_additional_image_value_id'] = '';
		$blankProduct['json_tier_pricing'] = '';
		$blankProduct['qty'] = 0;
		$blankProduct['stock_status'] = '';
		$blankProduct['aten_color_attribute_id'] = '';
		$blankProduct['aten_regular_price'] = '';
		$blankProduct['category_ids'] = '';
		$blankProduct['parent_id'] = '';
		$blankProduct['entity_id'] = '';
		$blankProduct['row_id'] = '';
		$blankProduct['type_id'] = '';
		$blankProduct['has_options'] = '';
		$blankProduct['required_options'] = '';
		$blankProduct['attribute_set_id'] = '';
		$blankProduct['attribute_set_name'] = '';
		$blankProduct['created_at'] = '';
		$blankProduct['updated_at'] = '';

		// Prepare statement to get all attributes
		$entity_id = 0;
		$AllAttributesStmt = $this->_dbi->prepare($AllAttributesQuery);
		$AllAttributesStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);

		// Prepare statement to get the basic product information
		$query = "
				SELECT cpe.sku, cpe.created_at, cpe.updated_at, cpe.attribute_set_id,
					cpe.type_id, cpe.has_options, cpe.required_options, eas.attribute_set_name,
					(	SELECT GROUP_CONCAT(ccp.category_id ORDER BY ccp.position ASC SEPARATOR ',')
						FROM PFX_catalog_category_product AS ccp
						WHERE ccp.product_id = cpe.entity_id
						) AS category_ids
				FROM PFX_catalog_product_entity AS cpe
				LEFT OUTER JOIN PFX_eav_attribute_set AS eas ON cpe.attribute_set_id = eas.attribute_set_id
				WHERE cpe.entity_id = :entity_id
			";
		if($this->IsStagingModuleEnabled == true)
		{
			$query .= "
					AND cpe.created_in <= ".$this->StagingCurrentVersion."
					AND cpe.updated_in > ".$this->StagingCurrentVersion."
				";
		}
		$query = $this->_applyTablePrefix($query);
		$BasicProductInfoStmt = $this->_dbi->prepare($query);
		$BasicProductInfoStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);

		// Loop through each product and output the data
		$IsFirstRow = true;
		foreach($EntityRows as $EntityRow)
		{
			// Get the entity_id/row_id from the row
			$entity_id = $EntityRow[0];
			$row_id = $EntityRow[1];

			// Check if the item is out of stock and skip if needed
			if($this->ExcludeOutOfStock == true)
			{
				$query = "
					SELECT stock_status
					FROM PFX_cataloginventory_stock_status AS ciss
					WHERE ciss.website_id = :website_id
						AND ciss.product_id = :product_id
				";
				$query = $this->_applyTablePrefix($query);
				$stock_status = $this->_dbi->fetchOne($query, array("website_id" => $this->_websiteId, "product_id" => $entity_id));
				// If stock status not found or equal to zero, skip the item
				if(empty($stock_status))
				{
					continue;
				}
			}

			// Create a new product record
			$product = $blankProduct;
			$product['entity_id'] = $entity_id;
			$product['row_id'] = $row_id;


			// Get basic product information
			$BasicProductInfoStmt->execute();
			$entity = $BasicProductInfoStmt->fetch(Zend_Db::FETCH_NUM);
			if(empty($entity) == true)
			{
				continue;
			}

			// Set basic product data
			$product['sku'] = $entity[0];
			$product['created_at'] = $entity[1];
			$product['updated_at'] = $entity[2];
			$product['attribute_set_id'] = $entity[3];
			$product['type_id'] = $entity[4];
			$product['has_options'] = $entity[5];
			$product['required_options'] = $entity[6];
			$product['attribute_set_name'] = $entity[7];
			$product['category_ids'] = $entity[8];

			// Calculate json_categories
			$product['json_categories'] = array();
			$CategoryIds = explode(',', $product['category_ids']);
			foreach($CategoryIds as $categoryId)
			{
				if(isset($this->CategoryIdToFullPath[$categoryId]) == false)
				{
					continue;
				}
				$product['json_categories'][] = $this->CategoryIdToFullPath[$categoryId];
			}
			$product['json_categories'] = json_encode($product['json_categories']);

			// Execute the master query with the entity ID
			$AllAttributesStmt->execute();

			// Loop through each field in the row and get the value
			while(true)
			{
				// Get next column
				// $column[0] = value
				// $column[1] = attribute_id
				$column = $AllAttributesStmt->fetch(Zend_Db::FETCH_NUM);
				// Break if no more rows
				if(empty($column))
				{
					break;
				}
				// Skip attributes that don't exist in eav_attribute
				if(!isset($attributeCodes[$column[1]]))
				{
					continue;
				}

				// Save color attribute ID (for CJM automatic color swatches extension)
				//  NOTE: do this prior to translating option_id to option_value below
				if($attributeCodes[$column[1]] == 'color')
				{
					$product['aten_color_attribute_id'] = $column[0];
				}

				// Translate the option option_id to a value.
				if(isset($attributeOptions[$column[1]]) == true)
				{
					// Convert all option values
					$optionValues = explode(',', $column[0]);
					$convertedOptionValues = array();
					foreach($optionValues as $optionValue)
					{
						if(isset($attributeOptions[$column[1]][$optionValue]) == true)
						{
							// If a option_id is found, translate it
							$convertedOptionValues[] = $attributeOptions[$column[1]][$optionValue];
						}
					}
					// Erase values that are set to zero
					if($column[0] == '0')
					{
						$column[0] = '';
					}
					elseif(empty($convertedOptionValues) == false)
					{
						// Use convert values if any conversions exist
						$column[0] = implode(',', $convertedOptionValues);
					}
					// Otherwise, leave value as-is
				}

				// Escape double-quotes and add to product array
				$product[$attributeCodes[$column[1]]] = $column[0];
			}
			$result = null;

			// Skip product that are disabled or have no status
			//  if the checkbox is not checked (this is the default setting)
			if($this->IncludeDisabled == false)
			{
				if(empty($product['status']) || $product['status'] == $this->_STATUS_DISABLED_CONST)
				{
					continue;
				}
			}

			// Get stock quantity
			// NOTE: stock_id = 1 is the 'Default' stock
			if(isset($StockStatusStmt) == false)
			{
				$query = "
					SELECT qty, stock_status
					FROM PFX_cataloginventory_stock_status
					WHERE product_id = :product_id
						AND website_id IN (0, :website_id)
						AND stock_id = 1
					ORDER BY website_id DESC";
				$query = $this->_applyTablePrefix($query);
				$StockStatusStmt = $this->_dbi->prepare($query);
				$StockStatusStmt->bindParam(':product_id', $entity_id, PDO::PARAM_INT);
				$StockStatusStmt->bindParam(':website_id', $this->_websiteId, PDO::PARAM_INT);
			}
			$StockStatusStmt->execute();
			$stockInfo = $StockStatusStmt->fetch();
			if(empty($stockInfo) == true)
			{
				$product['qty'] = '0';
				$product['stock_status'] = '';
			}
			else
			{
				$product['qty'] = $stockInfo[0];
				$product['stock_status'] = $stockInfo[1];
			}
			$stockInfoResult = null;

			// Get additional image URLs
			$galleryImagePrefix = $this->_mediaBaseUrl.'catalog/product';

			// Prepare the statement
			if(isset($MediaGalleryStmt) == false)
			{
				if($this->IsMagento2)
				{
					$query = "
						SELECT
							 GROUP_CONCAT(mg.value_id SEPARATOR ',') AS value_id
							,GROUP_CONCAT(CONCAT(:gallery_image_prefix, mg.value) SEPARATOR ',') AS value
						FROM PFX_catalog_product_entity_media_gallery_value_to_entity AS mgvte
							INNER JOIN PFX_catalog_product_entity_media_gallery AS mg
								ON mgvte.value_id = mg.value_id
							INNER JOIN PFX_catalog_product_entity_media_gallery_value AS mgv
								ON mg.value_id = mgv.value_id
						WHERE   mgv.store_id IN (:store_id, 0)
							AND mgv.disabled = 0
							AND ".($this->IsStagingModuleEnabled ? "mgvte.row_id =  :row_id" : "mgvte.entity_id = :entity_id ")."
							AND mg.attribute_id = :media_gallery_attribute_id
						ORDER BY mgv.position ASC";
					$query = $this->_applyTablePrefix($query);
					$MediaGalleryStmt = $this->_dbi->prepare($query);
					$MediaGalleryStmt->bindParam(':gallery_image_prefix', $galleryImagePrefix, PDO::PARAM_STR);
					$MediaGalleryStmt->bindParam(':store_id', $this->_storeId, PDO::PARAM_INT);
					$MediaGalleryStmt->bindParam(':media_gallery_attribute_id', $MEDIA_GALLERY_ATTRIBUTE_ID, PDO::PARAM_INT);

					if($this->IsStagingModuleEnabled)
					{
						$MediaGalleryStmt->bindParam(':row_id', $row_id, PDO::PARAM_INT);
					}
					else
					{
						$MediaGalleryStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);
					}
				}
				else
				{
					$query = "
						SELECT
							 GROUP_CONCAT(gallery.value_id SEPARATOR ',') AS value_id
							,GROUP_CONCAT(CONCAT(".$this->_dbi->quote($galleryImagePrefix).", gallery.value) SEPARATOR ',') AS value
						FROM PFX_catalog_product_entity_media_gallery AS gallery
							INNER JOIN PFX_catalog_product_entity_media_gallery_value AS gallery_value
								ON gallery.value_id = gallery_value.value_id
						WHERE   gallery_value.store_id IN (:store_id, 0)
							AND gallery_value.disabled = 0
							AND gallery.entity_id = :entity_id
							AND gallery.attribute_id = :media_gallery_attribute_id
						ORDER BY gallery_value.position ASC";
					$query = $this->_applyTablePrefix($query);
					$MediaGalleryStmt = $this->_dbi->prepare($query);
					$MediaGalleryStmt->bindParam(':store_id', $this->_storeId, PDO::PARAM_INT);
					$MediaGalleryStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);
					$MediaGalleryStmt->bindParam(':media_gallery_attribute_id', $MEDIA_GALLERY_ATTRIBUTE_ID, PDO::PARAM_INT);
				}
			}
			$MediaGalleryStmt->execute();
			$galleryValues = $MediaGalleryStmt->fetch();
			if(empty($galleryValues) == false)
			{
				// Save value IDs for CJM automatic color swatches extension support
				$product['aten_additional_image_value_id'] = $galleryValues[0];
				$product['aten_additional_image_url'] = $galleryValues[1];
			}

			// Get parent ID
			if(isset($ParentIdStmt) == false)
			{
				$query = "
					SELECT GROUP_CONCAT(parent_id SEPARATOR ',') AS parent_id
					FROM PFX_catalog_product_super_link AS super_link
					WHERE super_link.product_id = :product_id";
				$query = $this->_applyTablePrefix($query);
				$ParentIdStmt = $this->_dbi->prepare($query);
				$ParentIdStmt->bindParam(':product_id', $entity_id, PDO::PARAM_INT);
			}
			$ParentIdStmt->execute();
			$parentId = $ParentIdStmt->fetch();
			if(empty($parentId) == false)
			{
				// Save value IDs for CJM automatic color swatches extension support
				$product['parent_id'] = $parentId[0];
			}

			// Get the regular price (before any catalog price rule is applied)
			$product['aten_regular_price'] = $product['price'];

			// Override price with catalog price rule, if found
			if(isset($CatalogPriceRuleStmt) == false)
			{
				$query = "
					SELECT crpp.rule_price
					FROM PFX_catalogrule_product_price AS crpp
					WHERE crpp.rule_date = CURDATE()
						AND crpp.product_id = :product_id
						AND crpp.customer_group_id = 1
						AND crpp.website_id = :website_id";
				$query = $this->_applyTablePrefix($query);
				$CatalogPriceRuleStmt = $this->_dbi->prepare($query);
				$CatalogPriceRuleStmt->bindParam(':product_id', $entity_id, PDO::PARAM_INT);
				$CatalogPriceRuleStmt->bindParam(':website_id', $this->_websiteId, PDO::PARAM_INT);
			}
			$CatalogPriceRuleStmt->execute();
			$rule_price = $CatalogPriceRuleStmt->fetch();
			if(empty($rule_price) == false)
			{
				// Override price with catalog rule price
				$product['price'] = $rule_price[0];
			}

			// Calculate product URL
			if(empty($product['url_path']) == false)
			{
				$product['aten_product_url'] = $this->_urlPathJoin($this->_webBaseUrl, $product['url_path']);
			}
			else if(empty($product['url_key']) == false)
			{
				$product['aten_product_url'] = $this->_urlPathJoin($this->_webBaseUrl, $product['url_key'].'.html');
			}

			// Calculate image URL
			if(empty($product['image']) == false)
			{
				$product['aten_image_url'] = $this->_urlPathJoin($this->_mediaBaseUrl, 'catalog/product');
				$product['aten_image_url'] = $this->_urlPathJoin($product['aten_image_url'], $product['image']);
			}

			// Get tier pricing information
			if(isset($TierPricingStmt) == false)
			{
				$query = "
					SELECT tp.qty, tp.value
					FROM PFX_catalog_product_entity_tier_price AS tp
					WHERE ".($this->IsStagingModuleEnabled ? "tp.row_id = :row_id" : "tp.entity_id = :entity_id")."
						AND tp.website_id IN (0, :website_id)
						AND tp.all_groups = 1
						AND tp.customer_group_id = 0
				";
				$query = $this->_applyTablePrefix($query);
				$TierPricingStmt = $this->_dbi->prepare($query);
				$TierPricingStmt->bindParam(':website_id', $this->_websiteId, PDO::PARAM_INT);
				if($this->IsStagingModuleEnabled)
				{
					$TierPricingStmt->bindParam(':row_id', $row_id, PDO::PARAM_INT);
				}
				else
				{
					$TierPricingStmt->bindParam(':entity_id', $entity_id, PDO::PARAM_INT);
				}
			}
			$TierPricingStmt->execute();
			$tierPricingTable = $TierPricingStmt->fetchAll();
			// Save entire table in JSON format
			$product['json_tier_pricing'] = json_encode($tierPricingTable);

			// Print header row on first row
			if($IsFirstRow == true)
			{
				$headerRow = array_keys($product);
				$this->_writeCSVLine($headerRow);
				$IsFirstRow = false;
			}

			// Print out the line in CSV format
			$this->_writeCSVLine($product);
		}
	}


	// Write line as CSV, quoting fields if needed
	private function _writeCSVLine(&$row)
	{
		// Escape double-quotes in every value
		foreach($row as $k => $v)
		{
			// Skip if length zero
			if(strlen($v) == 0)
			{
				continue;
			}
			// Skip if no double quotes
			if(strpos($v, '"') === false)
			{
				continue;
			}
			$row[$k] = str_replace('"', '""', $v);
		}

		// Use only one print call for improved performance
		print '"'.implode('","', $row)."\"\n";
	}

	// Join two URL paths and handle forward slashes
	private function _urlPathJoin($part1, $part2)
	{
		return rtrim($part1, '/').'/'.ltrim($part2, '/');
	}

	// Get lookup table for the full paths of the categories
	private function _initializeCategoryIdToFullPath()
	{
		if($this->IsStagingModuleEnabled == false)
		{
			$query = "
				SELECT cce.entity_id, cce.path,
				(	SELECT
						CASE WHEN SUM(ccev.store_id) = 0 THEN MAX(ccev.`value`)
							 WHEN ccev.store_id = :store_id THEN ccev.`value` ELSE NULL END AS 'value'
					FROM PFX_catalog_category_entity_varchar AS ccev
					WHERE ccev.entity_id = cce.entity_id AND ccev.attribute_id =
					(	SELECT MAX(ea.attribute_id)
						FROM PFX_eav_attribute AS ea
						WHERE ea.attribute_code='name'
							AND ea.backend_type='varchar'
							AND ea.entity_type_id =
							(	SELECT MAX(eet.entity_type_id)
								FROM PFX_eav_entity_type AS eet
								WHERE eet.entity_type_code = 'catalog_category'
							)
					)
				) AS 'name'
				FROM PFX_catalog_category_entity AS cce
				WHERE cce.parent_id > 0
			";
		}
		else
		{
			$query = "
				SELECT cce.entity_id, cce.path,
				(	SELECT
						CASE WHEN SUM(ccev.store_id) = 0 THEN MAX(ccev.`value`)
							 WHEN ccev.store_id = :store_id THEN ccev.`value` ELSE NULL END AS 'value'
					FROM PFX_catalog_category_entity_varchar AS ccev
					WHERE ccev.row_id = cce.row_id
						AND ccev.store_id IN (0, :store_id)
						AND ccev.attribute_id =
					(	SELECT MAX(ea.attribute_id)
						FROM PFX_eav_attribute AS ea
						WHERE ea.attribute_code='name'
							AND ea.backend_type='varchar'
							AND ea.entity_type_id =
							(	SELECT MAX(eet.entity_type_id)
								FROM PFX_eav_entity_type AS eet
								WHERE eet.entity_type_code = 'catalog_category'
							)
					)
				) AS 'name'
				FROM PFX_catalog_category_entity AS cce
				WHERE cce.created_in <= ".$this->StagingCurrentVersion."
					AND cce.updated_in > ".$this->StagingCurrentVersion."
					AND cce.parent_id > 0
			";
		}
		$query = $this->_applyTablePrefix($query);
		$AllCategories = $this->_dbi->fetchAll($query, array('store_id' => $this->_storeId));
		$EntityIdToCategoryName = array();
		// Build a lookup table
		foreach($AllCategories as $k => $row)
		{
			$EntityIdToCategoryName[$row[0]] = $row[2];
		}

		// Translate the paths
		$this->CategoryIdToFullPath = array();
		foreach($AllCategories as $k => $row)
		{
			$PathIds = explode('/', $row[1]);
			$PathNames = array();
			foreach($PathIds as $PathId)
			{
				if(isset($EntityIdToCategoryName[$PathId]) == false
					|| $EntityIdToCategoryName[$PathId] == '')
				{
					continue;
				}
				$PathNames[] = $EntityIdToCategoryName[$PathId];
			}

			$EntityIdToCategoryName[$row[0]] = $row[2];
			$this->CategoryIdToFullPath[$row[0]] = implode(' > ', $PathNames);
		}

	}

	// Send a output to the client browser as an inline attachment
	// Features: low-memory footprint, gzip compressed if supported
	private function _startFileSend($FileName)
	{
		// Supply last-modified date
		$gmdate_mod = gmdate('D, d M Y H:i:s', time()).' GMT';
		header("Last-Modified: $gmdate_mod");

		// Supply content headers
		header("Content-Type: text/plain; charset=UTF-8");
		$ContentDisposition = ($this->DownloadAsAttachment ? 'attachment' : 'inline');
		header('Content-Disposition: '.$ContentDisposition.'; filename="'.$FileName.'"');
		// NOTE: Do not supply content-length header, because the file
		// may be sent gzip-compressed in which case the length would be wrong.

		// Add custom headers
		header("X-AtenSoftware-ShoppingCart: Magento ".$this->GetMagentoVersion());
		header("X-AtenSoftware-Version: ".self::VERSION);

		// Turn on zlib output compression with buffer size of 8kb
		ini_set('zlib.output_compression', 8192);
	}

	// Return Magento product version
	private function GetMagentoVersion()
	{
		if($this->IsMagento2)
		{
			$productMetadata = $this->_objectManager->get('Magento\Framework\App\ProductMetadataInterface');
			return $productMetadata->getVersion();
		}
		else
		{
			return Mage::getVersion();
		}
	}

	// Display the user interface for the exporter, as a web page
	private function DisplayPasswordPrompt()
	{
		AtenExporterForMagento::WritePageHeader();
		?>

		<h3>Log In</h3>

		<form method="post" action="" class="form-inline">
			<div class="form-group">
				<label for="Password">Password:</label>
				<input type="password" name="Password" id="Password" size="20" class="form-control ml-3">
			</div>
			<button type="submit" class="btn btn-primary ml-3">Submit</button>

			<input type="hidden" name="Command" value="DisplayForm">

		</form>

		<?php

		AtenExporterForMagento::WritePageFooter();
	}

	// Display the user interface for the exporter, as a web page
	private function DisplayForm()
	{
		$model = new StdClass();

		$model->Password =  (isset($_REQUEST['Password']) ?
			htmlentities($_REQUEST['Password']) : '');


		$model->Websites = array();
		// List all active website-stores
		if($this->IsMagento2)
		{
			$WebSiteTableName = "store_website";
			$StoreTableName = "store";
		}
		else
		{
			$WebSiteTableName = "core_website";
			$StoreTableName = "core_store";
		}

		$query = "SELECT
			 w.website_id
			,w.name as website_name
			,w.is_default
			,s.store_id
			,s.name as store_name
		FROM PFX_$WebSiteTableName AS w
			INNER JOIN PFX_$StoreTableName AS s ON s.website_id = w.website_id
		WHERE s.is_active = 1 AND w.website_id > 0
		ORDER BY w.sort_order, w.name, s.sort_order, s.name";
		$query = $this->_applyTablePrefix($query);
		$result = $this->_dbi->query($query);
		$isChecked = false;
		while(true)
		{
			// Get next row
			$row = $result->fetch(Zend_Db::FETCH_ASSOC);

			// Break if no more rows
			if(empty($row))
			{
				break;
			}

			$Website = new StdClass();

			$Website->store_id = htmlentities($row['store_id']);
			$Website->website_id = htmlentities($row['website_id']);
			$Website->website_name = htmlentities($row['website_name']);
			$Website->store_name = htmlentities($row['store_name']);
			$Website->CheckedProperty = '';
			// Set first website checked
			if($isChecked == false)
			{
				$Website->CheckedProperty = ' checked="checked" ';
				$isChecked = false;
			}
			$model->Websites[] = $Website;
		}
		$result = null;

		AtenExporterForMagento::WritePageHeader();
		?>

		<script language="JavaScript">
			$(function () {
				setURLs(true);
			});
			function setURLs(IsPasswordMasked)
			{
				var url = window.location.href;
				url += '?Command=ExportCategories';
				url += '&Store=' + $("input[name='Store']:checked").val();
				url += '&Password=';
				if(IsPasswordMasked == false)
				{
					url += $('#Password').val();
				}
				else
				{
					url += "********";
				}

				// Set category export URL
				$('#CategoryExportURL').val(url);

				// Set product export URL
				url = url.replace('Command=ExportCategories', 'Command=Export');
				if($('#ExcludeOutOfStock').prop('checked') == true)
				{
					url += '&ExcludeOutOfStock=1';
				}
				if($('#IncludeDisabled').prop('checked') == true)
				{
					url += '&IncludeDisabled=1';
				}
				$('#ProductExportURL').val(url);

			}
			function copyURL(textBoxId)
			{
				setURLs(false); // Temporarily unmask the password
				var copyText = document.getElementById(textBoxId);
				copyText.select();
				copyText.setSelectionRange(0, 99999);
				document.execCommand("copy");
				setURLs(true); // Re-mask the password
			}
			function setFormValues(Command, DownloadAsAttachment)
			{
				$('#Command').val(Command);
				$('#DownloadAsAttachment').val(DownloadAsAttachment);
				return true;
			}
		</script>

		<form method="get" action="" role="form">

			<fieldset class="form-group"><legend>Select a store</legend>
				<table class="table table-striped">
					<thead>
					<tr>
						<th>Select</th>
						<th>Website ID</th>
						<th>Website</th>
						<th>Store ID</th>
						<th>Store</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($model->Websites as $Website): ?>
					<tr>
						<td style="text-align:center;">
							<input type="radio" name="Store" value="<?= $Website->store_id ?>"
								<?= $Website->CheckedProperty ?> title="<?= $Website->store_name ?>"
								onclick="setURLs(true);">
						</td>
						<td style="text-align:center;"><?= $Website->website_id ?></td>
						<td><?= $Website->website_name ?></td>
						<td style="text-align:center;"><?= $Website->store_id ?></td>
						<td><?= $Website->store_name ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</fieldset>

			<fieldset class="form-group"><legend>Select product export options</legend>
				<div class="checkbox">
					<label for="ExcludeOutOfStock"><input type="checkbox" id="ExcludeOutOfStock"
						name="ExcludeOutOfStock" onclick="setURLs(true);"> Exclude out-of-stock products (stock_status=0)</label>
				</div>
				<div class="checkbox">
					<label for="IncludeDisabled"><input type="checkbox" id="IncludeDisabled"
						name="IncludeDisabled" onclick="setURLs(true);"> Include disabled products (status=0)</label>
				</div>
			</fieldset>

			<fieldset class="form-group"><legend>Run product CSV export</legend>
				<div class="form-group">
					<input type="submit" value="View in Browser"
						   class="btn btn-primary"
						   onclick="return setFormValues('Export', '0');">

					<input type="submit" value="Download as File"
						   class="btn btn-primary"
						   onclick="return setFormValues('Export', '1');">
				</div>

				<div class="form-group">
					<label for="ProductExportURL">Product Export URL</label>
					<textarea id="ProductExportURL" class="form-control form-control-sm"></textarea>

					<button type="button" class="btn btn-outline-secondary btn-sm mt-1"
							onclick="copyURL('ProductExportURL');">Copy to Clipboard</button>
				</div>

			</fieldset>

			<fieldset class="form-group"><legend>Run category CSV export</legend>
				<div class="form-group">
					<input type="submit" value="View in Browser"
						   class="btn btn-primary"
						   onclick="return setFormValues('ExportCategories', '0');">

					<input type="submit" value="Download as File"
						   class="btn btn-primary"
						   onclick="return setFormValues('ExportCategories', '1');">
				</div>

				<div class="form-group">
					<label for="CategoryExportURL">Categories Export URL</label>
					<textarea id="CategoryExportURL" class="form-control form-control-sm"></textarea>

					<button type="button" class="btn btn-outline-secondary btn-sm mt-1"
						onclick="copyURL('CategoryExportURL');">Copy to Clipboard</button>
				</div>

			</fieldset>

			<input type="hidden" id="Command" name="Command" value="Export">
			<input type="hidden" id="DownloadAsAttachment" name="DownloadAsAttachment" value="0">
			<input type="hidden" id="Password" name="Password"
				   value="<?= $model->Password ?>">


		</form>
		<?php

		AtenExporterForMagento::WritePageFooter();
	}

	// Die if the storeId is invalid
	private function _getStoreInformation()
	{
		if($this->_storeId == '')
		{
			throw new Exception(
				'ERROR: Store parameter must be specified in the query string.');
		}

		// Check format of the ID
		if(0 == preg_match('|^\d+$|', $this->_storeId))
		{
			throw new Exception(
				'ERROR: The specified Store is not formatted correctly: '.$this->_storeId);
		}

		try
		{
			if($this->IsMagento2)
			{
				$storeManager = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface');
				$store = $storeManager->getStore($this->_storeId);
				// Load the store information
				$this->_websiteId = $store->getWebsiteId();
				$this->_webBaseUrl = $store->getBaseUrl(Magento\Framework\UrlInterface::URL_TYPE_WEB);
				$this->_mediaBaseUrl = $store->getBaseUrl(Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
				$this->_STATUS_DISABLED_CONST = Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED;
			}
			else
			{
				// Get the store object
				$store = Mage::app()->getStore($this->_storeId);
				// Load the store information
				$this->_websiteId = $store->getWebsiteId();
				$this->_webBaseUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
				$this->_mediaBaseUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
				$this->_STATUS_DISABLED_CONST = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
			}
		}
		catch (Exception $e)
		{
			throw new Exception(
				'ERROR: Error getting store information for Store='.$this->_storeId.
				". The store probably does not exist. ".get_class($e)." ".$e->getMessage());
		}

	}

	// Die if password is invalid
	private function _checkPassword($Password)
	{
		// Check if a password is defined
		if($this->GetConfigValue('password_sha256') == '')
		{
			throw new Exception('ERROR: A blank password is not allowed.'.
				' Please set a password in the configuration file.');
		}
		// Check the password using timing attack safe string comparison
		$known_string = $this->GetConfigValue('password_sha256');
		$user_string = hash('sha256', $Password);
		if((function_exists("hash_equals") && hash_equals($known_string, $user_string) === false)
			|| strcmp($known_string, $user_string) != 0)
		{
			throw new Exception('ERROR: The specified password is invalid.');
		}
	}

	/** Return configuration value
	 * @throws Exception
	 * @return string
	 */
	function GetConfigValue($key)
	{
		// Initialize the configuration
		if(is_array($this->config) == false)
		{
			// Load configuration file, if it exists
			$ConfigFileName = realpath(dirname(__FILE__)).'/'.self::CONFIG_FILE;
			if(file_exists($ConfigFileName) === true)
			{
				include_once($ConfigFileName);
				// Use the configuration from the config file, if it exists
				if(isset($configuration) && is_array($configuration))
				{
					$this->config = $configuration;

				}
			}
			else
			{
				throw new Exception('ERROR: A configuration file named '.
					self::CONFIG_FILE.' must be in the same path as this script.');
			}
		}

		// Return configuration value, or default value
		switch($key)
		{
			case "umask":
				$value = (isset($this->config['umask']) ? $this->config['umask'] : 0);
				if(is_int($value) == false || $value < 0)
				{
					throw new Exception("umask must be an integer >= 0");
				}
				break;
			case 'records_per_request':
				$value = (isset($this->config['records_per_request']) ? $this->config['records_per_request'] : 2147483647);
				if(is_int($value) == false || $value <= 0)
				{
					throw new Exception("records_per_request must be an integer > 0");
				}
				break;
			case "password_sha256":
				$value = (isset($this->config['password_sha256']) ? $this->config['password_sha256'] : '');
				break;
			case "max_execution_time":
			case "display_errors":
			case "error_reporting":
			case "memory_limit":
				$value = (isset($this->config[$key]) ? $this->config[$key] : ini_get($key));
				break;
			case 'table_export_allowed_table_names':
				$value = (isset($this->config[$key]) ? $this->config[$key] : array(''));
				break;
			default:
				throw new Exception("Invalid configuration key: " . $key);
		}

		return $value;
	}

	// Display an error as an HTML page or to the console
	public static function DisplayErrorPage($ErrorMessage)
	{
		if(self::IsCLI() == true)
		{
			print $ErrorMessage;
		}
		else
		{
			AtenExporterForMagento::WritePageHeader();
			$model = new StdClass();
			$model->ErrorMessage = htmlentities($ErrorMessage);
			?>
			<div class="alert alert-danger" style="white-space:pre-wrap;"><?= $model->ErrorMessage; ?></div>
			<?php
			AtenExporterForMagento::WritePageFooter();
		}
		exit(1);
	}

	// Write common page header
	private static function WritePageHeader()
	{
		// Set character set to UTF-8
		header("Content-Type: text/html; charset=UTF-8");
		?>
		<!doctype html>
		<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
			<title>Aten Software Product Data Exporter for Magento</title>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		</head>
		<body>
		<div class="container">
		<h2>Aten Software Product Data Exporter for Magento</h2>
		<?php
	}

	// Write common page footer
	private static function WritePageFooter()
	{
		?>
		<div class="card my-3 my-1 text-center">
			<div class="card-body">
				<div class="card-text">
				Use this exporter with Aten Software's
				<a href="https://www.atensoftware.com/p186.php">Google Shopping Data Feed Service for Magento 2</a>
				</div>
			</div>
			<div class="card-footer text-muted py-1">Copyright 2020 &middot;
				Aten Software LLC &middot;
				Version <?php echo self::VERSION; ?></div>
		</div>
		</body>
		</html>
		<?php
	}

	// Returns true if running CLI mode
	public static function IsCLI()
	{
		$sapi_type = php_sapi_name();
		return (substr($sapi_type, 0, 3) == 'cli');
	}

	// Return true if table exists in the current schema.
	// Optionally, specify column names to verify table exists with those columns.
	private function _tableExists($TableName, $ColumnNames = null)
	{
		// Convert table prefix
		$TableName = $this->_applyTablePrefix($TableName);

		// Check if table exists in the current schema
		// NOTE: Used constant TABLE_SCHEMA and TABLE_NAME to avoid directory scans
		$query = "SELECT COUNT(*)
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_SCHEMA=DATABASE()
				AND TABLE_NAME = :table_name";

		// Optionally check for columns
		$MinimumColumnCount = 1;
		if(isset($ColumnNames) && is_array($ColumnNames) && empty($ColumnNames) == false)
		{
			$query .= " AND COLUMN_NAME IN ('".implode("','", $ColumnNames)."')";
			$MinimumColumnCount = count($ColumnNames);
		}

		// Get the number of matching columns
		$CountColumns = $this->_dbi->fetchOne($query, array('table_name' => $TableName));

		// Return result
		return ($CountColumns >= $MinimumColumnCount);
	}

	// Apply prefix to table names in the query
	private function _applyTablePrefix($query)
	{
		return str_replace('PFX_', $this->_tablePrefix, $query);
	}

	// Print the results of a select query to output for debugging purposes and exit
	private function _debugPrintQuery($query, $params = null)
	{
		print '<pre>'.htmlentities($query).'</pre>';
		if(is_null($params) == false)
		{
			print '<pre>'.htmlentities(print_r($params, true)).'</pre>';
		}
		print '<hr>';
		print '<pre>';
		$this->_dbi->setFetchMode(Zend_Db::FETCH_ASSOC);
		print htmlentities(print_r($this->_dbi->fetchAll($query, $params), true));
		print '</pre>';
		exit();
	}

	// Debug print a message to STDERR
	//  Prints execution time since last statement for profiling purposes
	private function pr($message)
	{
		static $start = 0;

		// Automatically print any non-string values
		if(is_string($message) === false)
		{
			$message = print_r($message, true)."\n";
		}

		// Initialize start time, if needed.
		if($start == 0)
		{
			$start = microtime(true);
		}
		// Get end time
		$end = microtime(true);

		// Get time elapsed
		$elapsed = ($end - $start)  * 1000;

		// Remember end time for next call
		$start = $end;

		$MessageFormat = '[%06.5f]';

		// Add elapsed time to the message
		$message = sprintf($MessageFormat, $elapsed).$message;

		fprintf(STDERR, $message);
	}

}


