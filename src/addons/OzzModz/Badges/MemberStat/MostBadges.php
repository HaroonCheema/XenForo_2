<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\MemberStat;

use OzzModz\Badges\Addon as C;
use XF;
use XF\Entity\MemberStat;
use XF\Finder\User;

class MostBadges
{
	public static function getBadgeUsers(MemberStat $memberStat, User $finder)
	{
		$finder->order(C::column('badge_count'), 'DESC');
		$users = $finder->where(C::column('badge_count'), '>', 0)->limit($memberStat->user_limit)->fetch();

		return $users->pluck(function (\XF\Entity\User $user) {
			return [$user->user_id, XF::language()->numberFormat($user->get(C::column('badge_count')))];
		});
	}
}