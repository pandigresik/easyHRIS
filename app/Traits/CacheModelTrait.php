<?php

namespace App\Traits;

trait CacheModelTrait
{
    protected $rememberCacheTag;
//    protected $rememberCachePrefix;
    protected $rememberFor = 1440; /** in minutes, 60 * 24 */

    // Semua operasi insert dan update melalui Eloquent pada akhirnya
    // akan memanggil method 'save' di Illuminate\Database\Eloquent\Model
    // kita akan override method ini untuk melakukan invalidate sebelum
    // operasi save dilakukan
    public function save(array $options = [])
    {
        $this->invalidateCache();        
        parent::save($options);
    }

    // Semua operasi delete melalui Eloquent pada akhirnya
    // akan memanggil method 'delete' di Illuminate\Database\Eloquent\Model
    // kita akan override method ini untuk melakukan invalidate sebelum
    // operasi delete dilakukan
    public function delete()
    {
        $this->invalidateCache();
        parent::delete();
    }

    // Saat invalidate, kita akan hapus semua cache berdasarkan tag
    protected function invalidateCache()
    {
        // \Log::error('invalidate '.$this->getTag());
        \Cache::tags($this->getTag())->flush();
        //\Cache::prefixs($this->getTag())->flush();
    }

    // kita gunakan nama tabel sebagai tag
    protected function getTag()
    {
        return $this->getTable();
    }
}
