<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\ProductMeasurementUnitDataImport\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Zed\ProductMeasurementUnitDataImport\Communication\Plugin\ProductMeasurementBaseUnitDataImportPlugin;
use Spryker\Zed\ProductMeasurementUnitDataImport\Communication\Plugin\ProductMeasurementSalesUnitDataImportPlugin;
use Spryker\Zed\ProductMeasurementUnitDataImport\Communication\Plugin\ProductMeasurementSalesUnitStoreDataImportPlugin;
use Spryker\Zed\ProductMeasurementUnitDataImport\Communication\Plugin\ProductMeasurementUnitDataImportPlugin;
use Spryker\Zed\ProductMeasurementUnitDataImport\ProductMeasurementUnitDataImportConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductMeasurementUnitDataImport
 * @group Communication
 * @group Plugin
 * @group ProductMeasurementUnitDataImportPluginTest
 * Add your own group annotations below this line
 */
class ProductMeasurementUnitDataImportPluginTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ProductMeasurementUnitDataImport\ProductMeasurementUnitDataImportCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->setDependency(
            DataImportDependencyProvider::DATA_IMPORTER_PLUGINS,
            [
                new ProductMeasurementUnitDataImportPlugin(),
                new ProductMeasurementBaseUnitDataImportPlugin(),
                new ProductMeasurementSalesUnitDataImportPlugin(),
                new ProductMeasurementSalesUnitStoreDataImportPlugin(),
            ],
        );
    }

    /**
     * @return void
     */
    public function testImportImportsData(): void
    {
        $this->tester->ensureMeasurementSalesUnitStoreIsEmpty();
        $this->tester->ensureMeasurementSalesUnitIsEmpty();
        $this->tester->ensureMeasurementBaseUnitIsEmpty();
        $this->tester->ensureProductMeasurementUnitIsEmpty();

        $dataDir = codecept_data_dir();
        $dataImporterReportTransfer = $this->tester->importMeasurementUnitData($dataDir);

        $this->assertInstanceOf(DataImporterReportTransfer::class, $dataImporterReportTransfer);

        $this->tester->assertProductMeasurementUnitContainsData();
    }

    /**
     * @return void
     */
    public function testGetImportTypeReturnsTypeOfImporter(): void
    {
        $productMeasurementUnitDataImportPlugin = new ProductMeasurementUnitDataImportPlugin();
        $this->assertSame(
            ProductMeasurementUnitDataImportConfig::IMPORT_TYPE_PRODUCT_MEASUREMENT_UNIT,
            $productMeasurementUnitDataImportPlugin->getImportType(),
        );
    }
}
