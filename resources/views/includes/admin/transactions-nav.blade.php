<ul class="nav nav-pills" style="margin-bottom:30px">
	<li{!! $sub_page == 'insite_all' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'insite', 'amount' => 'all']) }}">Insite Transactions (All)</a></li>
	<li{!! $sub_page == 'insite_incoming' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'insite', 'amount' => 'incoming']) }}">Insite Transactions (Incoming)</a></li>
	<li{!! $sub_page == 'insite_outgoing' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'insite', 'amount' => 'outgoing']) }}">Insite Transactions (Outgoing)</a></li>
	<li{!! $sub_page == 'paypal_all' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'paypal', 'amount' => 'all']) }}">PayPal (All)</a></li>
	<li{!! $sub_page == 'paypal_incoming' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'paypal', 'amount' => 'incoming']) }}">PayPal (Incoming)</a></li>
	<li{!! $sub_page == 'paypal_outgoing' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminTransactions', ['type' => 'paypal', 'amount' => 'outgoing']) }}">PayPal (Outgoing)</a></li>
</ul>