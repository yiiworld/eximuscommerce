
// Process checked categories
$("#productUpdateForm").submit(function(){
	var checked = $("#StoreCategoryTree li.jstree-checked");
	checked.each(function(i, el){
		var cleanId = $(el).attr("id").replace('StoreCategoryTreeNode_', '');
		$("#productUpdateForm").append('<input type="hidden" name="categories[]" value="' + cleanId + '" />');
	});
});

$('#StoreCategoryTree').delegate("a", "click", function (event) {
	$('#StoreCategoryTree').jstree('checkbox').check_node($(this));
	var id = $(this).parent("li").attr('id').replace('StoreCategoryTreeNode_', '');
	$('#main_category').val(id);
});

// Check node
;(function($) {
	$.fn.checkNode = function(id) {
		$(this).bind('loaded.jstree', function () {
			$(this).jstree('checkbox').check_node('#StoreCategoryTreeNode_' + id);
		});
	};
})(jQuery);