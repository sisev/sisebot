window.addEvent('domready', function() {
	if (Browser.ie)
	{
		if (Browser.version < 9)
		{
			response('你竟然在用IE，而且还不是IE9&gt; &lt;……如果不想看到各种血肉模糊的话，快快换个Chrome或Firefox什么的都可以啊');
		}
	}
	
	response('您好，我是华软机器人，想了解我的话就输入“关于”吧！有什么可以帮你么？');
	
	$('ask').addEvent('keypress:keys(enter)', function() {
		if (this.value.length == 0) return;
		var question = this.value;
		this.value = '';
		
		ask(question);
		$('loading').show();
		window.scrollTo(0, $('ask').offsetTop);
		
		new Request.JSON({
			'url': './processer.php',
			'method': 'post',
			'data': { 's': question },
			'secure': false,
			'onSuccess': function(json) {
				$('loading').hide();
				
				if (json.geo)
				{
					response(json.text);
					showMap(json.geo.lg, json.geo.lt, json.geo.keyword);
					response('是这里么？');
				}
				else if (json.weather)
				{
					showWeather(json.weather);
				}
				else
				{
					response(json.text);
				}
				
				window.scrollTo(0, $('ask').offsetTop);
				
				/* 提交统计信息 */
				/*_gaq.push(['_setCustomVar', 1, 'Source', json.statistics.source, 3]);
				_gaq.push(['_setCustomVar', 2, 'Filter', json.statistics.filters[0], 3]);
				_gaq.push(['_trackPageview']);*/
			}
		}).send();
	});
});

function htmlspecialchars(str)
{
	return str.replace(/\<|\>|\"|\'|\&/g, function(chr)
	{
		switch (chr)
		{
			case '<': return "&lt;";
			case '>': return "&gt;";
			case '"': return "&quot;";
			case "'": return "&#39;";
			case '&': return "&amp;";
			default: break;
		}
	});
}

function ask(text)
{
	new Element('div.dialog.question', { 'html': '<div>' + htmlspecialchars(text) + '<span class="qr"></span></div>' }).inject($('stream'));
}

function response(html)
{
	new Element('div.dialog.answer', { 'html': '<div>' + html + '</div>' }).inject($('stream'));
}

function showMap(lg, lt, keyword)
{
	var container = new Element('div.map').inject($('stream'));
	var map = new BMap.Map(container);
	map.enableScrollWheelZoom();
	map.centerAndZoom(new BMap.Point(lg, lt), 11);
	var local = new BMap.LocalSearch(map, {'renderOptions': { 'map': map }});
	local.search(keyword);
}

function showWeather(location)
{
	$('loading').show();
	new Request.JSONP({
		'url': 'http://toy.weather.com.cn/SearchBox/searchBox',
		'method': 'get',
		'callbackKey': 'callback',
		'data': { 'keyword': location },
		'onSuccess': function(jsonp) {
			if (!jsonp.i)
			{
				response('奇怪了，找不到 <strong>' + location + '</strong> 的天气耶…… > <');
				return;
			}
			var cityid = jsonp.i[0].i;
			
			new Request.JSON({
				'url': './weather.php',
				'method': 'post',
				'data': { 'i': cityid },
				'onSuccess': function(json) {
					$('loading').hide();
					response('<strong>' + location + '</strong>现在的天气是：<br />温度: {temp}℃ / 湿度: {SD} / 风向: {WD} / 风力: {WS}'.substitute(json[0].weatherinfo));
				}
			}).send();
		}
	}).send();
}