Ext.define('HM.model.details.DetailsListModel', {
	extend: 'Ext.data.Model',
	
	fields: [
		"id",
		"name",
		"article",
		"clear_article",
		"manufacture",
		"parentName",
		"parentId",
		"groupName",
		"category",
		"link",
		{name: "date_create", type: 'date', dateFormat: 'd.m.Y'},
		"search_article",
	]
});