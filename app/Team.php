<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'size'];

    public function add($users)
    {
        // guard
        $this->guardAgainstTooManyMembers($users);
        // Diference between on or many saves
        $method = $users instanceof User ? 'save' : 'saveMany';
        // Save on database
        $this->members()->$method($users);
    }

    protected function guardAgainstTooManyMembers($users)
    {
        $numUsersToAdd = ($users instanceof User) ? 1 : count($users);
        $newTeamCount = $this->count() + $numUsersToAdd;
        if($newTeamCount > $this->maximumSize())
            throw new \Exception;
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    public function maximumSize()
    {
        return $this->size;
    }

    public function remove($users = null)
    {
        if($users instanceof User)
            return $users->leaveTeam();
        
        return $this->removeMany($users);
    }

    public function removeMany($users)
    {
        return $this->members()
                    ->whereIn('id', $users->pluck('id'))
                    ->update(['team_id' => null]);
    }

    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }
}
