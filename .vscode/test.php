<xf:if is="{{ property('trakt_tv_posterUpdateButtonPosition') == 'thread_tools_menu' && $thread.traktTV && ($xf.visitor.is_admin || $xf.visitor.is_moderator) }}">
												<a href="{{ link('tv/poster', $thread.traktTV) }}" data-xf-click="overlay" class="menu-linkRow">
													{{ phrase('trakt_tv_check_poster') }}
												</a>
											</xf:if>
											$0