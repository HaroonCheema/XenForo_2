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

	<style>
		.hiddenDivss {
			display: none;
		}

		.hiddenDiv {
			display: none;
			position: absolute; /* Positioned absolutely to avoid affecting layout */
			top: 0;
			left: 0;
			width: 100%;  /* Make it as wide as the parent div */
			background-color: #fff; /* Slight transparent overlay */
			box-sizing: border-box;
			border: 1px solid #ccc;
			z-index: 10;  /* Place it above the parent div */
		}

		.onHoverDisp {
			transition: transform 0.15s ease-in-out;
		}

		.onHoverDisp:hover {
			transform: scale(1.03);  /* Zoom in */
			z-index: 100;
		}

		.onHoverDisp:hover .hiddenDiv {
			display: block;
		}

		.containers {
			position: relative;
			top: -12px;
			display: flex;
			justify-content: space-between; /* Pushes the divs to opposite sides */
			margin: 0px 7px;
		}
	</style>

	<div class="structItem structItem--thread{{ $thread.prefix_id ? ' is-prefix' . $thread.prefix_id : '' }}{{ $thread.isIgnored() ? ' is-ignored' : '' }}{{ ($thread.isUnread() AND !$forceRead) ? ' is-unread' : '' }}{{ $thread.discussion_state == 'moderated' ? ' is-moderated' : '' }}{{ $thread.discussion_state == 'deleted' ? ' is-deleted' : '' }} js-inlineModContainer js-threadListItem-{$thread.thread_id} onHoverDisp" data-author="{{ $thread.User.username ?: $thread.username }}">

		<xf:extension name="icon_cell">
			<xf:if is="in_array($thread.node_id, $xf.options.node_id_for_thumb)" >
				<xf:if is="$xf.reply.template == 'forum_view'OR $xf.reply.template == 'forum_view_latest_content' OR $xf.reply.template == 'tag_view'">

					<div class="structItem-cell structItem-cell--icon" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }}; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }};">
						<xf:else/>
						<div class="structItem-cell structItem-cell--icon">
							</xf:if>
						<div class="structItem-iconContainer">
							<a href="{{ link('threads', $thread) }}"> 
								<xf:if is="$xf.reply.template == 'forum_view'OR $xf.reply.template == 'forum_view_latest_content' OR $xf.reply.template == 'tag_view'">
									<img src="{$thread.getfirstPostImgUrl()}" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }} ; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }}; object-fit: cover; border-bottom: solid 2px #ec5555;">
									<xf:else/>
									<img src="{$thread.getfirstPostImgUrl()}" class="avatar avatar--square" style="object-fit: cover;">
								</xf:if>
							</a>
							<spam class="containers">
								<spam class="leftDiv">
									<xf:if is="$thread.prefix_id">
										{{ prefix('thread', $thread, 'html', 'noStatus') }}
									</xf:if>
								</spam>
								<spam class="rightDiv">
									<xf:if is="$thread.prefix_id">
										{{ prefix('thread', $thread, 'html', 'isStatus') }} 

										<xf:if is="$xf.options.fs_latest_thread_custom_field_ver">
											<spam style="background-color: #3f4043; padding: 0px 6px;">{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_ver}}</spam>
										</xf:if>
									</xf:if>
								</spam>
							</spam>
						</div>
					</div>
					<xf:else/>
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
				</xf:if>
				</xf:extension>

			<xf:extension name="main_cell">

				<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

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

					<div class="structItem-title" style="margin-top: 12px;">
						<xf:set var="$canPreview" value="{{ $thread.canPreview() }}" />

						<a href="{{ link('threads' . (($thread.isUnread() AND !$forceRead) ? '/unread' : ''), $thread) }}" class="" data-tp-primary="on" data-xf-init="{{ $canPreview ? 'preview-tooltip' : '' }}" data-preview-url="{{ $canPreview ? link('threads/preview', $thread) : '' }}">{{ snippet($thread.title, 25, {'stripBbCode': true}) }}</a>
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
										<xf:if is="$thread.discussion_type != 'redirect'">
											<li class="structItem-extraInfoMinor">
												<a href="{{ link('threads/edit', $thread) }}" data-xf-click="overlay" data-cache="false" data-href="{{ link('threads/edit', $thread, $editParams) }}">
													{{ phrase('edit') }}
												</a>
											</li>
										</xf:if>
									</xf:if>
									<xf:if is="$chooseName">
										<li><xf:checkbox standalone="true">
											<xf:option name="{$chooseName}[]" value="{$thread.thread_id}" class="js-chooseItem" />
											</xf:checkbox></li>
										<xf:elseif is="$allowInlineMod AND $thread.canUseInlineModeration()" />
										<li><xf:checkbox standalone="true">
											<xf:option value="{$thread.thread_id}" class="js-inlineModToggle"
													   data-xf-init="tooltip"
													   title="{{ phrase('select_for_moderation') }}"
													   label="{{ phrase('select_for_moderation') }}"
													   hiddenlabel="true"
													   />
											</xf:checkbox></li>
									</xf:if>
								</xf:contentcheck>
							</ul>
						</xf:if>

						<xf:if is="$thread.discussion_state == 'deleted'">
							<xf:if is="{$extraInfo}"><span class="structItem-extraInfo">{$extraInfo}</span></xf:if>

							<xf:macro template="deletion_macros" name="notice" arg-log="{$thread.DeletionLog}" />
							<xf:else />
							<ul class="structItem-parts">
								<li class="structItem-startDate">
									<xf:fa icon="fas fa-clock" title="{{ phrase('start_date')|for_attr }}" />
									<span class="u-srOnly">{{ phrase('start_date') }}</span>
									<a href="{{ link('threads', $thread) }}" rel="nofollow">{$thread.getTimeStampThread()}</a>
								</li>
								<li>
									<xf:fa icon="fas fa-thumbs-up" /> {$thread.first_post_reaction_score}
								</li>
								<li>
									<xf:fa icon="fas fa-eye" /> {$thread.getViewCountKM()}
								</li>
								<li>
									<xf:fa icon="fas fa-star" /> {$thread.vote_count}
								</li>
							</ul>

							<xf:if is="$thread.discussion_type != 'redirect' && $thread.reply_count >= $xf.options.messagesPerPage && $xf.options.lastPageLinks">
								<span class="structItem-pageJump">
									<xf:foreach loop="{{ last_pages($thread.reply_count + 1, $xf.options.messagesPerPage, $xf.options.lastPageLinks) }}" value="$p">
										<a href="{{ link('threads', $thread, {'page': $p}) }}">{$p}</a>
									</xf:foreach>
								</span>
							</xf:if>

						</xf:if>
					</div>

					<div class="hiddenDiv" style="margin-bottom: 5px !important;">

						<div style="background-color: #fff;">

							<xf:extension name="icon_cells">
								<xf:if is="in_array($thread.node_id, $xf.options.node_id_for_thumb)" >
									<xf:if is="$xf.reply.template == 'forum_view'OR $xf.reply.template == 'forum_view_latest_content' OR $xf.reply.template == 'tag_view'">

										<div class="structItem-cell structItem-cell--icon" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }}; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }};">
											<xf:else/>
											<div class="structItem-cell structItem-cell--icon">
												</xf:if>
											<div class="structItem-iconContainer">
												<a href="{{ link('threads', $thread) }}"> 
													<xf:if is="$xf.reply.template == 'forum_view'OR $xf.reply.template == 'forum_view_latest_content' OR $xf.reply.template == 'tag_view'">
														<img src="{$thread.getfirstPostImgUrl()}" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }} ; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }}; object-fit: cover; border-bottom: solid 2px #ec5555;">
														<xf:else/>
														<img src="{$thread.getfirstPostImgUrl()}" class="avatar avatar--square" style="object-fit: cover;">
													</xf:if>
												</a>
												<spam class="containers">
													<spam class="leftDiv">
														<xf:if is="$thread.prefix_id">
															{{ prefix('thread', $thread, 'html', 'noStatus') }}
														</xf:if>
													</spam>
													<spam class="rightDiv">
														<xf:if is="$thread.prefix_id">
															{{ prefix('thread', $thread, 'html', 'isStatus') }} 

															<xf:if is="$xf.options.fs_latest_thread_custom_field_ver">
																<spam style="background-color: #3f4043; padding: 0px 6px;">{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_ver}}</spam>
															</xf:if>
														</xf:if>
													</spam>
												</spam>
											</div>
										</div>
										<xf:else/>
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
									</xf:if>
									</xf:extension>

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

					<div class="structItem-title" style="margin-top: 12px;">
						<xf:set var="$canPreview" value="{{ $thread.canPreview() }}" />

						<a href="{{ link('threads' . (($thread.isUnread() AND !$forceRead) ? '/unread' : ''), $thread) }}" class="" data-tp-primary="on" data-xf-init="{{ $canPreview ? 'preview-tooltip' : '' }}" data-preview-url="{{ $canPreview ? link('threads/preview', $thread) : '' }}">{{ snippet($thread.title, 25, {'stripBbCode': true}) }}</a>
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
										<xf:if is="$thread.discussion_type != 'redirect'">
											<li class="structItem-extraInfoMinor">
												<a href="{{ link('threads/edit', $thread) }}" data-xf-click="overlay" data-cache="false" data-href="{{ link('threads/edit', $thread, $editParams) }}">
													{{ phrase('edit') }}
												</a>
											</li>
										</xf:if>
									</xf:if>
									<xf:if is="$chooseName">
										<li><xf:checkbox standalone="true">
											<xf:option name="{$chooseName}[]" value="{$thread.thread_id}" class="js-chooseItem" />
											</xf:checkbox></li>
										<xf:elseif is="$allowInlineMod AND $thread.canUseInlineModeration()" />
										<li><xf:checkbox standalone="true">
											<xf:option value="{$thread.thread_id}" class="js-inlineModToggle"
													   data-xf-init="tooltip"
													   title="{{ phrase('select_for_moderation') }}"
													   label="{{ phrase('select_for_moderation') }}"
													   hiddenlabel="true"
													   />
											</xf:checkbox></li>
									</xf:if>
								</xf:contentcheck>
							</ul>
						</xf:if>

						<xf:if is="$thread.discussion_state == 'deleted'">
							<xf:if is="{$extraInfo}"><span class="structItem-extraInfo">{$extraInfo}</span></xf:if>

							<xf:macro template="deletion_macros" name="notice" arg-log="{$thread.DeletionLog}" />
							<xf:else />
							<ul class="structItem-parts">
								<li class="structItem-startDate">
									<xf:fa icon="fas fa-clock" title="{{ phrase('start_date')|for_attr }}" />
									<span class="u-srOnly">{{ phrase('start_date') }}</span>
									<a href="{{ link('threads', $thread) }}" rel="nofollow">{$thread.getTimeStampThread()}</a>
								</li>
								<li>
									<xf:fa icon="fas fa-thumbs-up" /> {$thread.first_post_reaction_score}
								</li>
								<li>
									<xf:fa icon="fas fa-eye" /> {$thread.getViewCountKM()}
								</li>
								<li>
									<xf:fa icon="fas fa-star" /> {$thread.vote_count}
								</li>
							</ul>

							<xf:if is="$thread.discussion_type != 'redirect' && $thread.reply_count >= $xf.options.messagesPerPage && $xf.options.lastPageLinks">
								<span class="structItem-pageJump">
									<xf:foreach loop="{{ last_pages($thread.reply_count + 1, $xf.options.messagesPerPage, $xf.options.lastPageLinks) }}" value="$p">
										<a href="{{ link('threads', $thread, {'page': $p}) }}">{$p}</a>
									</xf:foreach>
								</span>
							</xf:if>

						</xf:if>
					</div>

								<hr class="formRowSep" style="    margin: 10px 0px;;"/>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>


								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>

								<xf:if is="$xf.options.fs_latest_thread_custom_field_game">
									<spam>{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_game}}</spam>
									<br/>
								</xf:if>

								<ul class="structItem-parts">
									<xf:if is="$xf.options.enableTagging AND ($thread.canEditTags() OR $thread.tags)">
										<xf:css src="avForumsTagEss_thread_view_grouped_tags.less" />

										<xf:if is="$thread.GroupedTags">
											<xf:foreach loop="$thread.GroupedTags" key="$categoryId" value="$groupedTagsData">
												<li class="groupedTags">
													<xf:foreach loop="$groupedTagsData.tags" value="$groupedTag">
														<a href="{{ link('tags', $groupedTag) }}" data-xf-init="preview-tooltip" data-preview-url="{{ link('tags/preview', $groupedTag) }}" class="tagItem" dir="auto">{$groupedTag.tag}</a>
													</xf:foreach>
												</li>
											</xf:foreach>
										</xf:if>
									</xf:if>
								</ul>
								</div>
						</div>

					</div>
					</xf:extension>

				<xf:comment>

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

				</xf:comment>

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