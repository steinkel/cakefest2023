<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\UsersTable;
use Authorization\IdentityInterface;
use Cake\ORM\Query\SelectQuery;

/**
 * UsersTable policy
 */
class UsersTablePolicy
{
    /**
     * Check if $user can add UsersTable
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\UsersTable $usersTable
     * @return bool
     */
    public function canIndex(IdentityInterface $user, SelectQuery $usersQuery)
    {
        return true;
    }

    public function scopeIndex(IdentityInterface $user, SelectQuery $query)
    {
        return $query->where(['Users.active' => $user->active]);
    }
}
