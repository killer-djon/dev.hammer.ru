Ext.define('HM.store.details.DetailsListStore', {
	extend: 'Ext.data.Store',
	requires: [
		'HM.model.details.DetailsListModel'
	],
	autoLoad: true,
	autoSync: false,
	pageSize: 10,
	model: 'HM.model.details.DetailsListModel',
	proxy: {
		type: 'ajax',
		url: 'resources/data/details.json',
		reader: {
			type: 'json',
			rootProperty: 'data'
		}
	},
});