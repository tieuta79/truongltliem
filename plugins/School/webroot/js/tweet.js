// jquery.tweet.js - See http://tweet.seaofclouds.com/ or https://github.com/seaofclouds/tweet for more info
// Copyright (c) 2008-2011 Todd Matthews & Steve Purcell
(function(a){if(typeof define==="function"&&define.amd)define(["jquery"],a);else a(jQuery)})(function(a){a.fn.tweet=function(b){function e(a,b){if(typeof a==="string"){var c=a;for(var d in b){var e=b[d];c=c.replace(new RegExp("{"+d+"}","g"),e===null?"":e)}return c}else return a(b)}function f(a,b){return function(){var c=[];this.each(function(){c.push(this.replace(a,b))});return jQuery(c)}}function g(a){return a.replace(/</g,"<").replace(/>/g,"^>")}function h(a,b){return a.replace(d,function(a){var c=/^[a-z]+:/i.test(a)?a:"http://"+a;var d=a;for(var e=0;e<b.length;++e){var f=b[e];if(f.url==c&&f.expanded_url){c=f.expanded_url;d=f.display_url;break}}return'<a href="'+g(c)+'">'+g(d)+"</a>"})}function i(a){return Date.parse(a.replace(/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i,"$1,$2$4$3"))}function j(a){var b=function(a){return parseInt(a,10)};var c=new Date;var d=b((c.getTime()-a)/1e3);if(d<1)d=0;return{days:b(d/86400),hours:b(d/3600),minutes:b(d/60),seconds:b(d)}}function k(a){if(a.days>2)return"about "+a.days+" days ago";if(a.hours>24)return"about a day ago";if(a.hours>2)return"about "+a.hours+" hours ago";if(a.minutes>45)return"about an hour ago";if(a.minutes>2)return"about "+a.minutes+" minutes ago";if(a.seconds>1)return"about "+a.seconds+" seconds ago";return"just now"}function l(a){if(a.match(/^(@([A-Za-z0-9-_]+)) .*/i)){return c.auto_join_text_reply}else if(a.match(d)){return c.auto_join_text_url}else if(a.match(/^((\w+ed)|just) .*/im)){return c.auto_join_text_ed}else if(a.match(/^(\w*ing) .*/i)){return c.auto_join_text_ing}else{return c.auto_join_text_default}}function m(){var a="https:"==document.location.protocol?"https:":"http:";var b=c.fetch===null?c.count:c.fetch;var d="&include_entities=1&callback=?";if(c.list){return a+"//"+c.twitter_api_url+"/1/"+c.username[0]+"/lists/"+c.list+"/statuses.json?page="+c.page+"&per_page="+b+d}else if(c.favorites){return a+"//"+c.twitter_api_url+"/favorites/"+c.username[0]+".json?page="+c.page+"&count="+b+d}else if(c.query===null&&c.username.length==1){return a+"//"+c.twitter_api_url+"/1/statuses/user_timeline.json?screen_name="+c.username[0]+"&count="+b+(c.retweets?"&include_rts=1":"")+"&page="+c.page+d}else{var e=c.query||"from:"+c.username.join(" OR from:");return a+"//"+c.twitter_search_url+"/search.json?&q="+encodeURIComponent(e)+"&rpp="+b+"&page="+c.page+d}}function n(a,b){if(b){return"user"in a?a.user.profile_image_url_https:n(a,false).replace(/^http:\/\/[a-z0-9]{1,3}\.twimg\.com\//,"https://s3.amazonaws.com/twitter_production/")}else{return a.profile_image_url||a.user.profile_image_url}}function o(a){var b={};b.item=a;b.source=a.source;b.screen_name=a.from_user||a.user.screen_name;b.name=a.from_user_name||a.user.name;b.avatar_size=c.avatar_size;b.avatar_url=n(a,document.location.protocol==="https:");b.retweet=typeof a.retweeted_status!="undefined";b.tweet_time=i(a.created_at);b.join_text=c.join_text=="auto"?l(a.text):c.join_text;b.tweet_id=a.id_str;b.twitter_base="http://"+c.twitter_url+"/";b.user_url=b.twitter_base+b.screen_name;b.tweet_url=b.user_url+"/status/"+b.tweet_id;b.reply_url=b.twitter_base+"intent/tweet?in_reply_to="+b.tweet_id;b.retweet_url=b.twitter_base+"intent/retweet?tweet_id="+b.tweet_id;b.favorite_url=b.twitter_base+"intent/favorite?tweet_id="+b.tweet_id;b.retweeted_screen_name=b.retweet&&a.retweeted_status.user.screen_name;b.tweet_relative_time=k(j(b.tweet_time));b.entities=a.entities?(a.entities.urls||[]).concat(a.entities.media||[]):[];b.tweet_raw_text=b.retweet?"RT @"+b.retweeted_screen_name+" "+a.retweeted_status.text:a.text;b.tweet_text=jQuery([h(b.tweet_raw_text,b.entities)]).linkUser().linkHash()[0];b.tweet_text_fancy=jQuery([b.tweet_text]).makeHeart()[0];b.user=e('<a class="tweet_user" href="{user_url}">{screen_name}</a>',b);b.join=c.join_text?e(' <span class="tweet_join">{join_text}</span> ',b):" ";b.avatar=b.avatar_size?e('<a class="tweet_avatar" href="{user_url}"><img src="{avatar_url}" height="{avatar_size}" width="{avatar_size}" alt="{screen_name}\'s avatar" title="{screen_name}\'s avatar" border="0"/></a>',b):"";b.time=e('<span class="tweet_time"><a href="{tweet_url}" title="view tweet on twitter">{tweet_relative_time}</a></span>',b);b.text=e('<span class="tweet_text">{tweet_text_fancy}</span>',b);b.reply_action=e('<a class="tweet_action tweet_reply" href="{reply_url}">reply</a>',b);b.retweet_action=e('<a class="tweet_action tweet_retweet" href="{retweet_url}">retweet</a>',b);b.favorite_action=e('<a class="tweet_action tweet_favorite" href="{favorite_url}">favorite</a>',b);return b}function p(b){var d='<p class="tweet_intro">'+c.intro_text+"</p>";var f='<p class="tweet_outro">'+c.outro_text+"</p>";var g=jQuery('<p class="loading">'+c.loading_text+"</p>");if(c.loading_text)jQuery(b).not(":has(.tweet_list)").empty().append(g);a.getJSON(m(),function(g){var h=jQuery('<ul class="tweet_list">');var i=a.map(g.results||g,o);i=a.grep(i,c.filter).sort(c.comparator).slice(0,c.count);h.append(a.map(i,function(a){return"<li>"+e(c.template,a)+"</li>"}).join("")).children("li:first").addClass("tweet_first").end().children("li:odd").addClass("tweet_even").end().children("li:even").addClass("tweet_odd");jQuery(b).empty().append(h);if(c.intro_text)h.before(d);if(c.outro_text)h.after(f);jQuery(b).trigger("loaded").trigger(i.length===0?"empty":"full");if(c.refresh_interval){window.setTimeout(function(){jQuery(b).trigger("tweet:load")},1e3*c.refresh_interval)}})}var c=a.extend({username:null,list:null,favorites:false,query:null,avatar_size:null,count:3,fetch:null,page:1,retweets:true,intro_text:null,outro_text:null,join_text:null,auto_join_text_default:"I said,",auto_join_text_ed:"I",auto_join_text_ing:"I am",auto_join_text_reply:"I replied to",auto_join_text_url:"I was looking at",loading_text:null,refresh_interval:null,twitter_url:"twitter.com",twitter_api_url:"api.twitter.com",twitter_search_url:"search.twitter.com",template:"{avatar}{time}{join}{text}",comparator:function(a,b){return b["tweet_time"]-a["tweet_time"]},filter:function(a){return true}},b);var d=/\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/gi;a.extend({tweet:{t:e}});a.fn.extend({linkUser:f(/(^|[\W])@(\w+)/gi,'$1<span class="at">@</span><a href="http://'+c.twitter_url+'/$2">$2</a>'),linkHash:f(/(?:^| )[\#]+([\w\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u00ff\u0600-\u06ff]+)/gi,' <a href="http://'+c.twitter_search_url+"/search?q=&tag=$1&lang=all"+(c.username&&c.username.length==1&&!c.list?"&from="+c.username.join("%2BOR%2B"):"")+'" class="tweet_hashtag">#$1</a>'),makeHeart:f(/(<)+[3]/gi,"<tt class='heart'>&#x2665;</tt>")});return this.each(function(a,b){if(c.username&&typeof c.username=="string"){c.username=[c.username]}jQuery(b).unbind("tweet:load").bind("tweet:load",function(){p(b)}).trigger("tweet:load")})}})