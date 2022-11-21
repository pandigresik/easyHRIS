<?php

namespace App\Repositories\Base;

use App\Models\Base\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository.
 *
 * @version May 17, 2021, 7:06 am UTC
 */
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
    ];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model.
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $input['password'] = Hash::make($input['password']);
        $model = parent::create($input);
        $roles = $input['roles'] ?? [];
        $model->syncRoles($roles);

        return $model;
    }

    /**
     * Update model record for given id.
     *
     * @param array $input
     * @param int   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $input['employee_id'] = $input['employee_id'] ?? NULL;
        $model = parent::update($input, $id);
        $roles = $input['roles'] ?? [];
        $model->syncRoles($roles);

        return $model;
    }
}
