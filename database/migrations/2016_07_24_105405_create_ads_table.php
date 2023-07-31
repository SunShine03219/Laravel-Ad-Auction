<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();            
            $table->text('description')->nullable();
            

            // Future Unused
            $table->string('slug')->nullable();
            $table->string('model')->nullable();
            $table->integer('brand_id')->nullable();
            $table->enum('type', ['personal', 'business'])->nullable();            

            // to replace
            $table->decimal('price', 12, 2)->nullable();
            $table->enum('is_negotiable', [0, 1])->nullable();
            $table->date('expired_at')->nullable();            

            // to be deleted
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('seller_email')->nullable();
            $table->string('seller_phone')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('video_url')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();            

            $table->string('category_type')->nullable();
            $table->integer('country_id')->nullable();

            
            //0 =pending for review, 1= published, 2=blocked, 3=archived
            $table->enum('status', [0, 1, 2, 3]);
            $table->enum('price_plan', ['regular', 'premium'])->nullable();
            $table->enum('mark_ad_urgent', ['0', '1'])->nullable();

            $table->integer('view')->nullable();
            $table->integer('max_impression')->nullable();
            $table->integer('user_id')->nullable();


            $table->integer('cat1_id')->nullable();
            $table->integer('cat2_id')->nullable();
            $table->string('cat1_slugpath')->nullable();
            $table->string('cat2_slugpath')->nullable();
            $table->integer('quan')->nullable();

            // ad_condition: 0 =New, 1 =Open box, 2 =Seller refurbished, 3 =Used, 4 =For parts or not working
            $table->tinyInteger('ad_condition')->nullable();
            $table->string('ad_condition_descr')->nullable();
            
            $table->decimal('price_bid',12,2)->nullable();
            $table->decimal('price_reserve',12,2)->nullable();
            $table->decimal('price_buynow',12,2)->nullable();
            $table->integer('price_offer_accept')->nullable();
            $table->tinyInteger('pay_free')->nullable();
            $table->tinyInteger('pay_cash')->nullable();
            $table->tinyInteger('pay_bank')->nullable();
            $table->tinyInteger('pay_cc')->nullable();
            $table->tinyInteger('pay_trade')->nullable();
            $table->tinyInteger('pay_sendinstr')->nullable();
            $table->tinyInteger('auth_users_only')->nullable();

            // pickup_option - 0 =No pick-up, 1 =Pick-up available, 2 =Must pick-up, 3 =Willing to drop-off / deliver
            $table->tinyInteger('pickup_option')->nullable();

            // ship_option - 0 =Free shipping within country, 1 =Calculate courier costs, 2 =Specify shipping costs, 3 =I don't know yet, 4 =Not Applicable
            $table->tinyInteger('ship_option')->nullable();
            $table->tinyInteger('prom_ad_type')->nullable();
            $table->tinyInteger('prom_bold')->nullable();
            $table->tinyInteger('prom_glow')->nullable();
            $table->timestampTz('ad_start_timestamp')->nullable();
            $table->timestampTz('ad_close_timestamp')->nullable();
            $table->decimal('item_dim_h',12,2)->nullable();
            $table->decimal('item_dim_l',12,2)->nullable();
            $table->decimal('item_dim_w',12,2)->nullable();
            $table->decimal('item_weight_kg',12,2)->nullable();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ads');
    }
}
