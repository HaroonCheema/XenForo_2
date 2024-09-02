<xf:macro name="order"
          arg-order="!" arg-ordersItems="!" arg-type="!">

    <xf:datarow rowclass="dataList-row--noHover">
        <xf:cell class="dataList-cell--min dataList-cell--image dataList-cell--imageSmall">
            <xf:if is="{$type} == 'seller'">
                <xf:avatar user="$order.Buyer" size="xs" defaultname="{$order.Buyer.username}" />
            <xf:else />
                <xf:avatar user="$order.Seller" size="xs" defaultname="{$order.Seller.username}" />
            </xf:if>
        </xf:cell>
        <xf:cell class="dataList-cell--min"><xf:date time="{$order.purchase_date}" /></xf:cell>
        <xf:cell class="dataList-cell--min">
            <xf:if is="{$type} == 'seller'">
                <xf:username user="$order.Buyer" />
            <xf:else />
                <xf:username user="$order.Seller" />
            </xf:if>
        </xf:cell>
        <xf:cell class="dataList-cell--min">
            {$order.price|currency($order.currency)}
        </xf:cell>
        <xf:cell class="dataList-cell--min">
            <xf:if is="{$order.status} == 'pending'">
                <xf:if is="{$order.Transaction.status} == 'pending'">
                    <span class="label label--skyBlue">{{ phrase('xfa_rmmp_payment_pending') }}</span>
                <xf:else />
                    <span class="label label--skyBlue">{{ phrase('xfa_rmmp_unpaid') }}</span>
                </xf:if>
            <xf:elseif is="{$order.status} == 'validated'" />
                <span class="label label--green">{{ phrase('xfa_rmmp_validated') }}</span>
            <xf:else />
                <span class="label label--gray">{{ phrase('xfa_rmmp_refunded') }}</span>
            </xf:if>
            <xf:if is="{$order.status} == 'validated' AND {$order.SellerData.activate_invoicing}">
                <div class="dataList-secondRow">
                    <a href="{{ link('resources/market-place-order/invoice', $order) }}" target="_blank">({{ phrase('xfa_rmmp_download_invoice') }})</a>
                </div>
            </xf:if>
        </xf:cell>
        <xf:cell class="dataList-cell--min">
            <xf:if is="{$order.shipment_status} == 'pending'">
                <span class="label label--gray">{{ phrase('xfa_rmmp_pending') }}</span>
            <xf:elseif is="{$order.shipment_status} == 'in_preparation'" />
                <span class="label label--yellow">{{ phrase('xfa_rmmp_in_preparation') }}</span>
            <xf:elseif is="{$order.shipment_status} == 'sent'" />
                <span class="label label--skyBlue">{{ phrase('xfa_rmmp_sent') }}</span>
            <xf:elseif is="{$order.shipment_status} == 'delivered'" />
                <span class="label label--green">{{ phrase('xfa_rmmp_delivered') }}</span>
            <xf:else />
                <span class="label label--orange">{{ phrase('xfa_rmmp_na') }}</span>
            </xf:if>
        </xf:cell>
        <xf:action href="#" data-xf-click="toggle" data-target="< :up:next">
            {{ phrase('xfa_rmmp_details') }}
        </xf:action>
		
		 <xf:action href="#" data-xf-click="toggle" data-target="< :up:next">
            {{ phrase('xfa_rmmp_details') }}
        </xf:action>
        <xf:if is="{$type} == 'seller'">
            <xf:popup class="dataList-cell--action"
                      label="{{ phrase('Action') }}">

                <div class="menu" data-menu="menu" aria-hidden="true">
                    <div class="menu-content">
                        <h3 class="menu-header">{{ phrase('Action') }}</h3>
                        <xf:if is="{$order.status} == 'validated'">
                            <a href="{{ link('resources/market-place-order/refund', $order) }}" class="menu-linkRow" data-xf-click="overlay"><i class="fa fa-exchange" aria-hidden="true">&nbsp;</i>{{ phrase('xfa_rmmp_refund_order') }}</a>
                        </xf:if>
                        <xf:if is="in_array($order.Transaction.status, ['initialized', 'pending', 'pending_manual'])">
                            <a href="{{ link('resources/market-place-order/validate', $order) }}" class="menu-linkRow" data-xf-click="overlay"><i class="fa fa-check" aria-hidden="true">&nbsp;</i>{{ phrase('xfa_rmmp_validate') }}</a>
                        </xf:if>
                        <a href="{{ link('resources/market-place-order/delete', $order) }}" class="menu-linkRow" data-xf-click="overlay"><i class="fa fa-times" aria-hidden="true">&nbsp;</i>{{ phrase('delete') }}</a>
                    </div>
                </div>
            </xf:popup>
            <xf:delete class="u-hideMedium" href="{{ link('resources/market-place-order/delete', $order) }}" />
        </xf:if>
    </xf:datarow>
    <xf:datarow rowclass="dataList-collapsibleRow">
        <xf:cell colspan="{{ $type == 'seller' ? '9' : '7' }}">
            <div class="block">
                <div class="block-container">
                    <h3 class="block-header">{{ phrase('xfa_rmmp_order_details') }}</h3>
                    <div class="block-body">
                        <xf:datalist data-xf-init="responsive-data-list">
                            <xf:datarow rowtype="header" rowclass="dataList-row--noHover">
                                <xf:if is="$xf.options.xfrmAllowIcons"><xf:cell></xf:cell></xf:if>
                                <xf:cell>{{ phrase('xfa_rmmp_product') }}</xf:cell>
                                <xf:cell class="dataList-cell--min">{{ phrase('xfa_rmmp_quantity') }}</xf:cell>
                                <xf:cell class="dataList-cell--min">{{ phrase('xfa_rmmp_total') }}</xf:cell>
                            </xf:datarow>
                            <xf:foreach loop="{$ordersItems.{$order.order_id}}" value="$orderItem">
                                <xf:datarow rowClass="dataList-row--noHover">
                                    <xf:if is="$xf.options.xfrmAllowIcons">
                                        <xf:cell class="dataList-cell--min">
                                            {{ resource_icon($orderItem.Resource, 's', link('resources', $orderItem.Resource)) }}
                                        </xf:cell>
                                    </xf:if>
                                    <xf:cell class="dataList-cell--main">
                                        <div class="dataList-mainRow">
                                            <a href="{{ link('resources', $orderItem.Resource) }}" class="" data-tp-primary="on">{$orderItem.Resource.title}</a>
                                            <xf:if is="{$orderItem.Resource.xfa_rmmp_type} == 'digital'">
                                                <div class="dataList-hint">
                                                    <xf:if is="{$orderItem.type} == 'purchase'">
                                                        <i class="fa fa-money" aria-hidden="true"></i> {{ phrase('xfa_rmmp_purchase') }}
                                                    <xf:else />
                                                        <i class="fa fa-refresh" aria-hidden="true"></i> {{ phrase('xfa_rmmp_renewal') }}
                                                    </xf:if>
                                                </div>
                                            </xf:if>
                                        </div>
                                    </xf:cell>
                                    <xf:cell class="dataList-cell--min">{$orderItem.quantity}</xf:cell>
                                    <xf:cell class="dataList-cell--min">{$orderItem.price|currency($orderItem.currency)}</xf:cell>
                                </xf:datarow>
                            </xf:foreach>
                            <xf:if is="{$order.Transaction.shipping} > 0.0">
                                <xf:datarow rowClass="dataList-row--noHover">
                                    <xf:cell></xf:cell>
                                    <xf:cell>{{ phrase('xfa_rmmp_shipping') }}</xf:cell>
                                    <xf:cell class="dataList-cell--min">1</xf:cell>
                                    <xf:cell class="dataList-cell--min">{$order.Transaction.shipping|currency($order.currency)}</xf:cell>
                                </xf:datarow>
                            </xf:if>
                        </xf:datalist>
                    </div>
                    <div class="block-footer">
                        <ul class="listInline listInline--bullet">
                            <li>{{ phrase('xfa_rmmp_order') }} #{$order.order_id}</li>
                            <xf:if is="$order.CouponUsage">
                                <li>
                                    <xf:fa icon="fa-user-tag" title="{{ phrase('xfa_rmmp_coupon')|for_attr }}" />
                                        {{ phrase('xfa_rmmp_coupon:') }} {$order.CouponUsage.Coupon.name}
                                </li>
                            </xf:if>
                            <xf:if is="{$type} != 'buyer' AND {$order.Transaction.txn_id}">
                                <li>
                                    <xf:fa icon="fab fa-paypal" title="{{ phrase('xfa_rmmp_paypal_transaction_id')|for_attr }}" />
                                    {{ phrase('xfa_rmmp_paypal_transaction_id:') }}
                                    <xf:if is="{$xf.options.xfa_rmmp_paypal_testing}">
                                        <a href="http://sandbox.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id={$order.Transaction.txn_id}">{$order.Transaction.txn_id}</a>
                                    <xf:else />
                                        <a href="http://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id={$order.Transaction.txn_id}">{$order.Transaction.txn_id}</a>
                                    </xf:if>
                                </li>
                            </xf:if>
                            <xf:if is="{$order.for_user_id}">
                                <li>
                                    <xf:fa icon="fa-gift" title="{{ phrase('xfa_rmmp_purchased_for')|for_attr }}" />
                                    {{ phrase('xfa_rmmp_purchased_for:') }} <xf:username user="$order.ForUser" defaultname="{$order.for_username}" />
                                </li>
                            </xf:if>
                            <xf:if is="{$order.shipment_status} != 'na'">
                                <li>
                                    <xf:fa icon="fa-truck" title="{{ phrase('xfa_rmmp_shipment_data')|for_attr }}" />
                                    {{ phrase('xfa_rmmp_shipment_data:') }} {$order.shipment_data}
                                </li>
                            </xf:if>
                        </ul>
                    </div>
                </div>
            </div>
            <xf:if is="{$order.shipment_status} != 'na'">
                <xf:if is="{$type} == 'seller'">
                    <div class="block">
                        <div class="block-container">
                            <h3 class="block-header">{{ phrase('xfa_rmmp_shipment_info') }}</h3>
                            <div class="block-body">
                                <xf:textboxrow label="{{ phrase('xfa_rmmp_name') }}" name="name" value="{$order.PurchaseInfo.name}" readonly="readonly" />
                                <xf:textboxrow label="{{ phrase('xfa_rmmp_phone') }}" name="phone" value="{$order.PurchaseInfo.phone}" readonly="readonly" />
                                <xf:textarearow label="{{ phrase('xfa_rmmp_address') }}" name="address" value="{$order.PurchaseInfo.address}" rows="4" readonly="readonly" />
                                <xf:textarearow label="{{ phrase('xfa_rmmp_additional_info') }}" name="additional_info" value="{$order.PurchaseInfo.additional_info}" rows="4" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                </xf:if>
                <xf:form action="{{ link('resources/market-place-order/edit-shipment-status', $order) }}" class="block" ajax="true">
                    <div class="block-container">
                        <h3 class="block-header">{{ phrase('xfa_rmmp_shipment_data') }}</h3>
                        <div class="block-body">
                            <xf:if is="{$type} == 'seller'">
                                <xf:textboxrow label="{{ phrase('xfa_rmmp_shipment_data') }}" name="shipment_data" value="{$order.shipment_data}" explain="{{ phrase('xfa_rmmp_shipment_data_explain') }}" />
                            <xf:else />
                                <xf:textboxrow value="{$order.shipment_data}" readonly="readonly" />
                            </xf:if>
                        </div>
                        <xf:if is="{$type} == 'seller'">
                            <xf:selectrow name="shipment_status" label="{{ phrase('xfa_rmmp_shipment') }}" value="{$order.shipment_status}">
                                <xf:option value="pending" label="{{ phrase('xfa_rmmp_pending') }}" />
                                <xf:option value="in_preparation" label="{{ phrase('xfa_rmmp_in_preparation') }}" />
                                <xf:option value="sent" label="{{ phrase('xfa_rmmp_sent') }}" />
                                <xf:option value="delivered" label="{{ phrase('xfa_rmmp_delivered') }}" />
                            </xf:selectrow>
                            <xf:submitrow icon="save" rowtype="simple" />
                        </xf:if>
                    </div>
                </xf:form>
            </xf:if>
        </xf:cell>
    </xf:datarow>
</xf:macro>

<xf:macro name="order_list_filter_bar" arg-filters="!" arg-baseLinkPath="!" arg-purchaserFilter="{{ null }}">
    <div class="block-filterBar">
        <div class="filterBar">
            <xf:if contentcheck="true">
                <ul class="filterBar-filters">
                    <xf:contentcheck>
                        <xf:if is="$filters.time_period && $filters.time_period != 'all'">
                            <xf:if is="$filters.time_period == 'custom'">
                                <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                       class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                    <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                    {{ phrase('xfa_rmmp_from') }} {{ date($filters.time_period_start, 'Y-m-d') }} - {{ phrase('xfa_rmmp_to') }}  {{ date($filters.time_period_end, 'Y-m-d') }} </a></li>
                                <xf:else />
                                <xf:if is="$filters.time_period == 'current_week'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_current_week') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'previous_week'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_previous_week') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'current_month'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_current_month') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'previous_month'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_previous_month') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'current_quarter'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_current_quarter') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'previous_quarter'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_previous_quarter') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'current_year'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_current_year') }}</a></li>
                                </xf:if>
                                <xf:if is="$filters.time_period == 'previous_year'">
                                    <li><a href="{{ link($baseLinkPath, null, $filters|replace('time_period', 'all')) }}"
                                           class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                        <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_time_period:') }}</span>
                                        {{ phrase('xfa_rmmp_previous_year') }}</a></li>
                                </xf:if>
                            </xf:if>
                        </xf:if>
                        <xf:if is="$filters.status">
                            <li><a href="{{ link($baseLinkPath, null, $filters|replace('status', null)) }}"
                                   class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_status:') }}</span>
                                <xf:if is="$filters.status == 'unpaid'">
                                    {{ phrase('xfa_rmmp_unpaid') }}
                                    <xf:elseif is="$filters.status == 'validated'" />
                                    {{ phrase('xfa_rmmp_validated') }}
                                    <xf:else />
                                    {{ phrase('xfa_rmmp_refunded') }}
                                </xf:if>
                            </a></li>
                        </xf:if>
                        <xf:if is="$filters.shipment_status">
                            <li><a href="{{ link($baseLinkPath, null, $filters|replace('shipment_status', null)) }}"
                                   class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_shipment_status:') }}</span>
                                <xf:if is="$filters.shipment_status == 'pending'">
                                    {{ phrase('xfa_rmmp_pending') }}
                                <xf:elseif is="$filters.shipment_status == 'in_preparation'" />
                                    {{ phrase('xfa_rmmp_in_preparation') }}
                                <xf:elseif is="$filters.shipment_status == 'sent'" />
                                    {{ phrase('xfa_rmmp_sent') }}
                                <xf:else />
                                    {{ phrase('xfa_rmmp_delivered') }}
                                </xf:if>
                            </a></li>
                        </xf:if>
                        <xf:if is="$filters.purchaser_id AND $purchaserFilter">
                            <li><a href="{{ link($baseLinkPath, null, $filters|replace('purchaser_id', null)) }}"
                                   class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('remove_this_filter')|for_attr }}">
                                <span class="filterBar-filterToggle-label">{{ phrase('xfa_rmmp_purchaser:') }}</span>
                                {$purchaserFilter.username}</a></li>
                        </xf:if>
                        <xf:if is="$filters.direction">
                            <li><a href="{{ link($baseLinkPath, null, $filters|replace({'direction': null})) }}"
                                   class="filterBar-filterToggle" data-xf-init="tooltip" title="{{ phrase('return_to_default_order')|for_attr }}">
                                <span class="filterBar-filterToggle-label">{{ phrase('order:') }}</span>
                                <i class="fa {{ $filters.direction == 'asc' ? 'fa-angle-up' : 'fa-angle-down' }}" aria-hidden="true"></i>
                                <span class="u-srOnly"><xf:if is="$filters.direction == 'asc'">{{ phrase('ascending') }}<xf:else />{{ phrase('descending') }}</xf:if></span>
                            </a></li>
                        </xf:if>
                    </xf:contentcheck>
                </ul>
            </xf:if>

            <a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">{{ phrase('filters') }}</a>
            <div class="menu menu--wide" data-menu="menu" aria-hidden="true"
                 data-href="{{ link($baseLinkPath . '/filters', null, $filters) }}"
                 data-load-target=".js-filterMenuBody">
                <div class="menu-content">
                    <h4 class="menu-header">{{ phrase('show_only:') }}</h4>
                    <div class="js-filterMenuBody">
                        <div class="menu-row">{{ phrase('loading...') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xf:macro>

<xf:macro name="order_item_simple" arg-orderItem="!">
    <div class="contentRow">
        <div class="contentRow-figure">
            <xf:if is="$xf.options.xfrmAllowIcons">
                {{ resource_icon($orderItem.Resource, 'xxs', link('resources', $orderItem.Resource)) }}
                <xf:else />
                <xf:avatar user="$orderItem.Resource.User" size="xxs" />
            </xf:if>
        </div>
        <div class="contentRow-main contentRow-main--close">
            <div class="contentRow-extra contentRow-extra--small">{$orderItem.price|currency($orderItem.currency)}</div>
            <a href="{{ link('resources', $orderItem.Resource) }}">{{ prefix('resource', $orderItem.Resource) }}{$orderItem.Resource.title}</a>
            <div class="contentRow-minor contentRow-minor--smaller">
                <ul class="listInline listInline--bullet">
                    <li><xf:username user="$orderItem.Order.Buyer" defaultname="{$orderItem.Order.Buyer.username}" /></li>
                    <li><xf:date time="{$orderItem.Order.purchase_date}" /></li>
                </ul>
            </div>
        </div>
    </div>
</xf:macro>