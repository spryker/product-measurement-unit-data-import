<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\ProductMeasurementUnitDataImport\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReaderConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Orm\Zed\ProductMeasurementUnit\Persistence\SpyProductMeasurementSalesUnitStoreQuery;
use Spryker\Zed\ProductMeasurementUnitDataImport\Communication\Plugin\ProductMeasurementSalesUnitStoreDataImportPlugin;

class ProductMeasurementSalesUnitStoreDataImportHelper extends Module
{
    public function ensureMeasurementSalesUnitStoreIsEmpty(): void
    {
        $query = $this->getProductMeasurementSalesUnitStoreQuery();
        $query->deleteAll();
    }

    public function assertMeasurementSalesUnitStoreIsEmpty(): void
    {
        $query = $this->getProductMeasurementSalesUnitStoreQuery();
        $this->assertCount(0, $query, 'Found at least one entry in the database table but database table was expected to be empty.');
    }

    public function assertMeasurementSalesUnitStoreContainsData(): void
    {
        $query = $this->getProductMeasurementSalesUnitStoreQuery();
        $this->assertTrue(($query->count() > 0), 'Expected at least one entry in the database table but database table is empty.');
    }

    protected function getProductMeasurementSalesUnitStoreQuery(): SpyProductMeasurementSalesUnitStoreQuery
    {
        return SpyProductMeasurementSalesUnitStoreQuery::create();
    }

    public function importMeasurementSalesUnitStoreData(string $dataDir): DataImporterReportTransfer
    {
        $dataImporterReaderConfigurationTransfer = new DataImporterReaderConfigurationTransfer();
        $dataImporterReaderConfigurationTransfer->setFileName($dataDir . 'import/product_measurement_sales_unit_store.csv');

        $dataImportConfigurationTransfer = new DataImporterConfigurationTransfer();
        $dataImportConfigurationTransfer->setReaderConfiguration($dataImporterReaderConfigurationTransfer);

        $productMeasurementSalesUnitStoreDataImportPlugin = new ProductMeasurementSalesUnitStoreDataImportPlugin();

        return $productMeasurementSalesUnitStoreDataImportPlugin->import($dataImportConfigurationTransfer);
    }
}
