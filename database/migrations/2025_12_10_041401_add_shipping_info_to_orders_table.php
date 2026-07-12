<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('shipping_address')->nullable()->after('status');
            $table->string('shipping_courier')->nullable()->after('shipping_address'); // JNE, JNT, dll
            $table->decimal('shipping_cost', 15, 0)->default(0)->after('shipping_courier');
            $table->decimal('tax_fee', 15, 0)->default(0)->after('shipping_cost');
            $table->decimal('admin_fee', 15, 0)->default(0)->after('tax_fee');
            // Total Price nanti adalah: Harga Barang + Ongkir + Pajak + Admin
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_address', 'shipping_courier', 'shipping_cost', 'tax_fee', 'admin_fee']);
        });
    }
};
