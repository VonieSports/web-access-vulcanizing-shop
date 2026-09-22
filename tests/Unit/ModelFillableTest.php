<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\RoadSideService;
use App\Models\Variant;
use App\Models\Vehicle;
use Tests\TestCase;

class ModelFillableTest extends TestCase
{
    public function test_core_models_define_fillable_fields_from_migrations(): void
    {
        $cases = [
            Appointment::class => [
                'tenant_id',
                'customer_id',
                'vehicle_id',
                'employee_id',
                'created_by',
                'appointment_number',
                'start_time',
                'end_time',
                'status',
                'notes',
            ],
            ProductCategory::class => [
                'tenant_id',
                'name',
                'slug',
                'description',
            ],
            Product::class => [
                'tenant_id',
                'category_id',
                'brand_id',
                'name',
                'slug',
                'sku',
                'barcode',
                'cost_price',
                'selling_price',
                'stock',
                'low_stock_alert',
                'description',
                'ft_img',
                'attachments',
            ],
            Variant::class => [
                'tenant_id',
                'product_id',
                'sku',
                'price',
                'stock_quantity',
                'image',
            ],
            Inventory::class => [
                'tenant_id',
                'product_id',
                'type',
                'quantity',
                'before_stock',
                'after_stock',
                'reference_type',
                'reference_id',
                'remarks',
            ],
            Vehicle::class => [
                'tenant_id',
                'customer_id',
                'plate_number',
                'vehicle_type',
                'brand',
                'model',
                'year_model',
            ],
            RoadSideService::class => [
                'tenant_id',
                'roadside_request_id',
                'service_id',
                'price',
            ],
        ];

        foreach ($cases as $class => $expected) {
            $this->assertSame($expected, (new $class)->getFillable());
        }
    }
}
