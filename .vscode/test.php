<xf:macro name="item"
	arg-thread="!"
	arg-forum=""
	arg-forceRead="{{ false }}"
	arg-showWatched="{{ true }}"
	arg-allowInlineMod="{{ true }}"
	arg-chooseName=""
	arg-extraInfo=""
	arg-allowEdit="{{ true }}">

	<xf:css src="structured_list.less" />

	<div class="structItem structItem--thread{{ $thread.prefix_id ? ' is-prefix' . $thread.prefix_id : '' }}{{ $thread.isIgnored() ? ' is-ignored' : '' }}{{ ($thread.isUnread() AND !$forceRead) ? ' is-unread' : '' }}{{ $thread.discussion_state == 'moderated' ? ' is-moderated' : '' }}{{ $thread.discussion_state == 'deleted' ? ' is-deleted' : '' }} js-inlineModContainer js-threadListItem-{$thread.thread_id}" data-author="{{ $thread.User.username ?: $thread.username }}">
		
	<xf:extension name="icon_cell">
		<div class="structItem-cell structItem-cell--icon">
			<div class="structItem-iconContainer">
				<xf:avatar user="$thread.User" size="s" defaultname="{$thread.username}" />
				<xf:if is="$thread.getUserPostCount()">
					<xf:avatar user="$xf.visitor" size="s"
						href=""
						class="avatar--separated structItem-secondaryIcon"
						tabindex="0"
						data-xf-init="tooltip"
						data-trigger="auto"
						title="{{ phrase('you_have_posted_x_messages_in_this_thread', {'count': $thread.getUserPostCount() }) }}" />
				</xf:if>
			</div>
		</div>
	</xf:extension>

	<xf:extension name="main_cell">
		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy" style="padding-top: 3px !important;">
			<xf:if contentcheck="true">
				<ul class="structItem-statuses">
				<xf:contentcheck>
				<xf:extension name="statuses">
					<xf:if is="property('reactionSummaryOnLists') == 'status' && $thread.first_post_reactions">
						<li><xf:reactions summary="true" reactions="{$thread.first_post_reactions}" /></li>
					</xf:if>
					<xf:extension name="before_status_state"></xf:extension>
					<xf:if is="$thread.discussion_state == 'moderated'">
						<li>
							<xf:set var="$moderatedStatus">
								<i class="structItem-status structItem-status--moderated" aria-hidden="true" title="{{ phrase('awaiting_approval')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('awaiting_approval') }}</span>
							</xf:set>
							<xf:if is="$thread.canCleanSpam()">
								<a href="{{ link('spam-cleaner', $thread) }}" data-xf-click="overlay">{$moderatedStatus}</a>
							<xf:else />
								{$moderatedStatus}
							</xf:if>
						</li>
					</xf:if>
					<xf:if is="$thread.discussion_state == 'deleted'">
						<li>
							<i class="structItem-status structItem-status--deleted" aria-hidden="true" title="{{ phrase('deleted')|for_attr }}"></i>
							<span class="u-srOnly">{{ phrase('deleted') }}</span>
						</li>
					</xf:if>
					<xf:if is="!$thread.discussion_open">
						<li>
							<i class="structItem-status structItem-status--locked" aria-hidden="true" title="{{ phrase('locked')|for_attr }}"></i>
							<span class="u-srOnly">{{ phrase('locked') }}</span>
						</li>
					</xf:if>

					<xf:extension name="status_sticky">
						<xf:if is="$thread.sticky">
							<li>
								<i class="structItem-status structItem-status--sticky" aria-hidden="true" title="{{ phrase('sticky')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('sticky') }}</span>
							</li>
						</xf:if>
					</xf:extension>

					<xf:extension name="before_status_watch"></xf:extension>
					<xf:if is="{$showWatched} AND {$xf.visitor.user_id}">
						<xf:if is="{$thread.Watch.{$xf.visitor.user_id}}">
							<li>
								<i class="structItem-status structItem-status--watched" aria-hidden="true" title="{{ phrase('thread_watched')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('thread_watched') }}</span>
							</li>
							<xf:elseif is="!$forum AND {$thread.Forum.Watch.{$xf.visitor.user_id}}" />
							<li>
								<i class="structItem-status structItem-status--watched" aria-hidden="true" title="{{ phrase('forum_watched')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('forum_watched') }}</span>
							</li>
						</xf:if>
					</xf:if>

					<xf:extension name="before_status_type"></xf:extension>
					<xf:if is="$thread.discussion_type == 'redirect'">
						<xf:extension name="thread_type_redirect">
							<li>
								<i class="structItem-status structItem-status--redirect" aria-hidden="true" title="{{ phrase('redirect')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('redirect') }}</span>
							</li>
						</xf:extension>
					<xf:elseif is="$thread.discussion_type == 'question' && $thread.type_data.solution_post_id" />
						<xf:extension name="thread_type_question_solved">
							<li>
								<i class="structItem-status structItem-status--solved" aria-hidden="true" title="{{ phrase('solved')|for_attr }}"></i>
								<span class="u-srOnly">{{ phrase('solved') }}</span>
							</li>
						</xf:extension>
					<xf:elseif is="!$forum || $forum.forum_type_id == 'discussion'" />
						<xf:extension name="thread_type_icon">
							<xf:if is="$thread.discussion_type != 'discussion'">
								<xf:set var="$threadTypeHandler" value="{{ $thread.getTypeHandler() }}" />
								<xf:if is="$threadTypeHandler.getTypeIconClass()">
									<li>
										<xf:set var="$threadTypePhrase" value="{{ $threadTypeHandler.getTypeTitle() }}" />
										<xf:fa class="structItem-status" icon="{{ $threadTypeHandler.getTypeIconClass() }}" title="{$threadTypePhrase|for_attr}" />
										<span class="u-srOnly">{$threadTypePhrase}</span>
									</li>
								</xf:if>
							</xf:if>
						</xf:extension>
					</xf:if>
				</xf:extension>
				</xf:contentcheck>
				</ul>
			</xf:if>

			<div class="structItem-title">
				<xf:set var="$canPreview" value="{{ $thread.canPreview() }}" />
				<xf:if is="$thread.prefix_id">
					<xf:if is="$forum">
						<a href="{{ link('forums', $forum, {'prefix_id': $thread.prefix_id}) }}" class="labelLink" rel="nofollow">{{ prefix('thread', $thread, 'html', '') }}</a>
					<xf:else />
						{{ prefix('thread', $thread, 'html', '') }}
					</xf:if>
				</xf:if>
				<a href="{{ link('threads' . (($thread.isUnread() AND !$forceRead) ? '/unread' : ''), $thread) }}" class="" data-tp-primary="on" data-xf-init="{{ $canPreview ? 'preview-tooltip' : '' }}" data-preview-url="{{ $canPreview ? link('threads/preview', $thread) : '' }}">{$thread.title}</a>
			</div>

			<div class="structItem-minor">
				<xf:if contentcheck="true">
					<ul class="structItem-extraInfo">
					<xf:contentcheck>
						<xf:if is="property('reactionSummaryOnLists') == 'minor_opposite' && $thread.first_post_reactions">
							<li><xf:reactions summary="true" reactions="{$thread.first_post_reactions}" /></li>
						</xf:if>
						<xf:if is="{$extraInfo}">
							<li>{$extraInfo}</li>
						<xf:elseif is="$allowEdit AND $thread.canEdit() AND $thread.canUseInlineModeration()" />
							<xf:if is="!$allowInlineMod OR !$forum">
								<xf:set var="$editParams" value="{{ {
									'_xfNoInlineMod': !$allowInlineMod ? 1 : null,
									 '_xfForumName': !$forum ? 1 : 0
								} }}" />
							<xf:else />
								<xf:set var="$editParams" value="{{ [] }}" />
							</xf:if>
							
						</xf:if>
						
					</xf:contentcheck>
					</ul>
				</xf:if>

				<xf:if is="$thread.discussion_state == 'deleted'">
					<xf:if is="{$extraInfo}"><span class="structItem-extraInfo">{$extraInfo}</span></xf:if>

					<xf:macro template="deletion_macros" name="notice" arg-log="{$thread.DeletionLog}" />
				<xf:else />
					<ul class="structItem-parts">
						<li><xf:username user="$thread.User" defaultname="{$thread.username}" /></li>
						<li class="structItem-startDate"><a href="{{ link('threads', $thread) }}" rel="nofollow"><xf:date time="{$thread.post_date}" /></a></li>
						<xf:if is="!$forum">
							<li><a href="{{ link('forums', $thread.Forum) }}">{$thread.Forum.title}</a></li>
						</xf:if>
					</ul>
				</xf:if>
			</div>
		</div>
	</xf:extension>

	<xf:extension name="meta_cell">
		<div class="structItem-cell structItem-cell--meta" title="{{ phrase('first_message_reaction_score:')|for_attr }} {$thread.first_post_reaction_score|number}">
			<dl class="pairs pairs--justified">
				<dt>{{ phrase('replies') }}</dt>
				<dd>{{ $thread.discussion_type == 'redirect' ? '&ndash;' : $thread.reply_count|number_short }}</dd>
			</dl>
			<dl class="pairs pairs--justified structItem-minor">
				<dt>{{ phrase('views') }}</dt>
				<dd>{{ $thread.discussion_type == 'redirect' ? '&ndash;' : ($thread.view_count > $thread.reply_count ? $thread.view_count|number_short : number_short($thread.reply_count+1)) }}</dd>
			</dl>
		</div>
	</xf:extension>

	<xf:extension name="latest_cell">
		<div class="structItem-cell structItem-cell--latest">
			<xf:if is="$thread.discussion_type == 'redirect'">
				{{ phrase('n_a') }}
			<xf:else />
				<a href="{{ link('threads/latest', $thread) }}" rel="nofollow"><xf:date time="{$thread.last_post_date}" class="structItem-latestDate" /></a>
				<div class="structItem-minor">
					<xf:if is="$xf.visitor.isIgnoring($thread.last_post_user_id)">
						{{ phrase('ignored_member') }}
					<xf:else />
						<xf:username user="{$thread.LastPoster}" defaultname="{$thread.last_post_username}" />
					</xf:if>
				</div>
			</xf:if>
		</div>
	</xf:extension>

	<xf:extension name="icon_end_cell">
		<div class="structItem-cell structItem-cell--icon structItem-cell--iconEnd">
			<div class="structItem-iconContainer">
				<xf:if is="$xf.visitor.isIgnoring($thread.last_post_user_id) OR $thread.discussion_type == 'redirect'">
					<xf:avatar user="{{ null }}" size="xxs" />
				<xf:else />
					<xf:avatar user="{$thread.LastPoster}" defaultname="{$thread.last_post_username}" size="xxs" />
				</xf:if>
			</div>
		</div>
	</xf:extension>

	</div>
</xf:macro>

<xf:macro name="item_new_posts" arg-thread="!">
	<div class="contentRow">
		<div class="contentRow-figure">
			<xf:avatar user="$thread.LastPoster" size="xxs" defaultname="{$thread.last_post_username}" />
		</div>
		<div class="contentRow-main contentRow-main--close">
			<xf:if is="$thread.isUnread()">
				<a href="{{ link('threads/unread', $thread) }}">{{ prefix('thread', $thread) }}{$thread.title}</a>
			<xf:else />
				<a href="{{ link('threads/post', $thread, {'post_id': $thread.last_post_id}) }}">{{ prefix('thread', $thread) }}{$thread.title}</a>
			</xf:if>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>{{ phrase('latest_x', {'name': $thread.last_post_cache.username}) }}</li>
					<li><xf:date time="{$thread.last_post_date}" /></li>
				</ul>
			</div>
			<div class="contentRow-minor contentRow-minor--hideLinks">
				<a href="{{ link('forums', $thread.Forum) }}">{$thread.Forum.title}</a>
			</div>
		</div>
	</div>
</xf:macro>

<xf:macro name="item_new_threads" arg-thread="!">
	<div class="contentRow">
		<div class="contentRow-figure">
			<xf:avatar user="$thread.User" size="xxs" defaultname="{$thread.username}" />
		</div>
		<div class="contentRow-main contentRow-main--close">
			<a href="{{ link('threads', $thread) }}">{{ prefix('thread', $thread) }}{$thread.title}</a>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>{{ phrase('started_by_x', {'name': $thread.username}) }}</li>
					<li><xf:date time="{$thread.post_date}" /></li>
					<li>{{ phrase('replies:') }} {$thread.reply_count|number_short}</li>
				</ul>
			</div>
			<div class="contentRow-minor contentRow-minor--hideLinks">
				<a href="{{ link('forums', $thread.Forum) }}">{$thread.Forum.title}</a>
			</div>
		</div>
	</div>
</xf:macro>

<xf:macro name="quick_thread"
	arg-forum="!"
	arg-page="1"
	arg-order="last_post_date"
	arg-direction="desc"
	arg-prefixes="{{ [] }}">

	<xf:css src="structured_list.less" />

	<xf:if is="$forum.canCreateThread() OR $forum.canCreateThreadPreReg()">

		<xf:js src="xf/thread.js" min="1" />

		<xf:set var="$inlineMode" value="{{ ($page == 1 && $order == 'last_post_date' && $direction == 'desc') ? true : false }}" />

		<xf:form action="{{ link('forums/post-thread', $forum, {'inline-mode': $inlineMode}) }}" ajax="true"
			class="structItem structItem--quickCreate"
			draft="{{ link('forums/draft', $forum) }}"
			data-xf-init="quick-thread"
			data-focus-activate=".js-titleInput"
			data-focus-activate-href="{{ link('forums/post-thread', $forum, {'inline-mode': true}) }}"
			data-focus-activate-target=".js-quickThreadFields"
			data-insert-target=".js-threadList"
			data-replace-target=".js-emptyThreadList">

		<xf:extension name="icon_cell">
			<div class="structItem-cell structItem-cell--icon">
				<div class="structItem-iconContainer">
					<xf:avatar user="$xf.visitor" size="s" />
				</div>
			</div>
		</xf:extension>

		<xf:extension name="main_cell">
			<div class="structItem-cell structItem-cell--newThread js-prefixListenContainer">

				<xf:formrow rowtype="noGutter noLabel fullWidth noPadding mergeNext"
					label="{{ phrase('title') }}">

					<xf:prefixinput maxlength="{{ max_length('XF:Thread', 'title') }}"
						placeholder="{$forum.thread_prompt}"
						title="{{ phrase('post_new_thread_in_this_forum') }}"
						prefix-value="{$forum.default_prefix_id}"
						type="thread"
						prefixes="{$prefixes}"
						data-xf-init="tooltip"
						rows="1"
						help-href="{{ link('forums/prefix-help', $forum) }}"
						help-skip-initial="{{ true }}" />

					<!--[XF:qt_title_after]-->
				</xf:formrow>

				<div class="js-quickThreadFields inserter-container is-hidden"><!--{{ phrase('loading...') }}--></div>
			</div>
		</xf:extension>

		</xf:form>
	</xf:if>

</xf:macro>