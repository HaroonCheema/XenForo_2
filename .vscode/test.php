<xf:macro name="list"
		  arg-thread="!"
		  arg-forum=""
		  arg-forceRead="{{ false }}"
		  arg-showWatched="{{ true }}"
		  arg-allowInlineMod="{{ true }}"
		  arg-chooseName=""
		  arg-extraInfo=""
		  arg-allowEdit="{{ true }}">
	<xf:css src="structured_list.less" />
	<xf:css src="fs_auction_list_view.less" />

	<style>
		.hiddenDiv {
			display: none;
			position: absolute; 
			left: 0;
			min-width: 85%;  
			background-color: #17202f;
			padding: 10px;
			z-index: 100; 
			border-radius: 5px;
		}

		.onHoverDisp:hover .hiddenDiv {
			display: block;
		}

		.onHoverDisp:hover .hideUpdateImg {
			display: none;
		}

		.dispUpdateSlider {
			display: none;
		}

		.onHoverDisp:hover .dispUpdateSlider {
			display: block;
		}

		.containers {
			position: relative;
			display: flex;
			justify-content: space-between;
			margin: 0 0 20px 0;
			top: 10px;
			padding: 0 10px;
		}

		.onHoverDisp {
			transition: transform 0.15s ease-in-out;
		}
		.onHoverDisp:hover {
			z-index: 1;
		}	

		.slider-container {
			width: 100%;
			max-width: 600px;
			overflow: hidden; 
			position: relative; 
			margin: 5px auto; 
		}

		.slider {
			display: flex;
			transition: transform 0.5s ease-in-out; 
		}

		.slider img {
			width: 100%; 
			flex-shrink: 0; 
			height: 300px; 
			object-fit: cover; 
		}

		.slider img {
			display: none !important;
		}

		.slider img.active {
			display: block !important; 
		}

		.slide-number {
			position: absolute;
			top: 3px;
			left: 7px;
			background: rgba(0, 0, 0, 0.5); 
			color: white;
			padding: 3px 5px;
			border-radius: 3px;
			font-size: 10px;
			font-weight: bold;
		}

		.field_game_title {
			color: #9398a0;
			margin: 0 0 0 5px;
			white-space: nowrap;
		}

		.userNameThread{
			font-size: .85em;
			font-weight: 400;
			line-height: 20px;
			float: right;
		}
	</style>

	<div class="structItem structItem--listing js-inlineModContainer onHoverDisp" data-author="{{ $thread.username ?: '' }}">
		<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded structItem-cell--iconListingCoverImage" style="width: 25%;">
			<div class="structItem-iconContainer">
				<a href="{{ link('threads', $thread) }}" target="{{$xf.visitor.new_tab == 'yes' ? '_blank' : '_self'}}"> 
					<img src="{$thread.getfirstPostImgUrl()}" class="{{count($thread.FirstPost.Attachments) > 1 ? 'hideUpdateImg' : ' '}}" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }} ; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }}; object-fit: cover; border-bottom: solid 2px #fa7d24">
				</a>
				<xf:if is="count($thread.FirstPost.Attachments) > 1">
					<a href="{{ link('threads', $thread) }}" target="{{$xf.visitor.new_tab == 'yes' ? '_blank' : '_self'}}"> 
						<div class="slider-container dispUpdateSlider" id="slider-container">
							<!-- Numbering Display -->
							<div class="slide-number" id="slide-number"></div>
							<div class="slider" id="slider">
								<xf:foreach loop="$thread.FirstPost.Attachments" value="$attachment" i="$i" if="$attachment.has_thumbnail">
									<img src="{$attachment.thumbnail_url}?{{($xf.time + $i)}}" class="{{$i == 1 ? 'active' : ' '}}" alt="{$attachment.filename}" style="width: {{ $thread.Forum.Node.node_thread_thumbnail_width ? $thread.Forum.Node.node_thread_thumbnail_width : $xf.options.thumbnail_width }} ; height: {{ $thread.Forum.Node.node_thread_thumbnail_height ? $thread.Forum.Node.node_thread_thumbnail_height : $xf.options.thumb_size_hemant }}; object-fit: cover; border-bottom: solid 2px #fa7d24" loading="lazy">
								</xf:foreach>
							</div>
						</div>
					</a>
				</xf:if>

			</div>
		</div>


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

			<spam class="containers">
				<spam class="leftDiv">
					<xf:if is="$thread.prefix_id">
						{{ prefix('thread', $thread, 'html', 'noStatus') }}
					</xf:if>
				</spam>
				<spam class="rightDiv">
					<xf:if is="$thread.prefix_id">
						{{ prefix('thread', $thread, 'html', 'isStatus') }} 

						<xf:if is="$xf.options.fs_latest_thread_custom_field_ver && $xf.visitor.version_style == 'small'">
							<spam style="background-color: #3f4043; padding: 0px 6px;">{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_ver}}</spam>
						</xf:if>
					</xf:if>
				</spam>
			</spam>

			<div class="structItem-title" style="margin-top: 12px;">
				<xf:set var="$canPreview" value="{{ $thread.canPreview() }}" />

				<a href="{{ link('threads' . (($thread.isUnread() AND !$forceRead) ? '/unread' : ''), $thread) }}" target="{{$xf.visitor.new_tab == 'yes' ? '_blank' : '_self'}}" class="" data-tp-primary="on" data-xf-init="{{ $canPreview ? 'preview-tooltip' : '' }}" data-preview-url="{{ $canPreview ? link('threads/preview', $thread) : '' }}">{{ snippet($thread.title, 100, {'stripBbCode': true}) }}</a>
				<xf:if is="$xf.options.fs_latest_thread_custom_field_ver && $xf.visitor.version_style == 'large'">
					<spam class="field_game_title">{$thread.custom_fields.{$xf.options.fs_latest_thread_custom_field_ver}}</spam>
				</xf:if>
				<span class="userNameThread">
					<xf:username user="$thread.User" defaultname="{$thread.User}" />
				</span>
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

				</xf:if>
			</div>

			<div class="hiddenDiv" style="margin-bottom: 5px !important; margin-top: 89px;">

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
			</div>

		</div>


	</div>

	<script>
		// Function to initialize sliders
		function initializeSliders() {
			const sliders = document.querySelectorAll('.slider-container');

			sliders.forEach((sliderContainer) => {
				const slider = sliderContainer.querySelector('.slider');
				const images = slider.getElementsByTagName('img');
				const imageCount = images.length;
				let currentIndex = 0;

				const slideNumber = sliderContainer.querySelector('.slide-number');

				function changeSlide(index) {
					for (let img of images) {
						img.classList.remove('active');
					}
					images[index].classList.add('active');
					slideNumber.textContent = `${index + 1}/${imageCount}`;
				}

				sliderContainer.addEventListener('mouseenter', function() {
					currentIndex = 0;
					changeSlide(currentIndex);

					const intervalId = setInterval(() => {
						currentIndex++;
						if (currentIndex >= imageCount) {
							currentIndex = 0;
						}
						changeSlide(currentIndex);
					}, 3000);

					sliderContainer.addEventListener('mouseleave', function() {
						clearInterval(intervalId);
						changeSlide(0);
					}, { once: true });
				});
			});
		}

		// Initialize all sliders on the page
		window.onload = initializeSliders;
	</script>

</xf:macro>