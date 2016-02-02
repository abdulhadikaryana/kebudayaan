<!-- Start of Woopra Code -->
<script>
(function(){
var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
})("woopra");

woopra.config({
    domain: 'kebudayaanindonesia.net',
    idle_timeout: 1800000
});
woopra.track('pv', {
    url: window.location.pathname+window.location.search,
    title: document.title
});
</script> 

<!-- Start of Woopra Code -->
<script>
(function(){
var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
})("woopra");

woopra.config({
    domain: 'kebudayaanindonesia.net',
    idle_timeout: 1800000
});
// Make sure you identify the visitor before the track() function.
woopra.identify({
   name: '$account.name',
   email: '$account.email',
   company: '$account.company'
});
woopra.track('pv', {
    url: window.location.pathname+window.location.search,
    title: document.title
});
</script> 

<!-- Start of Woopra Code -->
<script>
(function(){
var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
})("woopra");

woopra.config({
    domain: 'kebudayaanindonesia.net',
    idle_timeout: 1800000
});
woopra.track('pv', {
    url: window.location.pathname+window.location.search,
    title: document.title
});
// Send a custom event using the track(eventName, properties) function.
woopra.track('payment', {
    amount: '49.95',
    currency: 'USD'
});
</script> 