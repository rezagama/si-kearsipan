//DRAFT FOR POPULATING CATEGORIES

function createCategoriesMap(){
  var parentId = "uniqueId";

  $.ajax({
    url: '/arsip/kategori/',
    type: 'GET',
    data: parentId,
    cache: false,
    dataType: 'json',
    processData: false, // Don't process the files
    contentType: false,
    success: function(data){

    }
  });
}

function createCategoryElement(categoryName, childrenCategories){
  var name = categoryName.toLowerCase();
  var subId = "sub-" + name;
  var liClosingTag = "</li>";
  var ulClosingTag = "</ul>";

  var categoryElement = '<li id="'+ name +'"> <a class="chevron-accordion-toggle collapsed" data-toggle="collapse"' +
  'data-parent="#accordion" href="'+ subId +'"> <i class="fa fa-user"></i>'+ categoryName +'</a> ' +
  '<ul id="'+ subId +'" class="panel-collapse collapse"> <li>'; //children_open_tag_begin

  var categoryElementStd = '<li id="'+ name +'"><i class="fa fa-home"></i> '+ categoryName +'</li>'
}
