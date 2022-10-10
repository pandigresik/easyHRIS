<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ColumnTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $customTypeString = ['enum','type_trivial_name','type_mask', 'type_bestmix_code','type_rm_class','type_dictionary_term','type_username','type_new_external_id','type_external_id', 'type_entity_name','type_entity_address','type_zip_code', 'type_dictionary_id', 'type_email', 'type_document_id', 'type_old_rm_code'];
        $customTypeDecimal = ['type_money_decimal', 'type_mass_decimal'];
        // see https://github.com/laravel/framework/issues/1346
        $platform = DB::getDoctrineSchemaManager()->getDatabasePlatform();
        foreach ($customTypeString as $type) {
            $platform->registerDoctrineTypeMapping($type, 'string');
        }
        foreach ($customTypeDecimal as $type) {
            $platform->registerDoctrineTypeMapping($type, 'decimal');
        }

        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        foreach ($customTypeString as $type) {
            $platform->registerDoctrineTypeMapping($type, 'string');
        }
        foreach ($customTypeDecimal as $type) {
            $platform->registerDoctrineTypeMapping($type, 'decimal');
        }
    }
}
