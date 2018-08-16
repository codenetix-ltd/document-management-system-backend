<?php

namespace App\Repositories;

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentRepositoryEloquent.
 *
 */
class UserRepository extends BaseRepository
{

    /**
     * Override method
     * For setting user password
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        /** @var User $model */
        $entry = $this->getInstance()->newInstance($data);

        // Save password manually because this field in not in fillable list
        $entry->password = $data['password'];
        $entry->save();

        return $this->getInstance()->find($entry->id);
    }

    /**
     * @param Carbon $date
     * @return integer
     */
    public function getUniqueUsersTotalByDate(Carbon $date): int
    {
        return $this->getInstance()->where('last_activity_at', '>', $date)->count();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function touchLastActivityDateTimeByUserId(int $id){
        return $this->update(['lastActivityAt' => Carbon::now()], $id);
    }

    /**
     * @return Model
     */
    protected function getInstance()
    {
        return new User();
    }
}
