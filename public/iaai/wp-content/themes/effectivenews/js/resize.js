jQuery(document).ready(function($) {
$('#increase-font').click(function(event) {
event.preventDefault();
$('.resize').each(function() {
changeTextSize(this, change);
});
});
$('#decrease-font').click(function(event) {
event.preventDefault();
$('.resize').each(function() {
changeTextSize(this, -change);
});
});

var min = 8, max = 100, change = 2;
function changeTextSize(element, value) {
var currentSize = parseFloat($(element).css('font-size'));
var newSize = currentSize + value;
if (newSize <= max && newSize >= min) {
$(element).css('font-size', newSize + 'px');
}
}

});