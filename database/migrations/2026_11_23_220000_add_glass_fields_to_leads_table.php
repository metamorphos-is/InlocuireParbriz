<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('vehicle_brand')->nullable()->after('address_text');
            $table->string('vehicle_model')->nullable()->after('vehicle_brand');
            $table->unsignedSmallInteger('vehicle_year')->nullable()->after('vehicle_model');
            $table->string('vehicle_vin', 32)->nullable()->after('vehicle_year');
            $table->string('glass_type', 64)->nullable()->after('vehicle_vin');
            $table->json('glass_features')->nullable()->after('glass_type');
            $table->string('service_location_type', 64)->nullable()->after('glass_features');
            $table->date('preferred_date')->nullable()->after('preferred_schedule');
            $table->string('preferred_time', 64)->nullable()->after('preferred_date');
            $table->string('customer_type', 32)->nullable()->after('preferred_time');
            $table->boolean('insurance_casco')->default(false)->after('customer_type');
            $table->boolean('marketing_consent')->default(false)->after('consent_at');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_brand',
                'vehicle_model',
                'vehicle_year',
                'vehicle_vin',
                'glass_type',
                'glass_features',
                'service_location_type',
                'preferred_date',
                'preferred_time',
                'customer_type',
                'insurance_casco',
                'marketing_consent',
            ]);
        });
    }
};
