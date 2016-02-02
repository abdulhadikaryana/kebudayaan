// jquery.tweet.js - See http://tweet.seaofclouds.com/ or https://github.com/seaofclouds/tweet for more info
// Copyright (c) 2008-2012 Todd Matthews & Steve Purcell
// Modified by Stan Scates for https://github.com/StanScates/Tweet.js-Mod
(function(a){if(typeof define==="function"&&define.amd){define(["jquery"],a)}else{a(jQuery)}}(function(a){a.fn.tweet=function(d){var n=a.extend({modpath:"/twitter/",username:null,list_id:null,list:null,favorites:false,query:null,avatar_size:null,count:3,fetch:null,page:1,retweets:true,intro_text:null,outro_text:null,join_text:null,auto_join_text_default:"i said,",auto_join_text_ed:"i",auto_join_text_ing:"i am",auto_join_text_reply:"i replied to",auto_join_text_url:"i was looking at",loading_text:null,refresh_interval:null,twitter_url:"twitter.com",twitter_api_url:"api.twitter.com",twitter_search_url:"search.twitter.com",template:"{avatar}{time}{join}{text}",comparator:function(p,o){return o.tweet_time-p.tweet_time},filter:function(o){return true}},d);var c=/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/gi;function l(q,r){if(typeof q==="string"){var o=q;for(var p in r){var s=r[p];o=o.replace(new RegExp("{"+p+"}","g"),s===null?"":s)}return o}else{return q(r)}}a.extend({tweet:{t:l}});function f(p,o){return function(){var q=[];this.each(function(){q.push(this.replace(p,o))});return a(q)}}function k(o){return o.replace(/</g,"&lt;").replace(/>/g,"^&gt;")}a.fn.extend({linkUser:f(/(^|[\W])@(\w+)/gi,'$1<span class="at">@</span><a href="http://'+n.twitter_url+'/$2">$2</a>'),linkHash:f(/(?:^| )[\#]+([\w\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u00ff\u0600-\u06ff]+)/gi,' <a href="http://'+n.twitter_search_url+"/search?q=&tag=$1&lang=all"+((n.username&&n.username.length==1&&!n.list)?"&from="+n.username.join("%2BOR%2B"):"")+'" class="tweet_hashtag">#$1</a>'),makeHeart:f(/(&lt;)+[3]/gi,"<tt class='heart'>&#x2665;</tt>")});function e(p,o){return p.replace(c,function(s){var r=(/^[a-z]+:/i).test(s)?s:"http://"+s;var u=s;for(var t=0;t<o.length;++t){var q=o[t];if(q.url==r&&q.expanded_url){r=q.expanded_url;u=q.display_url;break}}return'<a href="'+k(r)+'">'+k(u)+"</a>"})}function j(o){return Date.parse(o.replace(/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i,"$1,$2$4$3"))}function h(o){var q=(arguments.length>1)?arguments[1]:new Date();var s=parseInt((q.getTime()-o)/1000,10);var p="";if(s<1){p="just now"}else{if(s<60){p=s+" seconds ago"}else{if(s<120){p="about a minute ago"}else{if(s<(45*60)){p="about "+(parseInt(s/60,10)).toString()+" minutes ago"}else{if(s<(2*60*60)){p="about an hour ago"}else{if(s<(24*60*60)){p="about "+(parseInt(s/3600,10)).toString()+" hours ago"}else{if(s<(48*60*60)){p="about a day ago"}else{p="about "+(parseInt(s/86400,10)).toString()+" days ago"}}}}}}}return p}function g(o){if(o.match(/^(@([A-Za-z0-9-_]+)) .*/i)){return n.auto_join_text_reply}else{if(o.match(c)){return n.auto_join_text_url}else{if(o.match(/^((\w+ed)|just) .*/im)){return n.auto_join_text_ed}else{if(o.match(/^(\w*ing) .*/i)){return n.auto_join_text_ing}else{return n.auto_join_text_default}}}}}function b(){var o=n.modpath,p=(n.fetch===null)?n.count:n.fetch,r={include_entities:1};if(n.list){return{host:n.twitter_api_url,url:"/1.1/lists/statuses.json",parameters:a.extend({},r,{list_id:n.list_id,slug:n.list,owner_screen_name:n.username,page:n.page,count:p,include_rts:(n.retweets?1:0)})}}else{if(n.favorites){return{host:n.twitter_api_url,url:"/1.1/favorites/list.json",parameters:a.extend({},r,{list_id:n.list_id,screen_name:n.username,page:n.page,count:p})}}else{if(n.query===null&&n.username.length===1){return{host:n.twitter_api_url,url:"/1.1/statuses/user_timeline.json",parameters:a.extend({},r,{screen_name:n.username,page:n.page,count:p,include_rts:(n.retweets?1:0)})}}else{var q=(n.query||"from:"+n.username.join(" OR from:"));return{host:n.twitter_search_url,url:"/search.json",parameters:a.extend({},r,{page:n.page,q:q,rpp:p})}}}}}function m(o,p){if(p){return("user" in o)?o.user.profile_image_url_https:m(o,false).replace(/^http:\/\/[a-z0-9]{1,3}\.twimg\.com\//,"https://s3.amazonaws.com/twitter_production/")}else{return o.profile_image_url||o.user.profile_image_url}}function i(p){var q={};q.item=p;q.source=p.source;q.name=p.from_user_name||p.user.name;q.screen_name=p.from_user||p.user.screen_name;q.avatar_size=n.avatar_size;q.avatar_url=m(p,(document.location.protocol==="https:"));q.retweet=typeof(p.retweeted_status)!="undefined";q.tweet_time=j(p.created_at);q.join_text=n.join_text=="auto"?g(p.text):n.join_text;q.tweet_id=p.id_str;q.twitter_base="http://"+n.twitter_url+"/";q.user_url=q.twitter_base+q.screen_name;q.tweet_url=q.user_url+"/status/"+q.tweet_id;q.reply_url=q.twitter_base+"intent/tweet?in_reply_to="+q.tweet_id;q.retweet_url=q.twitter_base+"intent/retweet?tweet_id="+q.tweet_id;q.favorite_url=q.twitter_base+"intent/favorite?tweet_id="+q.tweet_id;q.retweeted_screen_name=q.retweet&&p.retweeted_status.user.screen_name;q.tweet_relative_time=h(q.tweet_time);q.entities=p.entities?(p.entities.urls||[]).concat(p.entities.media||[]):[];q.tweet_raw_text=q.retweet?("RT @"+q.retweeted_screen_name+" "+p.retweeted_status.text):p.text;q.tweet_text=a([e(q.tweet_raw_text,q.entities)]).linkUser().linkHash()[0];q.tweet_text_fancy=a([q.tweet_text]).makeHeart()[0];q.user=l('<a class="tweet_user" href="{user_url}">{screen_name}</a>',q);q.join=n.join_text?l(' <span class="tweet_join">{join_text}</span> ',q):" ";q.avatar=q.avatar_size?l('<a class="tweet_avatar" href="{user_url}"><img src="{avatar_url}" height="{avatar_size}" width="{avatar_size}" alt="{screen_name}\'s avatar" title="{screen_name}\'s avatar" border="0"/></a>',q):"";q.time=l('<span class="tweet_time"><a href="{tweet_url}" title="view tweet on twitter">{tweet_relative_time}</a></span>',q);q.text=l('<span class="tweet_text">{tweet_text_fancy}</span>',q);q.reply_action=l('<a class="tweet_action tweet_reply" href="{reply_url}">reply</a>',q);q.retweet_action=l('<a class="tweet_action tweet_retweet" href="{retweet_url}">retweet</a>',q);q.favorite_action=l('<a class="tweet_action tweet_favorite" href="{favorite_url}">favorite</a>',q);return q}return this.each(function(p,s){var r=a('<ul class="tweet_list">');var q='<p class="tweet_intro">'+n.intro_text+"</p>";var o='<p class="tweet_outro">'+n.outro_text+"</p>";var t=a('<p class="loading">'+n.loading_text+"</p>");if(n.username&&typeof(n.username)=="string"){n.username=[n.username]}a(s).unbind("tweet:load").bind("tweet:load",function(){if(n.loading_text){a(s).empty().append(t)}a.ajax({dataType:"json",type:"post",async:false,url:n.modpath||"/twitter/",data:{request:b()},success:function(w,u){if(w.message){console.log(w.message)}var v=w.response;a(s).empty().append(r);if(n.intro_text){r.before(q)}r.empty();if(v.statuses!==undefined){resp=v.statuses}else{if(v.results!==undefined){resp=v.results}else{resp=v}}var x=a.map(resp,i);x=a.grep(x,n.filter).sort(n.comparator).slice(0,n.count);r.append(a.map(x,function(y){return"<li>"+l(n.template,y)+"</li>"}).join("")).children("li:first").addClass("tweet_first").end().children("li:odd").addClass("tweet_even").end().children("li:even").addClass("tweet_odd");if(n.outro_text){r.after(o)}a(s).trigger("loaded").trigger((x?"empty":"full"));if(n.refresh_interval){window.setTimeout(function(){a(s).trigger("tweet:load")},1000*n.refresh_interval)}}})}).trigger("tweet:load")})}}));