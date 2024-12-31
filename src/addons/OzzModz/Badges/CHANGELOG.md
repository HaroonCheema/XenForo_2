# 2.3.6:
- XF 2.3 support
- Added ability to unfeature stacked badges
- Added option to enable debug mode which can help in identifying badges with slow auto-award criteria
- Reworked the logic of user queue for automatic awarding
- The job scheduler is now persistent to avoid AUTO_INCREMENT overflow in xf_job
- Added option to a change interval between session-based (real-time) user badge updates
- Fixed forced badges stacking causing problems with regular badges
- Added style properties to disable stacked counter and tiers in postbit/member card
- Added `\XF\Entity\User::hasOzzModzBadges($badgeIds)` method 
- Fixed incorrect variables in badge/category icon src-sets

# 2.3.5:

### New features:

Added a badge option to set an external link for a badge, which is applied when clicking on the badge in the postbit and user card.

![badge_link.png](_files%2Fchangelog%2F2.3.5%2Fbadge_link.png)

### Fixes:

Fixed "trying to access array offset on value of type null" error on interrupted user badges rebuild

# 2.3.4:
- Feature: added option to cache stacked counters and display them in members postbit
- Added link to badges tab in member full profile stats block
- Added option to limit max running user badge update jobs at the same time (that triggered by users)
- Added option to limit award message max length
- Added option to display award reason in featured badge list
- Added option to disable stacking badges on member profile tab

# 2.3.0:
- Code refactor
- New feature: badge tiers
- New feature: badge stacks
- Added REST API endpoints
- Added permission to feature any user badge
- Added option to sort featured  badges by badge display order
- Fixed issue when "Max number of featured badges" permission is set to "Unlimited" but was ignored (dependency on "Manage own featured badges")
- Fix: refine featured badges if "Max number of featured badges" permission was changed

# 2.1.1:
- New feature: [bd] Medals importer
- New feature: option to take away badges on member ban
- New feature: Material Design Icon support (disabled by default in add-on options)
- Fix: don't allow awarding revoked badges with criteria for users


# 2.1.0:
This update contains breaking changes

- Added repetitive badges support
- Added caching for badge awarded number
- Added marking alerts read on member badges tab page
- Added badge & badge category icon uploader

# 2.0.0:
- Fixed default permission applying on add-on install
- Added badges caching to escape extra DB queries
- Added style property to change display type for badges in post bit
- Added data importer for [VersoBit] Badges
- Fixed empty page on awarded-list
